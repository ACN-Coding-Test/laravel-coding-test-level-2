<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Repositories\TaskRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * Response trait to handle return responses.
     */
    use ResponseTrait;

    /**
     * Task Repository class.
     *
     * @var TaskRepository
     */
    public $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        // $this->middleware('auth:api', ['except' => ['indexAll']]);
        $this->taskRepository = $taskRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $data = $this->taskRepository->getAll();
            return $this->responseSuccess($data, 'Task List Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function indexAll(Request $request): JsonResponse
    {
        try {
            $data = $this->taskRepository->getPaginatedData($request->perPage);
            return $this->responseSuccess($data, 'Task List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function search(Request $request): JsonResponse
    {
        try {
            $data = $this->taskRepository->searchTask($request->search, $request->perPage);
            return $this->responseSuccess($data, 'Task List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(TaskRequest $request): JsonResponse
    {
        try {
            $task = $this->taskRepository->create($request->all());
            return $this->responseSuccess($task, 'New Task Created Successfully !');
        } catch (\Exception $exception) {
            return $this->responseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $data = $this->taskRepository->getByID($id);
            if (is_null($data)) {
                return $this->responseError(null, 'Task Not Found', Response::HTTP_NOT_FOUND);
            }

            return $this->responseSuccess($data, 'Task Details Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function update(TaskRequest $request, $id): JsonResponse
    {
        try {
            $data = $this->taskRepository->update($id, $request->all());
            if (is_null($data))
                return $this->responseError(null, 'Task Not Found', Response::HTTP_NOT_FOUND);

            return $this->responseSuccess($data, 'Task Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

   public function destroy($id): JsonResponse
    {
        try {
            $task =  $this->taskRepository->getByID($id);
            if (empty($task)) {
                return $this->responseError(null, 'Task Not Found', Response::HTTP_NOT_FOUND);
            }

            $deleted = $this->taskRepository->delete($id);
            if (!$deleted) {
                return $this->responseError(null, 'Failed to delete the task.', Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return $this->responseSuccess($task, 'Task Deleted Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}