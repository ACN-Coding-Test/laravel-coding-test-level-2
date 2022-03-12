<?php

namespace App\Http\Requests\Task;

use App\Models\Task as ModelTask;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateTask extends FormRequest
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
            'title'=> 'required|max:255',
            'description'=> 'required|max:255',
            'status'=> 'required',
            'project_id'=> 'required|exists:projects,id',
            'user_id'=> 'required|exists:users,id',
        ];
    }

    public function persist($id)
    {
        try {
            $Task = ModelTask::findOrFail($id);
            $Task->update(Request::all());
            return $Task;
        } catch (Exception $e) {
           return "Task Not Found";
        }
    }
}
