<?php

namespace App\Http\Controllers;

use App\Pago;
use App\Factura;
use Illuminate\Support\Collection;
use Response;
use Illuminate\Support\Facades\Storage;
use Auth;
use Validator;
use Zipper;
use App\Events\Pago\PagoGenerateProgress;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PagosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        return view('pagos.index');
    }

    public function lists(Request $request)
    {
        $listFact = Factura::where('status', 'por pagar')->get(['fact_day'])->groupBy(function($date) {
            return Carbon::parse($date->fact_day)->format('Y-m-d'); // grouping by months
            })->keys()
        ;

        return $listFact;
    }

    public function generate(Request $request)
    {
        //return response()->json($request->all());
        $user = Auth::user();

        $pagos = new Collection();

        $dateRequest = Carbon::parse($request->data);

        $facts = Factura::with(['proveedors'])
                    ->where('fact_day', '>', new \DateTime($dateRequest))
                    ->where('fact_day', '<', new \DateTime($dateRequest->addDay()))
                    ->where('status', 'por pagar')
                    ->get()->groupBy('proveedors_id')
                    ->sort()->chunk(400);

        //return response()->json($facts);
        $dt = new Carbon('now');
        $count = 0;
        $group = 0;
        $factsN = ceil($facts->collapse()->count()/3);

        $successCount = 0;
        $warningsCount = 0;
        $failsCount = 0;
        $warnings = new Collection;
        $current = 0;
        $max = array('max' =>$facts->collapse()->count());

        broadcast(new PagoGenerateProgress($user, $max));

        //dd($facts);

        foreach ($facts as $factu) {
            $group++;
           //return response()->json($fact);
           foreach ($factu as $key => $fact) {
                $count++;
                $current++;
               $pago = new Pago;
               $pago->doi = 'L';
               $pago->doi_num = $fact->pluck('proveedors.bank_tax_code')->first();
               $pago->tipo_abono = 'P';
               $pago->n_cuenta = $fact->pluck('proveedors.bank_account_number')->first();
               $pago->nombre = $fact->pluck('proveedors.bank_account_holder_name')->first();
                $pago->importe = (double)round($fact->sum('total_pay'),2);
                $pago->ref = '18';
                $pago->status = 'emitido';
                $pago->transaction_emit = $dt;
                $pago->d_operation = $dt->format('Ymdhis');
                $pago->group = $group;
                $pago->observacion = '';
                $pago->proveedors_id = $fact->pluck('proveedors_id')->first();
                $pagosFormat = '002'.$pago->doi.$pago->doi_num.'    '.$pago->tipo_abono.$pago->n_cuenta.str_pad($pago->nombre, 40, ' ', STR_PAD_RIGHT).str_pad($pago->importe*100, 15, '0', STR_PAD_LEFT).str_pad($count == 1 ? 'FV' : 'F1', 13, ' ', STR_PAD_RIGHT).'N'.str_pad($pago->ref, 91, ' ', STR_PAD_RIGHT).str_pad('0011', 30, ' ', STR_PAD_RIGHT).str_pad('0', 34, '0', STR_PAD_RIGHT).str_pad('', 15, ' ', STR_PAD_RIGHT).PHP_EOL;
                $pagos->push($pagosFormat);
                $pago->save();
                //$pays[] = array('proveedor' => $fact->pluck('proveedors_id')->first(), 'suma' => $fact->sum('total_pay') ) ;
                foreach ($fact as $fac) {
                    $fac->status = 'txt_emitido';
                    $fac->save();
                }
                if ($count == 400) {
                    $count = 0;
                }

                $message = array('current' => $current);
                broadcast(new PagoGenerateProgress($user, $message));
                
                unset($factu);
           }
        }

        //return response()->json($pagor);
           
        //dd($px);

        //return response()->json($pagos);
        //$pagosFormat = '002'.$pago->doi.$pago->doi_num.'    '.$pago->tipo_abono.$pago->n_cuenta.str_pad($pago->nombre, 40, ' ', STR_PAD_RIGHT).str_pad($pago->importe, 15, '0', STR_PAD_LEFT).str_pad('F1', 13, ' ', STR_PAD_RIGHT).'N'.str_pad($pago->ref, 91, ' ', STR_PAD_RIGHT).str_pad('011', 30, ' ', STR_PAD_RIGHT).str_pad('0', 33, '0', STR_PAD_RIGHT).str_pad('', 15, ' ', STR_PAD_RIGHT).PHP_EOL;
        $chunks = $pagos->chunk(400);

        $current = 0;

        foreach ($chunks as $chunk) {
            $current++;
            Storage::disk('local')->put('/public/files/shares/pagos'.$dt->format('Ymdhis').'/grupo_'.$current.'.txt', $chunk->implode(''));
        }

        $files = glob(storage_path('app/public/files/shares/pagos'.$dt->format('Ymdhis').'*'));
        \Zipper::make(storage_path('app/public/files/shares/pagoszip/'.$dt->format('Ymdhis').'.zip'))->add($files)->close();
        

        $messags = array(
            'alerts' => true, 
            'url' => $current > 0 ? Storage::url('public/files/shares/pagoszip/'.$dt->format('Ymdhis').'.zip') : '');

        broadcast(new PagoGenerateProgress($user, $messags));

        $close = array('close' => true);

        broadcast(new PagoGenerateProgress($user, $close));

        return response()->json('listo');
    }

    public function getPag(Request $request)
    {
        //return response()->json($request->all());

        $dt = new Carbon('now');
        //este funciona
        $pagos = Pago::with('proveedors')->getFresh();

        return response()->json($pagos->paginate(10));
    }

    public function getVerif(Request $request)
    {
        //return response()->json($request);

        $dt = new Carbon('now');

        $dateRequest = Carbon::parse($request->date);

        if (isset($request->dat)) {
            $datRequest = Carbon::parse($request->dat);
        }

        $pagos = Pago::with('proveedors')->where('status', 'emitido')->orderBy('_id', 'desc');

        if ($request->date && $request->group && $request->group_t) {

            $pago = Pago::with(['proveedors'])
                    ->where('transaction_emit', '>', new \DateTime($dateRequest))
                    ->where('transaction_emit', '<', new \DateTime($dateRequest->addDay()))
                    ->where('d_operation', $request->group)
                    ->where('group', (int)$request->group_t)
                    ->groupBy('proveedors_id')
                    ->getFresh(['proveedors_id', 'nombre', 'importe', 'transaction_emit', 'status']);

                    //dd($pago);
            //return response()->json($request->all());
                

            return response()->json($pago->paginate(10));
        }

        if ($request->date) {
            $pagosO = $pagos
                    ->where('transaction_emit', '>', new \DateTime($dateRequest))
                    ->where('transaction_emit', '<', new \DateTime($dateRequest->addDay()))
                    ->get()
                    ->groupBy('d_operation')
                    ->keys()
                    ->toArray();
            return response()->json($pagosO);
        }

        if ($request->dat && $request->group) {
            $pagosG = $pagos
                    ->where('transaction_emit', '>', new \DateTime($datRequest))
                    ->where('transaction_emit', '<', new \DateTime($datRequest->addDay()))
                    ->where('d_operation', $request->group)
                    ->get()->groupBy('group')
                    ->keys()->toArray();
            return response()->json($pagosG);
        }

        return response()->json($pagos);
    }

    public function setVerif(Request $request)
    {
        //return response()->json($request->all());

        
        $validator = Validator::make($request->all(), [
            'data' => 'required',
            'params' => 'required',
        ]);

        if ($validator->fails()) {
            //$errores = collect(['datos nuevos']);
            //return view('errors.frontError')->with('errors', $validator->errors());
            //return view('errors.frontError')->with('errors', $errores);
            //return response()->view('errors.frontError')->with('errors', $validator);
            return response()->json(['errors' => $validator->errors(), 'error_id' => 1001]);
        }

        $data = new Collection($request->data);

        $data = $data->pluck('observacion', 'proveedors_id');

        $dt = Carbon::createFromFormat('Y-m-d', $request->params['date'])->hour(0)->minute(0)->second(0);

        $pagos = Pago::where('d_operation', $request->params['group'])
                        ->where('transaction_emit', '>', new \DateTime($dt))
                        ->where('transaction_emit', '<', new \DateTime($dt->addDay()))
                        ->where('group', $request->params['group_t'])
                        ->get()->whereNotIn('proveedors_id', $data->keys());

        foreach ($pagos as $pago) {
            $pago->status = 'pagado';
            $pago->transaction_n = $request->nro;
            $pago->transaction_payed = Carbon::now();
            $pago->save();
        }
        $dt = Carbon::createFromFormat('Y-m-d', $request->params['date'])->hour(0)->minute(0)->second(0);
       
        $pagos = Pago::whereIn('proveedors_id', $data->keys())
                        ->whereBetween('transaction_emit',[new \DateTime($dt), new \DateTime($dt->addDay())])
                        ->where('group', $request->params['group_t'])
                        ->get();

        foreach ($data as $key => $dato) {
            $pago = $pagos->where('proveedors_id', $key)->first();
            $pago->observacion = $dato;
            $pago->status = 'rechazado';
            $pago->save();
        }

        /*foreach ($pagos as $pago) {
            $pag = $data->where('id', $pago->id)->first();
            $pago->pg_status = 'rechazado';
            //$pago->save();
            $pys[] = $pag;
        }*/

        return response()->json('listo');
    }

    public function verificate()
    {
        return view('pagos.verificacion');
    }

    public function incidentes()
    {
        return view('pagos.incidentes');
    }

    public function getInci(Request $request)
    {
        $pagos = Pago::with(['proveedors'])->where('pg_status', 'rechazado')->orderBy('id', 'desc');

        if ($request->date && $request->group && $request->group_t) {
            $pagos = $pagos->whereDate('transaction_emit', $request->date)->where('d_operation', $request->group)->where('group', $request->group_t)->orderBy('id', 'desc')->paginate(10);

            return response()->json($pagos);
        }

        if ($request->date) {
            $pagosO = $pagos->whereDate('transaction_emit', $request->date)->get()->groupBy('d_operation')->keys()->toArray();
            return response()->json($pagosO);
        }

        if ($request->dat && $request->group) {
            $pagosG = $pagos->whereDate('transaction_emit', $request->dat)->where('d_operation', $request->group)->get()->groupBy('group')->keys()->toArray();
            return response()->json($pagosG);

        }

        return response()->json($pagos->paginate(10));
    }
}
