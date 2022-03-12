<?php

namespace App\Http\Requests\Project;

use App\Models\Project as ModelProject;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class UpdateProject extends FormRequest
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
            'name' => ['required', Rule::unique('projects')->ignore($this->name)],
        ];
    }

    public function persist($id)
    {
        try {
            $Project = ModelProject::findOrFail($id);
            $Project->update(Request::all());
            return $Project;
        } catch (Exception $e) {
           return "Project Not Found";
        }

     
    }
    
}
