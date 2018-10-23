<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('auth.login');
    }

    public function valor(Request $request)
    {
    	

    	return response()->json($request->all());
    }
   

   }