<?php

namespace App\Http\Controllers;

use App\Bentity;
use Response;
use Illuminate\Http\Request;

class BentityController extends Controller
{
    public function setBentity(Request $request)
    {

    	$file = $request->file('file');

    	\Excel::load($file, function($reader) {
	        // iteracción
    	//dd($request->all());
	        $reader->each(function($row) {           
	 			$ben = new Bentity;
	 			$ben->prefix = $row->pre;
	 			$ben->name = $row->name;
	 			$ben->save();
	        });
    	});

    	return response()->json(true);
    }
}
