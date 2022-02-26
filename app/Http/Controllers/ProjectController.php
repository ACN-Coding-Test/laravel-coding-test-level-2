<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ProjectCollection;
use Illuminate\Http\Request;
use Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $projects = Project::get();

        return new ProjectCollection($projects);
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
        $validatedArray = $request->all();

        $validator = Validator::make($validatedArray, [
            'name' => 'required|unique:projects|max:255',
        ]);

        if ($validator->fails()) {
            $returnMessage['status'] = 'error';
            $returnMessage['message'] = $validator->errors()->first();
            return response()->json($returnMessage, 422);
        }

        $project = new Project;
        $project->name = $request->name;
        $project->save();

        return response()->json(['status' => 'success', 'message' => 'Project created successfully.'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
        return new ProjectResource($project);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
        $validatedArray = $request->all();

        $validator = Validator::make($validatedArray, [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            $returnMessage['status'] = 'error';
            $returnMessage['message'] = $validator->errors()->first();
            return response()->json($returnMessage, 422);
        }

        $project->name = $request->name;
        $project->save();

        return response()->json(['status' => 'success', 'message' => 'Project updated successfully.'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
