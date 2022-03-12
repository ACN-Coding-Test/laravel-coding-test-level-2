<?php

namespace App\Http\Requests\Task;

use App\Models\Task as ModelTask;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PatchTask extends FormRequest
{

    public function __construct(
        Request $request
    ) {
        parent::__construct();
        $this->request = $request;
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'=> 'sometimes|max:255',
            'description'=> 'sometimes|max:255',
            'status'=> 'sometimes',
            'project_id'=> 'sometimes|exists:projects,id',
            'user_id'=> 'sometimes|exists:users,id',
        ];
    }

    public function persist($id)
    {
        try {
            $task = ModelTask::findOrFail($id);
            $task->update(Request::only('title','description','status','project_id','user_id'));
            return $task;
        } catch (Exception $e) {
           return "Task Not Found";
        }
    }
}
