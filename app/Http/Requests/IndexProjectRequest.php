<?php

namespace App\Http\Requests;

use App\Helpers\ApiHelper;
use Illuminate\Foundation\Http\FormRequest;

class IndexProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'q' => [
                'nullable',
                'max:255'
            ],
            'pageIndex' => [
                'required',
                'numeric'
            ],
            'pageSize' => [
                'required',
                'numeric'
            ],
            'sortBy' => [
                'required',
                ApiHelper::getAllSortByValsForProjectValidation()
            ],
            'sortDirection' => [
                'required',
                ApiHelper::getAllSortDirectionValsForValidation()
            ],
        ];
    }
}
