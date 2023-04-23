<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Helpers\UploadHelper;
use App\Interfaces\CrudInterface;
use App\Models\Project;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class ProjectRepository implements CrudInterface
{
    /**
     * Authenticated User Instance.
     *
     * @var User
     */
    public User $user;
    public Project $project;

    /**
     * Constructor.
     */
    public function __construct()
    {
        // $this->user = Auth::guard()->user();
    }

    /**
     * Get All Projects.
     *
     * @return collections Array of Project Collection
     */
    public function getAll(): Paginator
    {
        return Project::orderBy('id', 'desc')
            ->paginate(10);
    }

    /**
     * Get Paginated Project Data.
     *
     * @param int $pageNo
     * @return collections Array of Project Collection
     */
    public function getPaginatedData($perPage): Paginator
    {
        $perPage = isset($perPage) ? intval($perPage) : 12;
        return Project::orderBy('id', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get Searchable Project Data with Pagination.
     *
     * @param int $pageNo
     * @return collections Array of Project Collection
     */
    public function searchProject($keyword, $perPage): Paginator
    {
        $perPage = isset($perPage) ? intval($perPage) : 10;

        return Project::where('title', 'like', '%' . $keyword . '%')
            ->orWhere('description', 'like', '%' . $keyword . '%')
            ->orWhere('price', 'like', '%' . $keyword . '%')
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }

    /**
     * Create New Project.
     *
     * @param array $data
     * @return object Project Object
     */
    public function create(array $data): Project
    {
        return Project::create($data);
    }

    /**
     * Delete Project.
     *
     * @param int $id
     * @return boolean true if deleted otherwise false
     */
    public function delete(int $id): bool
    {
        $project = Project::find($id);
        if (empty($project)) {
            return false;
        }
        $project->delete($project);
        return true;
    }

    /**
     * Get Project Detail By ID.
     *
     * @param int $id
     * @return void
     */
    public function getByID(int $id): Project
    {
        return Project::findOrFail($id);
    }

    /**
     * Update Project By ID.
     *
     * @param int $id
     * @param array $data
     * @return object Updated Project Object
     */
    public function update(int $id, array $data): Project
    {
        $project = Project::find($id);

        if (is_null($project)) {
            return null;
        }

        // If everything is OK, then update.
        $project->update($data);

        // Finally return the updated project.
        return $this->getByID($project->id);
    }
}