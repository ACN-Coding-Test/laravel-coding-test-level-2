<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        if(Auth::user()->user_type == User::ROLE['ADMIN']){
            $users = User::where('id','!=',Auth::user()->id)->get();
            return response()->json(['status' => 'success','users'=>$users]);
        }else{
            return response()->json(['errors' => 'You does not have an access'], 401);
        }
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
        if(Auth::user()->user_type == User::ROLE['ADMIN']){
            $validator = Validator::make($request->all(), [
                'user_name' => 'required|unique:users|min:5|max:10',
                'name' => 'required|string|min:5|max:50',
                'password' => 'required|min:5|max:8',
                'user_type'=>'required|string|min:5|max:18'
            ]);
             
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->messages()], 422);
            }
            if ($validator->passes()) {
                $pwd=Hash::make($request['password']);
                $create = User::create([
                    'name' => $request['name'],
                    'user_name' => $request['user_name'],
                    'password' => $pwd,
                    'user_type' => $request['user_type'],
                ]);
                return response()->json(['status' => 'User created successfully'], 201);
            }
        }else{
            return response()->json(['errors' => 'You does not have an access'], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->user_type == User::ROLE['ADMIN']){
            $user = User::find($id);
            return response()->json(['status' => 'success','user'=>$user]);
        }else{
            return response()->json(['errors' => 'You does not have an access'], 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        if(Auth::user()->user_type == User::ROLE['ADMIN']){
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:5|max:50',
                'user_type'=>'required|string|min:5|max:18'
            ]);
             
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->messages()], 422);
            }
            if ($validator->passes()) {
                $updateUser = User::where('id',$id)->firstOrFail();
                $updateUser->update([
                    'name' => $request['name'],
                    'user_type' => $request['user_type'],
                ]);
                return response()->json(['status' => 'User updated successfully'], 200);
            }
        }else{
            return response()->json(['errors' => 'You does not have an access'], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->user_type == User::ROLE['ADMIN']){
            $user = User::find($id);
            $user->delete();
            return response()->json(['status' => 'User deleted successfully'], 200);
        }else{
            return response()->json(['errors' => 'You does not have an access'], 401);
        }
    }
}
