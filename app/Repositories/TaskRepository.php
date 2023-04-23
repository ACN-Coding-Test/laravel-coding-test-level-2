<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Helpers\UploadHelper;
use App\Interfaces\CrudInterface;
use App\Models\Project;
use App\Models\User;
use App\Models\Task;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class TaskRepository implements CrudInterface
{
    /**
     * Authenticated User Instance.
     *
     * @var User
     */
    public User $user;
    public Project $project;
    public Task $task;

    /**
     * Constructor.
     */
    public function __construct()
    {
        // $this->user = Auth::guard()->user();
    }

    /**
     * Get All Tasks.
     *
     * @return collections Array of Task Collection
     */
    public function getAll(): Paginator
    {
        return Task::orderBy('id', 'desc')
            ->with('user')
            ->with('project')
            ->paginate(10);
    }

    /**
     * Get Paginated Task Data.
     *
     * @param int $pageNo
     * @return collections Array of Task Collection
     */
    public function getPaginatedData($perPage): Paginator
    {
        $perPage = isset($perPage) ? intval($perPage) : 12;
        return Task::orderBy('id', 'desc')
            ->with('user')
            ->with('project')
            ->paginate($perPage);
    }

    /**
     * Get Searchable Task Data with Pagination.
     *
     * @param int $pageNo
     * @return collections Array of Task Collection
     */
    public function searchTask($keyword, $perPage): Paginator
    {
        $perPage = isset($perPage) ? intval($perPage) : 10;

        return Task::where('title', 'like', '%' . $keyword . '%')
            ->orWhere('description', 'like', '%' . $keyword . '%')
            ->orWhere('price', 'like', '%' . $keyword . '%')
            ->orderBy('id', 'desc')
            ->with('user')
            ->paginate($perPage);
    }

    /**
     * Create New Task.
     *
     * @param array $data
     * @return object Task Object
     */
    public function create(array $data): Task
    {
        // $data['user_id'] = $this->user->id;

        return Task::create($data);
    }

    /**
     * Delete Task.
     *
     * @param int $id
     * @return boolean true if deleted otherwise false
     */
    public function delete(int $id): bool
    {
        $product = Task::find($id);
        if (empty($product)) {
            return false;
        }
        $product->delete($product);
        return true;
    }

    /**
     * Get Task Detail By ID.
     *
     * @param int $id
     * @return void
     */
    public function getByID(int $id): Task
    {
        return Task::with('user')->with('project')->find($id);
    }

    /**
     * Update Task By ID.
     *
     * @param int $id
     * @param array $data
     * @return object Updated Task Object
     */
    public function update(int $id, array $data): Task
    {
        $product = Task::find($id);
        if (is_null($product)) {
            return null;
        }

        // If everything is OK, then update.
        $product->update($data);

        // Finally return the updated product.
        return $this->getByID($product->id);
    }
}