<?php
namespace App\Http\Requests\Projects;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateProjectRequest extends FormRequest
{
    public function rules()
    {
        $nameAdditionalRule = Rule::unique('projects', 'name');

        if ($this->project) {
            $nameAdditionalRule = $nameAdditionalRule->ignore($this->project->id);
        }
        return [
            'name' => [
                'required',
                $nameAdditionalRule,
            ]
        ];
    }
}
