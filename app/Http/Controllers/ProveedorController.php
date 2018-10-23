<?php

namespace App\Http\Controllers;

use App\Proveedor;
use App\User;
use Carbon\Carbon;
use App\Pago;
use App\Costo;
use App\Factura;
use App\Driver;
use Mail;
use Response;
use App\Mail\Proveedor\MailIsuues;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Events\ProveedorEvent;
use Auth;
use Validator;
use App\Http\Controllers\Excels;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('proveedores.index');
    }

    public function historic()
    {
      return view('proveedores.historico');
    }

    public function gethistoric()
    {
      $histo = Activity::select('activity_log.*')->where('description', 'updated');

      //dd($histo->changes()->get('old'));
      return Datatables::of($histo)
                      ->editColumn('subject_id', function ($histo)
                      {
                        
                        $prov = Proveedor::find($histo->subject_id);

                        if (isset($prov)) {
                          return $prov->company_id;
                        }else{
                          return '';
                        }
                      })
                      ->editColumn('properties', function($histo){
                          /*$arr = $histo->changes()->get('old');
                          $arrfn = array_values($arr);
                          //dd($arrfn);
                          if (isset($arrfn)) {
                            return $arrfn;
                          }else{
                          }*/
                            return '';
                      })
                      ->addColumn('changes', function($histo){
                        $arr_old = $histo->changes()->get('attributes');
                          if ($arr_old == null) {
                            return '';
                          }
                          $arrold = array_values($arr_old);
                          if (isset($arrold)) {
                            return $arrold;
                          }else{
                            return '';
                          }
                      })
                      ->addColumn('attributes', function($histo){
                        $arr_att = $histo->changes()->get('attributes');
                          if ($arr_att == null) {
                            return '';
                          }
                          $arrfnatt = array_keys($arr_att);
                          //dd($arrfn);
                          if (isset($arrfnatt)) {
                            return $arrfnatt;
                          }else{
                          }
                            return '';
                      })
                      ->rawColumns(['subject_id', 'properties', 'attributes'])
                      ->toJson();
    }

    public function getall(request $request)
    {
        //return response()->json($request->all());
        if ($request->crit && $request->filter != null) {
          switch ($request->crit) {
            case 1:
              $proveedor = Proveedor::where('company_id', 'like', '%'.$request->filter.'%');
              break;
            case 2:
              $proveedor = Proveedor::where('company_name', 'like', '%'.$request->filter.'%');
              break;
            case 3:
              $proveedor = Proveedor::where('tax_code', 'like', '%'.$request->filter.'%');
              break;
          }
        }else{
          $proveedor = Proveedor::getFresh();
        }

        switch ($request->sort) {
          case 'company_id|asc':
            $proveedor->orderBy('company_id', 'asc');
            break;
          case 'company_id|desc':
            $proveedor->orderBy('company_id', 'desc');
            break;
          case 'company_name|asc':
            $proveedor->orderBy('company_name', 'asc');
            break;
          case 'company_name|desc':
            $proveedor->orderBy('company_name', 'desc');
            break;
          case 'company_email|asc':
            $proveedor->orderBy('company_email', 'asc');
            break;
          case 'company_email|desc':
            $proveedor->orderBy('company_email', 'desc');
            break;
          case 'tax_code|asc':
            $proveedor->orderBy('tax_code', 'asc');
            break;
          case 'tax_code|desc':
            $proveedor->orderBy('tax_code', 'desc');
            break;
          case 'company_phone|asc':
            $proveedor->orderBy('company_phone', 'asc');
            break;
          case 'company_phone|desc':
            $proveedor->orderBy('company_phone', 'desc');
            break;
          default:
            $proveedor->orderBy('_id', 'desc');
            break;
        }
        
        return response()->json($proveedor->paginate(10));
    }

    public function getprovclose()
    {
      $provP = Proveedor::select('proveedors.*')->where('company_notes', false);

      //dd($provP);//return $provP;

      $client = new \GuzzleHttp\Client();
            $res = $client->request('POST', 'https://cabifyperu.pe/api/clavesol', [
                'form_params' => ['data' => $provP->pluck('tax_code')->toArray()] 
            ]);
            //echo $res->getStatusCode();
            // 200
            //echo $res->getHeaderLine('content-type');
            // 'application/json; charset=utf8'
            //echo $res->getBody();
            // '{"id": 1420053, "name": "guzzle", ...}'
            $data = json_decode($res->getBody(), true);

            if ($data == 'no hay datos') {
              return response()->json('no hay datos');
            }

            $dataT = new Collection($data);

            $total = 0;


            foreach ($dataT as $dataf) {
              //dd($dataf);
              $provsync = $provP->get()->where('tax_code', $dataf['ruc'])->first();
              if ($provsync) {
                $provsync->bank_account_number = $dataf['cuenta'];
                $provsync->company_notes = $dataf['verificacion'];
                $provsync->save();
                $total++;
                
              }

            }

            return response()->json($total);

            //return response()->json($data);
    }

    public function setprov(Request $request)
    {

      $user = Auth::user();
      $this->validate($request, array(
          'file'      => 'required'
      ));

      //dd($request->all());

      $file = $request->file('file');

      

      \Excel::load($file, function($reader) use ($user) {

        $formato = collect([
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

        /*if ($reader->get() || $reader->get()->count() < 0) {
          $message = array('error' => 'No hay registros');
          broadcast(new ProveedorEvent($user, $message));
          return response()->json('FAILURE');
        }*/
        $format = collect($reader->get()->first()->keys()->toArray());

        $diff = $formato->diff($format);

        if (!$diff->isEmpty()) {
          $message = array('error' => 'No es el Formato Correcto');
          broadcast(new ProveedorEvent($user, $message));
          return response()->json('FAILURE');
        }

        $successCount = 0;
        $warningsCount = 0;
        $failsCount = 0;
        $warnings = new Collection;
        $current = 0;

        $provedores = $reader->ignoreEmpty()->get();

        if ($provedores->isEmpty()) {
          $message = array('error' => 'El archivo no contiene Registros');
          broadcast(new ProveedorEvent($user, $message));
          return response()->json('FAILURE');
        }
        $max = array('max' => $provedores->count());
        broadcast(new ProveedorEvent($user, $max));


        foreach ($provedores as $provee) {

          

          $current++;

          $prov_old = Proveedor::where('company_id', $provee->company_id)->first();

          if ($prov_old) {
            try {
              $prov_old->company_id = $provee->company_id;
              $prov_old->company_name = $provee->company_name;
              $prov_old->company_email = $provee->company_email;
              $prov_old->company_phone = $provee->company_phone;
              $prov_old->tax_code = $provee->tax_code;
              $prov_old->bank_account_holder_name = $provee->bank_account_holder_name;
              $prov_old->bank_tax_code_name = $provee->bank_tax_code_name;
              $prov_old->bank_tax_code = $provee->bank_tax_code;
              $prov_old->bank_account_number = $provee->bank_account_number;
              if ($provee->company_notes) {
                $prov_old->company_notes = true;
              }else{
                $prov_old->company_notes = false;
              }
              $prov_old->save();
            } catch (Exception $e) {
              return response()->json($e);
            }

            $warningsCount++;

          }

          if (!$prov_old && $provee->company_id != null) {
            try {
              $proveedor = new Proveedor;
              $proveedor->company_id = $provee->company_id;
              $proveedor->company_name = $provee->company_name;
              $proveedor->company_email = $provee->company_email;
              $proveedor->company_phone = $provee->company_phone;
              $proveedor->tax_code = $provee->tax_code;
              $proveedor->bank_account_holder_name = $provee->bank_account_holder_name;
              $proveedor->bank_tax_code_name = $provee->bank_tax_code_name;
              $proveedor->bank_tax_code = $provee->bank_tax_code;
              $proveedor->bank_account_number = $provee->bank_account_number;
              if ($provee->company_notes == 'Close2u') {
                $proveedor->company_notes = true;
              }else{
                $proveedor->company_notes = false;
              }
              $proveedor->save();
              //$proveedor->save();
            } catch (Exception $e) {
              return response()-json($e);
            }

            $successCount++;
          }

          switch ($current) {
            case ($current == 1):
              $message = array('current' => $current);
              broadcast(new ProveedorEvent($user, $message));
              break;
            case ($current > 1 && $current < 10):
              if ($current%2==0) {
                $message = array('current' => $current);
                broadcast(new ProveedorEvent($user, $message));
              }
              break;
            case ($current > 10 && $current < 100):
              if ($current%10==0) {
                $message = array('current' => $current);
                broadcast(new ProveedorEvent($user, $message));
              }
              break;
            case ($current > 100 && $current < 500):
              if ($current%50==0) {
                $message = array('current' => $current);
                broadcast(new ProveedorEvent($user, $message));
              }
              break;
            case ($current > 1000 && $current < 1500):
              if ($current%100==0) {
                $message = array('current' => $current);
                broadcast(new ProveedorEvent($user, $message));
              }
              break;
            case ($current > 1500 && $current < 2500):
              if ($current%300==0) {
                $message = array('current' => $current);
                broadcast(new ProveedorEvent($user, $message));
              }
              break;
            case ($current > 2500 && $current < 4000):
              if ($current%500==0) {
                $message = array('current' => $current);
                broadcast(new ProveedorEvent($user, $message));
              }
              break;
            case ($current > 4000 && $current < 9000):
              if ($current%700==0) {
                $message = array('current' => $current);
                broadcast(new ProveedorEvent($user, $message));
              }
              break;
            case ($current > 9000):
              if ($current%900==0) {
                $message = array('current' => $current);
                broadcast(new ProveedorEvent($user, $message));
              }
              break;
          }
          
        }

        $messags = array(
            'alerts' => true, 
            'success' => $successCount, 
            'urlWarning' => '', 
            'warnings' => $warningsCount );

        broadcast(new ProveedorEvent($user, $messags));

        $close = array('close' => true);

        broadcast(new ProveedorEvent($user, $close));            
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
        /*$new = array(
          '01' =>  'CENTRAL RESERVA DEL PERU',
          '02' =>  'DE CREDITO DEL PERU',
          '03' =>  'INTERNACIONAL DEL PERU',
          '05' =>  'LATINO',
          '07' =>  'CITIBANK DEL PERU S.A.',
          '08' =>  'STANDARD CHARTERED',
          '09' =>  'SCOTIABANK PERU',
          '11' =>  'CONTINENTAL',
          '12' =>  'DE LIMA',
          '16' =>  'MERCANTIL',
          '18' =>  'NACION',
          '22' =>  'SANTANDER CENTRAL HISPANO',
          '23' =>  'DE COMERCIO',
          '25' =>  'REPUBLICA',                
          '26' =>  'NBK BANK',                 
          '29' =>  'BANCOSUR',
          '35' =>  'FINANCIERO DEL PERU',      
          '37' =>  'DEL PROGRESO',             
          '38' =>  'INTERAMERICANO FINANZAS',
          '39' =>  'BANEX',
          '40' =>  'NUEVO MUNDO',
          '41' =>  'SUDAMERICANO',             
          '42' =>  'DEL LIBERTADOR',
          '43' =>  'DEL TRABAJO',
          '44' =>  'SOLVENTA',
          '45' =>  'SERBANCO SA.',             
          '46' =>  'BANK OF BOSTON',           
          '47' =>  'ORION',
          '48' =>  'DEL PAIS',
          '49' =>  'MI BANCO',             
          '50' =>  'BNP PARIBAS',
          '51' =>  'AGROBANCO',
          '53' =>  'HSBC BANK PERU S.A.',      
          '54' =>  'BANCO FALABELLA S.A.',
          '55' =>  'BANCO RIPLEY',
          '56' =>  'BANCO SANTANDER PERU S.A.',
          '58' =>  'BANCO AZTECA DEL PERU',
          '99' =>  'OTROS'
          );

        foreach ($new as $news) {
          $newt = new Bentity;
          $newt->prefix = $news[]
        }*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prov = Proveedor::with(['costos', 'facturas'])->where('_id', $id)->firstOrFail();

        //dd($prov->facturas->toArray());

        return view('proveedores.show')->with('prov', $prov);
    }

    public function tablas(Request $request)
    {

      $dt = new Carbon('now');


      if ($request->driver) {



        /*$driver = Driver::with('companies')->select('drivers.*')->whereHas('companies', function($query) use($request){
            $query->where('company_id', $request->compID);
        })->get();*/

        //return response()->json($request->all());

        $driver = Proveedor::find($request->compID)->drivers;

        return Datatables::of($driver)
                          ->make(true);
      }

      if ($request->costo) {

        //return response()->json($dt->year);

        $costo = Costo::with(['proveedores', 'drivers'])->where('proveedores_id', $request->compID);

        if ($request->property == 'y') {
            $year = $request->name;
            $costo->where('year', '=', (isset($year)) ? (int)$year : (int)$dt->year);
        }

        if ($request->property == 'w') {
            $week = $request->name;
            $costo->where('week', '=', (isset($week)) ? (int)$week : (int)$dt->weekOfYear);
        }


        if ($request->property == 'f' && $request->name != '') {
            $costo->where('fecha_upload', 'like', '%'.$request->name.'%');
        }

        switch ($request->type) {
            case 'pp':
                $costo->where('status', 'por procesar');
                break;
            case 'pd':
                $costo->where('status', 'procesado');
                break;
            case 'ob':
                $costo->where('status', 'observacion');
                break;
            default:
                $costo;
        }
        return Datatables::of($costo->get())
                          /*->editColumn('drivers_id', function($costotab) use ($costo){
                            $driver = $costo->drivers->where('id', $costotab->drivers_id)->first();
                            //dd($driver->driver_id);
                            $driver = $driver->toArray();
                            return $driver;
                          })*/
                          ->make(true);
      }

      if ($request->factura) {

          //return response()->json($request->all());

          

          $facturas = Factura::with('proveedors')->where('proveedors_id', $request->compID);

        //este funciona

        if ($request->property == 'y') {
            $year = $request->name;
            $facturas->where('year', (isset($year)) ? (int)$year : (int)$dt->year);
        }

        if ($request->property == 'w') {
            $week = $request->name;
            $facturas->where('week', (isset($week)) ? (int)$week : (int)$dt->weekOfYear);
        }


        if ($request->property == 'f' && $request->name != '') {
            $facturas->where('fact_day', 'like', '%'.$request->name.'%');
        }

        switch ($request->type) {
            case 'pp':
                $facturas->where('status', 'por procesar');
                break;
            case 'pg':
                $facturas->where('status', 'por pagar');
                break;
            case 'pd':
                $facturas->where('status', 'pagado');
                break;
            case 'ob':
                $facturas->where('status', 'observacion');
                break;
            default:
                $facturas;
        }

        
        //return response()->json($costo);

        return Datatables::of($facturas->get())
                          ->make(true);
      }

      if ($request->pagos) {

          //return response()->json($request->all());

          

          $pagos = Pago::with('proveedors')->where('proveedors_id', $request->compID);

        //este funciona

        if ($request->property == 'y') {
            $year = $request->name;
            $pagos->where('year', (isset($year)) ? (int)$year : (int)$dt->year);
        }

        if ($request->property == 'w') {
            $week = $request->name;
            $pagos->where('week', (isset($week)) ? (int)$week : (int)$dt->weekOfYear);
        }


        if ($request->property == 'f' && $request->name != '') {
            $pagos->where('fact_day', 'like', '%'.$request->name.'%');
        }

        switch ($request->type) {
            case 'pp':
                $pagos->where('status', 'por procesar');
                break;
            case 'pg':
                $pagos->where('status', 'por pagar');
                break;
            case 'pd':
                $pagos->where('status', 'pagado');
                break;
            case 'ob':
                $facturas->where('status', 'observacion');
                break;
            default:
                $pagos;
        }

        
        //return response()->json($costo);

        return Datatables::of($pagos->get())
                          ->make(true);
      }

      //return response()->json($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $prov = Proveedor::with(['costos', 'facturas'])->where('_id', $id)->firstOrFail();

        return view('proveedores.edit')->with('prov', $prov);
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
        $prov = Proveedor::findOrFail($id);

        $prov->fill([
          'company_name' => isset($request->companyName) ? $request->companyName : $prov->company_name,
          'company_phone' => isset($request->CompanyPhone) ? $request->CompanyPhone : $prov->company_phone,
          'company_email' => isset($request->companyEmail) ? $request->companyEmail : $prov->company_email,
          'tax_code' => isset($request->taxCode) ? $request->taxCode : $prov->tax_code,
          'bank_account_holder_name' => isset($request->bankHolderName) ? $request->bankHolderName : $prov->bank_account_holder_name,
          'bank_tax_code_name' => isset($request->bankTaxCodeName) ? $request->bankTaxCodeName : $prov->bank_tax_code_name,
          'bank_tax_code' => isset($request->bankTaxCode) ? $request->bankTaxCode : $prov->bank_tax_code,
          'bank_account_number' => isset($request->bankAccountNumber) ? $request->bankAccountNumber : $prov->bank_account_number,
        ]);
        $prov->save();

        return view('proveedores.edit')->with('prov', $prov);
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

    public function showActivity()
    {
       $activity = Activity::all()->last();

       dd($activity->changes());
    }

    public function changeVerify($id)
    {
      $prov = Proveedor::where('_id',$id)->first();

      $prov->company_notes = !$prov->company_notes;
      $prov->save();

      return response()->json(true);
    }

    public function mail(Request $request)
    {
      //return response()->json($request->all());
      try {
        $data = new Collection(['type' => $request->tipo, 'text' => $request->data]);
        $to = $request->to;
        Mail::to('hectorld.15@gmail.com')->send(new MailIsuues($data));
      } catch (Exception $e) {
        return response()->json($e);
      }

      return response()->json('listo');
    }
}
