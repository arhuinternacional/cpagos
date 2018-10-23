<?php

namespace App\Http\Controllers;

use App\Costoincident;
use Response;
use Yajra\Datatables\Datatables;
use Validator;
use Illuminate\Http\Request;

class CostoIncidentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('costonincidents.index');
    }

    public function getIncidents(Request $request)
    {
        
        if ($request->crit && $request->filter != null) {
          switch ($request->crit) {
            case 1:
              $costos = Costoincident::where('proveedors_id', 'like', '%'.$request->filter.'%');
              break;
            case 2:
              $costos = Costoincident::where('company_name', 'like', '%'.$request->filter.'%');
              break;
            case 3:
              $costos = Costoincident::where('tax_code', 'like', '%'.$request->filter.'%');
              break;
          }
              return response()->json($costos->paginate(10));
        }else{
          $costos = Costoincident::getFresh();
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
