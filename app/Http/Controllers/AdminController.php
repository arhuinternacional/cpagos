<?php

namespace App\Http\Controllers;

use App\Costo;
use App\Charts\Dashboard;
use App\Pago;
use App\Factura;
use App\User;
use App\Driver;
use App\Proveedor;
use Carbon\Carbon;
use Illuminate\Support\Collection as Collect;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dt = new Carbon('now');

        for ($i=1; $i < $dt->weekNumberInMonth+1; $i++) { 
            $lbls[] = 'Semana '.$i;
        }

        $cost = Costo::where('fecha_upload', '<', new \DateTime($dt))
                     ->where('fecha_upload', '<', new \DateTime($dt->addMonth()))
                     ->get()->groupBy(function($date) {
                        return Carbon::parse($date->fecha_upload)->format('W'); // grouping by months
                });


        if ($cost->isEmpty()) {
            $chart = null;
        }else{
            $chart = new Dashboard;
            foreach ($cost as $costos) {
                $new[] = array(
                    round($costos->sum('total_pay'), 2)
                );
            }
            $chart->labels($lbls)->options(['legend' => ['display' => true]]);
            $chart->dataset('Costos', 'bar', $new)->color('#ffffff');
        }
        return view('admin', ['chart' => $chart, 'dates' => $dt]);
    }

    public function dashboard(Request $request)
    {
        $dt = new Carbon('now');

        $prove = Proveedor::getFresh();
        $factura = Factura::getFresh();
        $cost = Costo::getFresh();
        $driv = Driver::getFresh();

        $costMonth = Costo::where('fecha_upload', '>', new \DateTime($dt->minute(0)->hour(0)->second(0)))
                          ->where('fecha_upload', '<', new \DateTime($dt->addMonth()))
                          ->get()
                          ->sum('total_pay');
        $dashboard = collect([
            'proveedors' => $prove->count(),
            'drivers' => $driv->count(),
            'costos' => isset($costMonth) ? round($costMonth, 2) : '0' 
        ]);

        $listProv = $prove->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('m'); // grouping by months
                })
            ;
        return response()->json($dashboard);
    }

    public function test()
    {

        $now = new Carbon('now');

        $costos = Costo::with(['proveedores', 'drivers'])->get();

        $costosArr = new collect;
        
            foreach ($costos as $cost) {
                $costosArr->push(array(
                    'Año' => (string)$cost->year,
                    'Semana' => (string)$cost->week,
                    'Company ID' => $cost->proveedores()->first()->company_id,
                    'Driver ID' => $cost->drivers()->first()->driver,
                    'Cost' => (double)$cost->costo,
                    'Base Imponible' => (double)$cost->base_imponible,
                    'iva' => (double)$cost->iva,
                    'Monto Total a Facturar (calculado)' => (double)$cost->total_factura,
                    'payout_1' => (double)$cost->payout_1,
                    'payout_2' => (double)$cost->payout_2,
                    'payout_3' => (double)$cost->payout_3,
                    'payout_4' => (double)$cost->payout_4,
                    'payout_5' => (double)$cost->payout_5,
                    'payout_6' => (double)$cost->payout_6,
                    'payout_7' => (double)$cost->payout_7,
                    'payout_8' => (double)$cost->payout_8,
                    'payout_9' => (double)$cost->payout_9,
                    'payout_10' => (double)$cost->payout_10,
                    'Monto Total a Pagar (calculado)' => (double)$cost->total_pay,
                    'voucher_type' => 'Fact. Electronica'
                ));
            }
            
            return \Excel::create('costos', function($excel) use ($costosArr){

                $excel->sheet('registros', function($sheet) use ($costosArr)
                {
                    //$sheet->fromArray($fact);
                    //dd($fact);
                    /*$sheet->setColumnFormat(array(
                        'A' => '@',
                        'B' => '@',
                        'C' => '@',
                        'D' => '@',
                        'E' => '@',
                        'F' => '@',
                        'G' => '0.00',
                        'H' => '0.00',
                        'I' => '0.00',
                        'J' => '0.00',
                        'K' => '0.00',
                        'L' => '0.00',
                        'M' => '0.00',
                        'N' => '0.00',
                        'O' => '0.00',
                        'P' => '0.00',
                        'Q' => '0.00',
                        'R' => '0.00',
                        'S' => '0.00',
                        'T' => '0.00',
                        'U' => '@'
                    ));*/
                    
                    $sheet->fromArray($costosArr, null, 'A1', false, true);
                });
            })->download('xls');
    }

    public function testing()
        {
            $dt = Carbon::now();

            $costMonth = Costo::where('fecha_upload', '>', new \DateTime($dt->minute(0)->hour(0)->second(0)))
                          ->where('fecha_upload', '<', new \DateTime($dt->addMonth()))
                          ->get()
                          ->pluck('fecha_upload')
                          ;

            dd($costMonth->toArray());
        }    

    public function fetch()
    {
        return Factura::select('facturas.*')->get();
    }
}
