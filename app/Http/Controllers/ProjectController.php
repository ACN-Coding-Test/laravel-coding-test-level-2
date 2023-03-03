<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\User;
use App\Models\Project;
class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->user_type == User::ROLE['PRODUCT_OWNER']){
            $projects = Project::get();
            return response()->json(['status' => 'success','projects'=>$projects]);
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
        if(Auth::user()->user_type == User::ROLE['PRODUCT_OWNER']){
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:projects,name|min:5|max:10',
            ]);
             
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->messages()], 422);
            }
            if ($validator->passes()) {
                $create = Project::create([
                    'name' => $request['name']
                ]);
                return response()->json(['status' => 'Project created successfully'], 201);
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
        if(Auth::user()->user_type == User::ROLE['PRODUCT_OWNER']){
            $project = Project::find($id);
            return response()->json(['status' => 'success','project'=>$project]);
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
        if(Auth::user()->user_type == User::ROLE['PRODUCT_OWNER']){
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:5|max:50'
            ]);
             
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->messages()], 422);
            }
            if ($validator->passes()) {
                $updateProject = Project::where('id',$id)->firstOrFail();
                $updateProject->update([
                    'name' => $request['name']
                ]);
                return response()->json(['status' => 'Project updated successfully'], 200);
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
        if(Auth::user()->user_type == User::ROLE['PRODUCT_OWNER']){
            $project = Project::find($id);
            $project->delete();
            return response()->json(['status' => 'Project deleted successfully'], 200);
        }else{
            return response()->json(['errors' => 'You does not have an access'], 401);
        }
    }
}
