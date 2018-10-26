<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('usuario.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'username' => 'required|unique:mongodb.users,username|min:4',
            'password' => 'required|min:4',
            'email' => 'required|email|min:4'
        ]);

        if ($validator->fails()) {
            return response()->json('Datos incompletos');
        }

        $user = new User;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->save();

        return response()->json(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //return response()->json();
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
        //return response()->json($request->all());

        $validator = \Validator::make($request->all(), [
            'username' => 'min:4',
            'email' => 'email|min:4',
            'password' => 'min:4|max:16'
        ]);

        if ($validator->fails()) {
            return response()->json('Datos incompletos');
        }

        $user = User::where('username', $id)->first();

        if ($user != null) {
            $user->email = $request->email != $user->email ? $request->email : $user->email;
            $user->username = $request->username != $user->username ? $request->username : $user->username;
            $user->password = $request->password != $user->password && $request->password != '' ? bcrypt($request->password) : $user->password;
            $user->save();
        }

        return response()->json(true);

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

    public function GetUser(Request $request)
    {
        if ($request->filter != null) {
            $user = User::where('email', 'like', '%'.$request->filter.'%')
                        ->orWhere('username', 'like', '%'.$request->filter.'%')
                        ;
        }else{
            $user = User::getFresh();
        }

        switch ($request->sort) {
          case 'email|asc':
            $user->orderBy('email', 'asc');
            break;
          case 'email|desc':
            $user->orderBy('email', 'desc');
            break;
          case 'username|asc':
            $user->orderBy('username', 'asc');
            break;
          case 'username|desc':
            $user->orderBy('username', 'desc');
            break;
          default:
            $user->orderBy('_id', 'desc');
            break;
        }
       return response()->json($user->paginate(10));
    }
}
