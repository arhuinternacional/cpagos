<?php

namespace App\Http\Controllers;

use App\FacturaIncident;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

class FacturaIncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('facturaincidentes.index');
    }

    public function getFact(Request $request)
    {

        $dt = new Carbon('now');
        //este funciona
        $facturas = FacturaIncident::with('proveedors')->select('factura_incidents.*');

        
        if ($request->property == 'y') {
            $year = $request->name;
            $facturas->where('year', (isset($year)) ? $year : $dt->year);
        }

        if ($request->property == 'w') {
            $week = $request->name;
            $facturas->where('week', (isset($week)) ? $week : $dt->weekOfYear);
        }


        if ($request->property == 'f' && $request->name != '') {
            $facturas->where('fecha_upload', 'like', '%'.$request->name.'%');
        }

        /*if ($request->property == null) {
            # code...
        }*/

        switch ($request->type) {
            case 'gt':
                $facturas->where('fact_type', 'generada');
                break;
            case 'mn':
                $facturas->where('fact_type', 'manual');
                break;
            default:
                $facturas;
        }
        

        
        //return response()->json($request->all());
        //dd($request->all());

        return Datatables::of($facturas)
                ->toJson();
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
