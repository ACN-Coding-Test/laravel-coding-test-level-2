<?php

namespace App\Http\Requests\Project;

use App\Models\Project as ModelProject;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreProject extends FormRequest
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
            'name' => 'required|unique:projects|max:255',
        ];
    }

    public function persist()
    {
        return ModelProject::create(Request::all());
    }

    
}
