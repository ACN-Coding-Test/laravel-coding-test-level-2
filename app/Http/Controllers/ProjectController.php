<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projects;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\Project\StoreRequest as ProjectStoreRequest;
use App\Http\Requests\Project\UpdateRequest as ProjectUpdateRequest;
use App\Http\Middleware\ProductOwnerAccess;
use App\Http\Traits\PaginateTrait;


class ProjectController extends Controller
{
    use PaginateTrait;

    public function __construct()
    {
        $this->middleware([ProductOwnerAccess::class])->only(['store']);

    }

    public function index(Request $request)
    {
        $query = Projects::DtFilter($request);

        $setDatatable = $this->setDatatable($request,$query,'name');

        return ProjectResource::collection($setDatatable);
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
    public function store(ProjectStoreRequest $request)
    {
        $validated = $request->validated();

        $query = Projects::create($validated);
    
        return new ProjectResource($query);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Projects $project)
    {
        return new ProjectResource($project);

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
    public function update(ProjectUpdateRequest $request,Projects $project)
    {
        $validated = $request->validated();

        $query = $project->update($validated);

        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Projects $project)
    {
      $project->delete();

      return response()->json(true, 204);
    }
}
