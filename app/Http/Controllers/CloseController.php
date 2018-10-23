<?php

namespace App\Http\Controllers;

use App\Factura;
use App\Costo;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Events\Facturas\FacturaProgress;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

class CloseController extends Controller
{
    public function index()
    {
        $listFact = Factura::where('status', 'por procesar')->get(['fact_day'])->groupBy(function($date) {
            return Carbon::parse($date->fact_day)->format('Y-m-d'); // grouping by months
            })->keys()
        ;

        $keyed = $listFact->keyBy(function ($item) {
                //dd($item);
                return $item;
            });

    	return view('facturas.close2u', ['listaFactura' => $keyed]);
    }

    public function getfact(Request $request)
    {
    	if ($request->crit && $request->filter != null) {
          switch ($request->crit) {
            case 1:
              $facturas = Factura::with('proveedors')->whereHas('proveedors', function($item) use ($request){
                $item->where('company_id', 'like', '%'.$request->filter.'%');
              });
              
              break;
            case 2:
              $facturas = Factura::with('proveedors')->whereHas('proveedors', function($item) use ($request){
                $item->where('company_name', 'like', '%'.$request->filter.'%');
              });
              break;
            case 3:
              $facturas = Factura::with('proveedors')->whereHas('proveedors', function($item) use ($request){
                $item->where('tax_code', 'like', '%'.$request->filter.'%');
              });
              break;
          }
              return response()->json($facturas->paginate(10));
        }else{
          $facturas = Factura::with('proveedors')->where('verify', 'por verificar')->orWhere('verify', 'verificada')->getFresh();
        }

        switch ($request->sort) {
          case 'fact_day|desc':
            $facturas->orderBy('fact_day', 'desc');
            break;
          case 'fact_day|asc':
            $facturas->orderBy('fact_day', 'asc');
            break;
          case 'verify|asc':
            $facturas->orderBy('verify', 'asc');
            break;
          case 'verify|desc':
            $facturas->orderBy('verify', 'desc');
            break;
          default:
            $facturas->orderBy('_id', 'desc');
            break;
        }
       
         return response()->json($facturas->paginate(10));
    }

    public function getFacturas(Request $request)
    {
        //return response()->json($request->all());

        //dd($request->all());
        $now = new Carbon('now');
        $dt = Carbon::parse($request->data);

        $fact = Factura::with('proveedors')
            ->where('fact_day', '>', new \DateTime($dt))
            ->where('fact_day', '<', new \DateTime($dt->addDay()))
            ->where('status', 'por procesar')
            ->get();

        if ($fact->count() > 0) {
            foreach ($fact as $facts) {
                //dd($facts);
                $facturas[] = array(
                    'Año' => (string)$facts->year,
                    'Semana' => (string)$facts->week,
                    'Company ID' => $facts->proveedors()->first()->company_id,
                    'Company Name' => $facts->proveedors()->first()->company_name,
                    'Email' => $facts->proveedors()->first()->company_email,
                    'Company_tax_code' => $facts->proveedors()->first()->tax_code,
                    'Base Imponible' => (double)$facts->base_imponible,
                    'iva' => (double)$facts->iva,
                    'Total a facturar' => (double)$facts->total_fact,
                    'payout_1' => (double)$facts->payout_1,
                    'payout_2' => (double)$facts->payout_2,
                    'payout_3' => (double)$facts->payout_3,
                    'payout_4' => (double)$facts->payout_4,
                    'payout_5' => (double)$facts->payout_5,
                    'payout_6' => (double)$facts->payout_6,
                    'payout_7' => (double)$facts->payout_7,
                    'payout_8' => (double)$facts->payout_8,
                    'payout_9' => (double)$facts->payout_9,
                    'payout_10' => (double)$facts->payout_10,
                    'total pagar' => (double)$facts->total_pay,
                    'voucher_type' => 'Fact. Electronica'
                );
            }

            $fileName = 'facturas'.$request->data;
            \Excel::create($fileName, function($excel) use ($facturas){

                $excel->sheet('sheet', function($sheet) use ($facturas)
                {
                    //$sheet->fromArray($fact);
                    //dd($fact);
                    $sheet->setColumnFormat(array(
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
                    ));
                    
                    $sheet->fromArray($facturas, null, 'A1', false, true);


                    
                });
            })->store('xlsx', storage_path('app/public/facturasClose2u/'));

            return response()->json(Storage::url('facturasClose2u/'.$fileName.'.xlsx'));
        }else{
            //pendiente de la ruta que queda vista en la barra url
            //return view('facturas.close2u')->with(['message', 'no se encontraron registros']);
            return response()->json('no es un archivo valido');
        }

        //return back();
    }

