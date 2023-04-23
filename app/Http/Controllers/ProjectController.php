<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Repositories\ProjectRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    /**
     * Response trait to handle return responses.
     */
    use ResponseTrait;

    /**
     * Project Repository class.
     *
     * @var ProjectRepository
     */
    public $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        // $this->middleware('auth:api', ['except' => ['indexAll']]);
        $this->projectRepository = $projectRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $data = $this->projectRepository->getAll();
            return $this->responseSuccess($data, 'Project List Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function indexAll(Request $request): JsonResponse
    {
        try {
            $data = $this->projectRepository->getPaginatedData($request->perPage);
            return $this->responseSuccess($data, 'Project List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function search(Request $request): JsonResponse
    {
        try {
            $data = $this->projectRepository->searchProject($request->search, $request->perPage);
            return $this->responseSuccess($data, 'Project List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(ProjectRequest $request): JsonResponse
    {
        try {
            $project = $this->projectRepository->create($request->all());
            return $this->responseSuccess($project, 'New Project Created Successfully !');
        } catch (\Exception $exception) {
            return $this->responseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $data = $this->projectRepository->getByID($id);
            if (is_null($data)) {
                return $this->responseError(null, 'Project Not Found', Response::HTTP_NOT_FOUND);
            }

            return $this->responseSuccess($data, 'Project Details Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function update(ProjectRequest $request, $id): JsonResponse
    {
        try {
            $data = $this->projectRepository->update($id, $request->all());
            if (is_null($data))
                return $this->responseError(null, 'Project Not Found', Response::HTTP_NOT_FOUND);

            return $this->responseSuccess($data, 'Project Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

   public function destroy($id): JsonResponse
    {
        try {
            $project =  $this->projectRepository->getByID($id);
            if (empty($project)) {
                return $this->responseError(null, 'Project Not Found', Response::HTTP_NOT_FOUND);
            }

            $deleted = $this->projectRepository->delete($id);
            if (!$deleted) {
                return $this->responseError(null, 'Failed to delete the project.', Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return $this->responseSuccess($project, 'Project Deleted Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}