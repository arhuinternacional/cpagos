<?php

namespace App\Http\Controllers;

use App\Costo;
use App\Proveedor;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;
use Response;
use Carbon\Carbon;
use Auth;
use Mail;
use Illuminate\Support\Collection;
use App\Events\CostoEvent;
use App\Mail\CostoMail;
use App\Events\CostoProgress;
use App\Driver;
use Validator;
use App\Costoincident;
use Illuminate\Http\Request;

class CostosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('costos.index');
    }

    public function approv()
    {
        return view('costos.aprovaciones');
    }

    public function shows()
    {
            $prov = Proveedor::with('drivers')->select('proveedors.*')->whereHas('drivers', function ($query)
            {
                $query->where('driver_id', '2fa2b1f49290213177dc1dc48c178903');
            })->first();

            dd($prov->drivers->where('driver_id', '2fa2b1f49290213177dc1dc48c178903')->first());
        return response()->json($dri);
    }

    public function getCostos(Request $request)
    {
        if ($request->crit && $request->filter != null) {
          switch ($request->crit) {
            case 1:
              $costos = Costo::with(['drivers', 'proveedores'])->whereHas('proveedores', function($item) use ($request){
                $item->where('company_id', 'like', '%'.$request->filter.'%');
              });
              
              break;
            case 2:
              $costos = Costo::with(['drivers', 'proveedores'])->whereHas('proveedores', function($item) use ($request){
                $item->where('company_name', 'like', '%'.$request->filter.'%');
              });
              break;
            case 3:
              $costos = Costo::with(['drivers', 'proveedores'])->whereHas('proveedores', function($item) use ($request){
                $item->where('tax_code', 'like', '%'.$request->filter.'%');
              });
              break;
          }
              return response()->json($costos->paginate(10));
        }else{
          $costos = Costo::with(['drivers', 'proveedores'])->getFresh();
        }

        switch ($request->sort) {
          case 'costo|desc':
            $costos->orderBy('costo', 'desc');
            break;
          case 'costo|asc':
            $costos->orderBy('costo', 'asc');
            break;
          case 'total_factura|asc':
            $costos->orderBy('total_factura', 'asc');
            break;
          case 'total_factura|desc':
            $costos->orderBy('total_factura', 'desc');
            break;
          case 'total_pay|asc':
            $costos->orderBy('total_pay', 'asc');
            break;
          case 'total_pay|desc':
            $costos->orderBy('total_pay', 'desc');
            break;
          case 'week|asc':
            $costos->orderBy('week', 'asc');
            break;
          case 'week|desc':
            $costos->orderBy('week', 'desc');
            break;
          case 'year|asc':
            $costos->orderBy('year', 'asc');
            break;
          case 'year|desc':
            $costos->orderBy('year', 'desc');
            break;
          case 'status|asc':
            $costos->orderBy('status', 'asc');
            break;
          case 'status|desc':
            $costos->orderBy('status', 'desc');
            break;
          case 'fecha_upload|asc':
            $costos->orderBy('fecha_upload', 'asc');
            break;
          case 'fecha_upload|desc':
            $costos->orderBy('fecha_upload', 'desc');
            break;
          default:
            $costos->orderBy('_id', 'desc');
            break;
        }
        
        return response()->json($costos->paginate(10));
    }

    public function gethistorics(Request $request)
    {
        //return response()->json($request->all());

        if ($request->crit && $request->filter != null) {
          switch ($request->crit) {
            case 1:
              $costos = Costo::with(['drivers', 'proveedores'])->whereHas('proveedores', function($item) use ($request){
                $item->where('company_id', 'like', '%'.$request->filter.'%');
              });
              
              break;
            case 2:
              $costos = Costo::with(['drivers', 'proveedores'])->whereHas('proveedores', function($item) use ($request){
                $item->where('company_name', 'like', '%'.$request->filter.'%');
              });
              break;
            case 3:
              $costos = Costo::with(['drivers', 'proveedores'])->whereHas('proveedores', function($item) use ($request){
                $item->where('tax_code', 'like', '%'.$request->filter.'%');
              });
              break;
          }
              return response()->json($costos->paginate(10));
        }else{
          $costos = Costo::with(['drivers', 'proveedores'])->where('status', 'procesado')->getFresh();
        }

        switch ($request->sort) {
          case 'costo|desc':
            $costos->orderBy('costo', 'desc');
            break;
          case 'costo|asc':
            $costos->orderBy('costo', 'asc');
            break;
          case 'total_factura|asc':
            $costos->orderBy('total_factura', 'asc');
            break;
          case 'total_factura|desc':
            $costos->orderBy('total_factura', 'desc');
            break;
          case 'total_pay|asc':
            $costos->orderBy('total_pay', 'asc');
            break;
          case 'total_pay|desc':
            $costos->orderBy('total_pay', 'desc');
            break;
          case 'week|asc':
            $costos->orderBy('week', 'asc');
            break;
          case 'week|desc':
            $costos->orderBy('week', 'desc');
            break;
          case 'year|asc':
            $costos->orderBy('year', 'asc');
            break;
          case 'year|desc':
            $costos->orderBy('year', 'desc');
            break;
          case 'status|asc':
            $costos->orderBy('status', 'asc');
            break;
          case 'status|desc':
            $costos->orderBy('status', 'desc');
            break;
          case 'fecha_upload|asc':
            $costos->orderBy('fecha_upload', 'asc');
            break;
          case 'fecha_upload|desc':
            $costos->orderBy('fecha_upload', 'desc');
            break;
          default:
            $costos->orderBy('_id', 'desc');
            break;
        }
        
        return response()->json($costos->paginate(10));
    }

    public function getApro(Request $request)
    {
        //return response()->json($request->all());

        $dt = Carbon::now();

        $costos = Costo::with(['proveedores', 'drivers'])->where('status', 'observacion');

        if ($request->property == 'y') {
            $year = $request->name;
            $costos->where('year', (isset($year)) ? $year : $dt->year);
        }

        if ($request->property == 'w') {
            $week = $request->name;
            $costos->where('week', (isset($week)) ? $week : $dt->weekOfYear);
        }

        if ($request->property == 'f' && $request->name != '') {
            $costos->where('fecha_upload', 'like', '%'.$request->names.'%');
        }

        /*if ($request->names && $request->property != null) {
          switch ($request->property) {
            case 1:
              $costos = Costo::with(['drivers', 'proveedores'])->whereHas('proveedores', function($item) use ($request){
                $item->where('company_id', 'like', '%'.$request->names.'%')->where('status', 'observacion');
              });
              
              break;
            case 2:
              $costos = Costo::with(['drivers', 'proveedores'])->whereHas('proveedores', function($item) use ($request){
                $item->where('company_name', 'like', '%'.$request->names.'%')->where('status', 'observacion');
              });
              break;
            case 3:
              $costos = Costo::with(['drivers', 'proveedores'])->whereHas('proveedores', function($item) use ($request){
                $item->where('tax_code', 'like', '%'.$request->names.'%')->where('status', 'observacion');
              });
              break;
          }
              return response()->json($costos->paginate(10));
        }else{
          $costos = Costo::with(['drivers', 'proveedores'])->where('status', 'observacion')->getFresh();
        }*/

        switch ($request->sort) {
          case 'costo|desc':
            $costos->orderBy('costo', 'desc');
            break;
          case 'costo|asc':
            $costos->orderBy('costo', 'asc');
            break;
          case 'total_factura|asc':
            $costos->orderBy('total_factura', 'asc');
            break;
          case 'total_factura|desc':
            $costos->orderBy('total_factura', 'desc');
            break;
          case 'total_pay|asc':
            $costos->orderBy('total_pay', 'asc');
            break;
          case 'total_pay|desc':
            $costos->orderBy('total_pay', 'desc');
            break;
          case 'week|asc':
            $costos->orderBy('week', 'asc');
            break;
          case 'week|desc':
            $costos->orderBy('week', 'desc');
            break;
          case 'year|asc':
            $costos->orderBy('year', 'asc');
            break;
          case 'year|desc':
            $costos->orderBy('year', 'desc');
            break;
          case 'status|asc':
            $costos->orderBy('status', 'asc');
            break;
          case 'status|desc':
            $costos->orderBy('status', 'desc');
            break;
          case 'fecha_upload|asc':
            $costos->orderBy('fecha_upload', 'asc');
            break;
          case 'fecha_upload|desc':
            $costos->orderBy('fecha_upload', 'desc');
            break;
          default:
            $costos->orderBy('_id', 'desc');
            break;
        }
        
        return response()->json($costos->paginate(10));
    }

    public function apro(Request $request)
    {

        if (!$request->data) {
            return response()->json(['error' => 'No hay registros seleccionados', 'id_error' => 1002]);
        }

        $costosA = new Collection($request->data);

        //return response()->json($costosA);

        foreach ($costosA as $costos) {
            $costosAP = Costo::where('_id', $costos)->first();
            $costosAP->status = 'por procesar';
            $costosAP->save();
        }

        return response()->json('listo');
    }

    public function aprovarOp()
    {
        return view('costos.aprovacionesOp');
    }

    public function mail()
    {
        Mail::to('hectorld.15@gmail.com')->send(new CostoMail());

        return response()->json('listo');
        
    }

    public function importExcel(Request $request)
    {
        //dd($request->all());

        $user = Auth::user();

        $this->validate($request, array(
            'file'      => 'required'
        ));

        $file = $request->file('file');

       
        //dd('hola');
        //$proveedors = Proveedor::all();

        //dd($proveedors->search('company_id', 'pymnlmckeonevoctdjhqvssuljaeywap'));

        \Excel::load($file, function($reader) use ($user){

            /*$formato = collect([
                0 => 'company_id',
                1 => 'company_name',
                2 => 'company_email',
                3 => 'company_phone',
                4 => 'tax_code',
                5 => 'bank_account_holder_name',
                6 => 'bank_tax_code_name',
                7 => 'bank_tax_code',
                8 => 'bank_account_number',
                9 => 'company_notes',
            ]);


            $format = collect($reader->get()->first()->keys()->toArray());

            return response()->json('hola');

            $diff = $formato->diff($format);

            if (!$diff->isEmpty()) {
              $message = array('error' => 'No es el Formato Correcto');
              broadcast(new CostoProgress($user, $message));
              return response()->json('FAILURE');
            }*/

            $current = 0;
            $fails = new Collection;
            $failCount = 0;
            $warnings = new Collection;
            $warningCount = 0;
            $success = 0;
            $results = $reader->ignoreEmpty()->get(); 
            $max = array('max' => $results->count());

            broadcast(new CostoProgress($user, $max));
            $dt = Carbon::now();

            foreach ($results as $row) {
                $current++;

                $dr = Proveedor::with('drivers')->whereHas('drivers', function ($query) use ($row)
                    {
                        $query->where('driver', $row->driver_id);
                    })
                    ->first();

                    //dd($dr);

                if ($dr) {
                    $costo = new Costo;
                    //$costo->proveedors_id = $dr->id;
                    //$costo->drivers_id = $dr->drivers->where('driver_id', $row->driver_id)->first()->id;
                    $costo->costo = (double)$row->cost;
                    $costo->bonus_cat = (double)$row->bonus_category;
                    $costo->bonus_mount = (double)$row->bonus_monto;
                    $costo->penalty_cat = (double)$row->penalty_category;
                    $costo->penalty_mount = (double)$row->penalty_monto;
                    $costo->payout_cat = (double)$row->payout_categoryexplanation;
                    $costo->payout_mount = (double)$row->payout_monto;
                    $costo->total_factura = (double)$row->monto_total_a_facturar_calculado;
                    $costo->total_pay = (double)$row->monto_total_a_pagar_calculado;
                    $costo->fecha_upload = $dt;
                    $costo->week = $row->semana;
                    $costo->year = $row->ano;
                    if ($row->monto_total_a_pagar_calculado >= 2000) {
                        $costo->status = 'observacion';
                        $costo->observaciones = 'Monto Mayor a 2000';
                    }
                    $costo->save();

                    $costo->proveedores()->associate($dr);
                    $costo->drivers()->associate($dr->drivers->where('driver', $row->driver_id)->first());

                    $costo->save();

                    if ($row->monto_total_a_pagar_calculado >= 2000) {
                        $message = array('company_id' => $row->company_id,
                            'driver' => $row->driver_id,
                            'message' => 'Monto Mayor a 2000'
                         );
                        $warnings->push($message);

                        $warningCount++;
                    }

                    $success ++;

                }else{
                    $prov = Proveedor::where('company_id', $row->company_id)->first();

                    if ($prov && $row->company_id != null) {
                        try {
                            $driver = new Driver;
                            $driver->driver = $row->driver_id;
                            $driver->save();
                            $driver->companies()->associate($prov);
                            $driver->save();
                            //dd($driver);

                            $prov = Proveedor::with('drivers')->whereHas('drivers', function ($query) use ($row)
                            {
                                $query->where('driver_id', $row->driver_id);
                            })
                            ->first();

                            //dd($prov->toArray());

                            $costo = new Costo;
                            //$costo->proveedors_id = $prov->id;
                            //$costo->drivers_id = $prov->drivers->where('driver_id', $row->driver_id)->first()->id;
                            $costo->costo = (double)$row->cost;
                            $costo->bonus_cat = (double)$row->bonus_category;
                            $costo->bonus_mount = (double)$row->bonus_monto;
                            $costo->penalty_cat = (double)$row->penalty_category;
                            $costo->penalty_mount = (double)$row->penalty_monto;
                            $costo->payout_cat = (double)$row->payout_categoryexplanation;
                            $costo->payout_mount = (double)$row->payout_monto;
                            $costo->total_factura = (double)$row->monto_total_a_facturar_calculado;
                            $costo->total_pay = (double)$row->monto_total_a_pagar_calculado;
                            $costo->fecha_upload = $dt;
                            $costo->week = $row->semana;
                            $costo->year = $row->ano;
                            if ($row->monto_total_a_pagar_calculado >= 2000) {
                                $costo->status = 'observacion';
                                $costo->observaciones = 'Monto Mayor a 2000';
                            }
                            $costo->companies()->associate($prov);
                            $costo->drivers()->associate($driver);
                            $costo->save();

                            if ($row->monto_total_a_pagar_calculado >= 2000) {
                                $message = array('company_id' => $row->company_id,
                                    'driver' => $row->driver_id,
                                    'message' => 'Monto Mayor a 2000'
                                 );
                                $warnings->push($message);

                                $warningCount++;
                            }

                            $success++;

                        }catch (Exception $e) {
                            dd($e);
                        }

                    }else{
                        //en caso de no tener proveedor_id asignado
                        $costo = new Costoincident;
                        $costo->proveedors_id = $row->company_id;
                        $costo->drivers_id = $row->driver_id;
                        $costo->costo = (double)$row->cost;
                        $costo->bonus_cat = (double)$row->bonus_category;
                        $costo->bonus_mount = (double)$row->bonus_monto;
                        $costo->penalty_cat = (double)$row->penalty_category;
                        $costo->penalty_mount = (double)$row->penalty_monto;
                        $costo->payout_cat = (double)$row->payout_categoryexplanation;
                        $costo->payout_mount = (double)$row->payout_monto;
                        $costo->total_factura = (double)$row->monto_total_a_facturar_calculado;
                        $costo->total_pay = (double)$row->monto_total_a_pagar_calculado;
                        $costo->fecha_upload = $dt;
                        $costo->observaciones = 'No esta asignado a ningun proveedor';
                        $costo->week = $row->semana;
                        $costo->year = $row->ano;
                        if ($row->monto_total_a_pagar_calculado >= 2000) {
                            $costo->status = 'observacion';
                            $costo->observaciones = 'Monto Mayor a 2000';
                        }
                        $costo->save();

                        if ($row->monto_total_a_pagar_calculado >= 2000) {
                            $message = array('company_id' => $row->company_id,
                                'driver' => $row->driver_id,
                                'message' => 'No esta asignado a ningun proveedor'
                             );
                            $fails->push($message);
                        }

                        $failCount++;

                    }
                }
                
                switch ($current) {
                    case ($current == 1):
                      $message = array('current' => $current);
                      broadcast(new CostoProgress($user, $message));
                      break;
                    case ($current > 1 && $current < 10):
                      if ($current%2==0) {
                        $message = array('current' => $current);
                        broadcast(new CostoProgress($user, $message));
                      }
                      break;
                    case ($current > 10 && $current < 100):
                      if ($current%10==0) {
                        $message = array('current' => $current);
                        broadcast(new CostoProgress($user, $message));
                      }
                      break;
                    case ($current > 100 && $current < 500):
                      if ($current%50==0) {
                        $message = array('current' => $current);
                        broadcast(new CostoProgress($user, $message));
                      }
                      break;
                    case ($current > 1000 && $current < 1500):
                      if ($current%100==0) {
                        $message = array('current' => $current);
                        broadcast(new CostoProgress($user, $message));
                      }
                      break;
                    case ($current > 1500 && $current < 2500):
                      if ($current%300==0) {
                        $message = array('current' => $current);
                        broadcast(new CostoProgress($user, $message));
                      }
                      break;
                    case ($current > 2500 && $current < 4000):
                      if ($current%500==0) {
                        $message = array('current' => $current);
                        broadcast(new CostoProgress($user, $message));
                      }
                      break;
                    case ($current > 4000 && $current < 9000):
                      if ($current%700==0) {
                        $message = array('current' => $current);
                        broadcast(new CostoProgress($user, $message));
                      }
                      break;
                    case ($current > 9000):
                      if ($current%900==0) {
                        $message = array('current' => $current);
                        broadcast(new CostoProgress($user, $message));
                      }
                      break;
                    }
            }


            $dt = new Carbon('now');
            $filenameWarning = 'costosWarning'.$dt->format('Y-m-d-h-i-s');
            $filenameFail = 'costosFails'.$dt->format('Y-m-d-h-i-s');

            \Excel::create($filenameWarning, function($excel) use ($warnings){

                $excel->sheet('registros', function($sheet) use ($warnings)
                {
                    
                    $sheet->fromArray($warnings, null, 'A1', false, true);
                });
            })->store('xls', storage_path('app/public/files/shares'));

            \Excel::create($filenameFail, function($excel) use ($fails){

                $excel->sheet('registros', function($sheet) use ($fails)
                {
                    
                    $sheet->fromArray($fails, null, 'A1', false, true);
                });
            })->store('xls', storage_path('app/public/files/shares'));

            $messags = array('success' => $success, 'fails' => $failCount, 'urlWarning' => url(Storage::url('/files/shares/'.$filenameWarning.'.xls')), 'urlFails' => url(Storage::url('/files/shares/'.$filenameFail.'.xls')), 'warnings' => $warningCount );

            broadcast(new CostoEvent($user, $messags));

            if ($current == $max['max']) {
                    broadcast(new CostoProgress($user, $message));
                }    

            $close = array('close' => true);

            broadcast(new CostoProgress($user, $close));
        });
        return response()->json(true);
    }

    public function historic()
    {
        return view('costos.historic');
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
