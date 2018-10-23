<?php

namespace App\Http\Controllers;

use App\Factura;
use App\Costo;
use App\Proveedor;
use App\FacturaIncident;
use Illuminate\Support\Facades\Storage;
use App\Events\Facturas\FacturaEvent;
use App\Events\Facturas\FacturaProgress;
use Yajra\Datatables\Datatables;
use Auth;
use Illuminate\Support\Collection;
use Response;
use App\Pago;
use App\Driver;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class FacturasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $listCost = Costo::where('status', 'por procesar')->select('costos.fecha_upload')->get()->groupBy(function($date) {
                return Carbon::parse($date->fecha_upload)->format('Y-m-d'); // grouping by months
                })->keys()
            ;

        $listFact = Factura::where('f_status', 'por procesar')->select('facturas.fact_day')->get()->groupBy(function($date) {
            return Carbon::parse($date->fact_day)->format('Y-m-d'); // grouping by months
            })->keys()
        ;

         $keyed = $listFact->keyBy(function ($item) {
                //dd($item);
                return $item;
            });

        return view('facturas.index', ['listaCosto' => $listCost, 'listaFactura' => $keyed]);
    }

    public function lists(Request $request)
    {
        //return response()->json($request->all());
        if ($request->listGen) {
            $listFact = Factura::where('status', 'por procesar')->get(['fact_day'])->groupBy(function($date) {
            return Carbon::parse($date->fact_day)->format('Y-m-d'); // grouping by months
            })->sort()->keys()
        ;
            return $listFact;
        }

        if ($request->listCost) {
            $listCost = Costo::where('status', 'por procesar')->get(['fecha_upload'])->groupBy(function($date) {
                return Carbon::parse($date->fecha_upload)->format('Y-m-d'); // grouping by months
                })->sort()->keys()
            ;
          return $listCost;
        }
        
    }

    public function facturas(Request $request)
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
          $facturas = Factura::with('proveedors')->getFresh();
        }

        switch ($request->sort) {
          case 'costo|desc':
            $facturas->orderBy('costo', 'desc');
            break;
          case 'costo|asc':
            $facturas->orderBy('costo', 'asc');
            break;
          case 'total_factura|asc':
            $facturas->orderBy('total_factura', 'asc');
            break;
          case 'total_factura|desc':
            $facturas->orderBy('total_factura', 'desc');
            break;
          case 'total_pay|asc':
            $facturas->orderBy('total_pay', 'asc');
            break;
          case 'total_pay|desc':
            $facturas->orderBy('total_pay', 'desc');
            break;
          case 'week|asc':
            $facturas->orderBy('week', 'asc');
            break;
          case 'week|desc':
            $facturas->orderBy('week', 'desc');
            break;
          case 'year|asc':
            $facturas->orderBy('year', 'asc');
            break;
          case 'year|desc':
            $facturas->orderBy('year', 'desc');
            break;
          case 'status|asc':
            $facturas->orderBy('status', 'asc');
            break;
          case 'status|desc':
            $facturas->orderBy('status', 'desc');
            break;
          case 'fecha_upload|asc':
            $facturas->orderBy('fecha_upload', 'asc');
            break;
          case 'fecha_upload|desc':
            $facturas->orderBy('fecha_upload', 'desc');
            break;
          default:
            $facturas->orderBy('_id', 'desc');
            break;
        }
       
         return response()->json($facturas->paginate(10));
    }

    public function test()
    {
        $prov = Proveedor::with('drivers')->select('proveedors.*')->has('drivers')->inRandomOrder()->first()->id;

        //$driver = $prov->drivers->random()->id;

        return response()->json($prov);
    }

    

    public function generateFact(Request $request)
    {
        $user = Auth::user();

        $dt = new Carbon('now');

        //return response()->json($request->all());

        if ($request->listAll) {
            $costos = Costo::with(['proveedores'])
            ->where('status', 'por procesar')
            ->whereHas('proveedores', function($query){
                $query->where('company_notes', true);
            })->get()->groupBy('proveedores_id');

            $costosNV = Costo::with(['proveedores'])
            ->where('status', 'por procesar')
            ->whereHas('proveedores', function($query){
                $query->where('company_notes', false);
            })->get()->groupBy('proveedores_id');
        }
        if ($request->listGen){
            $costos = Costo::with(['proveedores'])->where('fecha_upload', Carbon::parse($request->fecha))
                ->where('status', 'por procesar')
                ->whereHas('proveedores', function($query){
                    $query->where('company_notes', true);
                })->get()->groupBy('proveedores_id');

            $costosNV = Costo::with(['proveedores'])->where('fecha_upload', Carbon::parse($request->fecha))
                ->where('status', 'por procesar')
                ->whereHas('proveedores', function($query){
                    $query->where('company_notes', false);
                })->get()->groupBy('proveedores_id');
        }
            $successCount = 0;
            $warningsCount = 0;
            $failsCount = 0;
            $warnings = new Collection;
            $current = 0;
            $max = array('max' => intval($costos->count()+$costosNV->count()));

            broadcast(new FacturaProgress($user, $max));


        try {
            foreach ($costos as $costo) {

                
                $factnro = Factura::where('proveedores_id', $costo->first()->proveedores_id)->where('fact_type', 'generada')->get(['facturas.nro_fact']);

                $factnrofn = !$factnro->isEmpty() ? $factnro->last()->value('nro_fact')+1 : 1;

                $fact = new Factura;
                $fact->proveedors_id = $costo->first()->proveedores_id;
                $fact->year = $dt->year;
                $fact->week = $dt->weekOfYear;
                //$fact->base_imponible = $costo->base_imponible;
                //$fact->iva = $costo->iva;
                $fact->total_fact = round($costo->sum('total_factura'),2);
                //$fact->payout_1 = $costo->payout_1;
                //$fact->payout_2 = $costo->payout_2;
                //$fact->payout_3 = $costo->payout_3;
                //$fact->payout_4 = $costo->payout_4;
                //$fact->payout_5 = $costo->payout_5;
                //$fact->payout_6 = $costo->payout_6;
                //$fact->payout_7 = $costo->payout_7;
                //$fact->payout_8 = $costo->payout_8;
                //$fact->payout_9 = $costo->payout_9;
                //$fact->payout_10 = $costo->payout_10;
                $fact->total_pay = round($costo->sum('total_pay'),2);
                $fact->voucher_type = 'Fact. Electronica';
                $fact->fact_day = $dt;
                $fact->fact_type = 'generada';
                $fact->nro_fact = $factnrofn;
                $fact->save();

                //dd($fact->toArray());

                foreach ($costo as $cost) {
                    $cost->status = 'procesado';
                    $cost->nro_fact = $factnrofn;
                    $cost->save();
                }


                $current++;

                $message = array('current' => $current);
                broadcast(new FacturaProgress($user, $message));

                $successCount++;
            }

        } catch (Exception $e) {
            dd($e);            
        }

        try {
            foreach ($costosNV as $costonv) {

                //return response()->json();

                //dd($costonv);
                $factnro = Factura::where('proveedors_id', $costonv->first()->proveedors_id)->where('fact_type', 'generada')->get(['facturas.nro_fact']);

                $factnrofn = !$factnro->isEmpty() ? $factnro->last()->value('nro_fact')+1 : 1;

                $facts = new FacturaIncident;
                $facts->proveedors_id = $costonv->first()->proveedors_id;
                $facts->year = $dt->year;
                $facts->week = $dt->weekOfYear;
                //$fact->base_imponible = $costo->base_imponible;
                //$fact->iva = $costo->iva;
                $facts->total_fact = (double)$costonv->sum('total_factura');
                //$fact->payout_1 = $costo->payout_1;
                //$fact->payout_2 = $costo->payout_2;
                //$fact->payout_3 = $costo->payout_3;
                //$fact->payout_4 = $costo->payout_4;
                //$fact->payout_5 = $costo->payout_5;
                //$fact->payout_6 = $costo->payout_6;
                //$fact->payout_7 = $costo->payout_7;
                //$fact->payout_8 = $costo->payout_8;
                //$fact->payout_9 = $costo->payout_9;
                //$fact->payout_10 = $costo->payout_10;
                $facts->total_pay = (double)$costonv->sum('total_pay');
                $facts->fi_nro_fact = $factnrofn;
                $facts->fecha_upload = $dt;
                $facts->fact_type = 'generada';
                $facts->fi_status = 'observacion';
                $facts->observaciones = 'el proveedor no esta de alta en Close2U';
                $facts->save();

                foreach ($costonv as $costnv) {
                    $costnv->nro_fact = $factnrofn;
                    $costnv->status = 'procesado';
                    $costnv->nro_fact = $factnrofn;
                    $costnv->save();
                }
                $message = array('company_id' => $costonv->pluck('proveedores.company_id')->get(0),
                            'message' => 'el proveedor no esta de alta en Close2U'
                         );

                $warnings->push($message);
                $current++;

                $message = array('current' => $current);
                broadcast(new FacturaProgress($user, $message));

                $warningsCount++;
            }

        } catch (Exception $e) {
            dd($e);            
        }

        if ($warningsCount > 0) {
            $filenameWarning = 'facturaWarnings'.$dt->format('Y-m-d-h-i-s');
            \Excel::create($filenameWarning, function($excel) use ($warnings){

                    $excel->sheet('registros', function($sheet) use ($warnings)
                    {
                        
                        $sheet->fromArray($warnings, null, 'A1', false, true);
                    });
                })->store('xlsx', storage_path('app/public/files/shares/facturasGen'));
        }

            /*\Excel::create('costosFails', function($excel) use ($fails){

                $excel->sheet('registros', function($sheet) use ($fails)
                {
                    
                    $sheet->fromArray($fails, null, 'A1', false, true);
                });
            })->store('xlsx', storage_path('app/public'));*/

        $messags = array(
            'alerts' => true, 
            'success' => $successCount, 
            'urlWarning' => $warningsCount > 0 ? url(Storage::url('/files/shares/facturasGen/'.$filenameWarning.'.xlsx')) : '', 
            'warnings' => $warningsCount );

        broadcast(new FacturaProgress($user, $messags));

        $close = array('close' => true);

        broadcast(new FacturaProgress($user, $close));

        /*if ($current%1==0) {
        }*/
            

        return response()->json('listo');

    }

    public function importExcel(Request $request)
    {
        //return response()->json('holaaaaa');

        $user = Auth::user();

        $this->validate($request, array(
            'file'      => 'required'
        ));

        $file = $request->file('file');

       
        //dd($request->all());
        //$proveedors = Proveedor::all();

        //dd($proveedors->search('company_id', 'pymnlmckeonevoctdjhqvssuljaeywap'));

        \Excel::load($file, function($reader) use ($user) {

            $current = 0;
            $reader->ignoreEmpty();
            $results = $reader->get();
            $max = array('max' => $results->count());

            //dd($results->count());

            //return "<pre>".$results->toJson()."</pre>";

            broadcast(new FacturaProgress($user, $max));

            foreach ($results as $result) {
                $current++;

                $dr = Proveedor::where('tax_code', $result->ruc)->select('proveedors.*')
                    ->first();

                //dd($result);

                if ($dr) {
                    $factura = new Factura;
                    $factura->proveedors_id = $dr->id;
                    $factura->year = $result->ano;
                    $factura->week = $result->semana;
                    $factura->total_fact = (double)$result->monto_total_a_facturar_calculado;
                    $factura->total_pay = (double)$result->monto_total_a_pagar_calculado;
                    $factura->fact_day = now();
                    $factura->fact_type = 'manual';
                    $factura->save();


                }
                if (!$dr) {
                    //incidente de factura no consigue el proveedor id
                    $factura = new FacturaIncident;
                    $factura->company_id = $result->ruc;
                    $factura->year = $result->ano;
                    $factura->week = $result->semana;
                    $factura->total_fact = (double)$result->monto_total_a_facturar_calculado;
                    $factura->total_pay = (double)$result->monto_total_a_pagar_calculado;
                    $factura->fecha_upload = now();
                    $factura->observaciones = 'no esta asociado a ningun proveedor';
                    $factura->fact_type = 'manual';
                    $factura->save();
                }

                $message = array('current' => $current);

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
                if ($current == $max['max']) {
                    $message = array('current' => $current);
                    broadcast(new FacturaProgress($user, $message));
                }            
            }
           $close = array('close' => true);

            broadcast(new FacturaProgress($user, $close));

        });

        return response()->json('listo');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
