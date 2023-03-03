<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $user = User::where("user_name", $request["user_name"])->first();
        if($request->has('password')){
            if ($user && Hash::check($request["password"], $user->password)) {
                // user password matched
                $token = $user->createToken("auth-token")->plainTextToken;
                return response()->json(['status' => 'Loggedin','token'=>$token]);
            }else{
                // user password not matched
                $msg = array('msg'=>'Invalid E-mail ID / Password');
                return response()->json(['errors' => $msg], 401);
            }
        }else{
            $msg = array('msg'=>'Password is required');
            return response()->json(['errors' => $msg], 401);
        }
    }

    public function index()
    {
        $users = User::get();
        return response()->json(['status' => 'success','users'=>$users]);
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