    public function setFacts()
    {
        //return response()->json($request->all());

        $now = new Carbon('now');

        $costos = Costo::with(['proveedors', 'drivers'])->select('costos.*')->get();

        
            foreach ($costos as $cost) {
                //dd($cost);
                $costosArr[] = array(
                    'Año' => (string)$cost->year,
                    'Semana' => (string)$cost->week,
                    'Company ID' => $cost->proveedors()->first()->company_id,
                    'Driver ID' => $cost->drivers()->first()->driver_id,
                    'Costo' => (double)$cost->costo,
                    'Base Imponible' => (double)$cost->base_imponible,
                    'iva' => (double)$cost->iva,
                    'Total a facturar' => (double)$cost->total_factura,
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
                    'total pagar' => (double)$cost->total_pay,
                    'voucher_type' => 'Fact. Electronica'
                );
            }

            //dd($costosArr);
            //dd($facturas);
            return \Excel::create('facturas', function($excel) use ($costosArr){

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

    public function importExcel(Request $request)
    {
    	//dd($request->all());

        $this->validate($request, array(
            'file'      => 'required'
        ));

        $file = $request->file('file');

       
        //dd($file);
        //$proveedors = Proveedor::all();

        //dd($proveedors->search('company_id', 'pymnlmckeonevoctdjhqvssuljaeywap'));

        \Excel::load($file, function($reader) {

                $results = $reader->get();

                $user = Auth::user();

                $current = 0;
                $max = $results->count();
                $message = array('max' => $max);
                broadcast(new FacturaProgress($user, $message));

              	foreach ($results as $row) {
                    $current++;

                    $fact = Factura::with('proveedors')->whereHas('proveedors', function($query) use ($row){
                        $query->where('tax_code', $row->ruc);
                    })->where('status', 'por procesar')->get();


                    $factura = $fact->where('total_pay', $row->monto_total);

                    //dd($factura->total_pay);

                    foreach ($factura as $facts) {
                        //dd($facts->total_pay);
                        $facts->verify = 'verificada';
                        $facts->status = 'por pagar';
                        $facts->save();
                    }

                    switch ($current) {
                    case ($current == 1):
                      $message = array('current' => $current);
                      broadcast(new FacturaProgress($user, $message));
                      break;
                    case ($current > 1 && $current < 10):
                      if ($current%2==0) {
                        $message = array('current' => $current);
                        broadcast(new FacturaProgress($user, $message));
                      }
                      break;
                    case ($current > 10 && $current < 100):
                      if ($current%10==0) {
                        $message = array('current' => $current);
                        broadcast(new FacturaProgress($user, $message));
                      }
                      break;
                    case ($current > 100 && $current < 500):
                      if ($current%50==0) {
                        $message = array('current' => $current);
                        broadcast(new FacturaProgress($user, $message));
                      }
                      break;
                    case ($current > 1000 && $current < 1500):
                      if ($current%100==0) {
                        $message = array('current' => $current);
                        broadcast(new FacturaProgress($user, $message));
                      }
                      break;
                    case ($current > 1500 && $current < 2500):
                      if ($current%300==0) {
                        $message = array('current' => $current);
                        broadcast(new FacturaProgress($user, $message));
                      }
                      break;
                    case ($current > 2500 && $current < 4000):
                      if ($current%500==0) {
                        $message = array('current' => $current);
                        broadcast(new FacturaProgress($user, $message));
                      }
                      break;
                    case ($current > 4000 && $current < 9000):
                      if ($current%700==0) {
                        $message = array('current' => $current);
                        broadcast(new FacturaProgress($user, $message));
                      }
                      break;
                    case ($current > 9000):
                      if ($current%900==0) {
                        $message = array('current' => $current);
                        broadcast(new FacturaProgress($user, $message));
                      }
                      break;
                    }
                }

                if ($current == $max['max']) {
                        broadcast(new FacturaProgress($user, $message));
                    }    

                $close = array('close' => true);

                broadcast(new FacturaProgress($user, $close));
        });

        return response()->json('listo');
    }
}
