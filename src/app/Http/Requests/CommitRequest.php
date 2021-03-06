<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommitRequest extends FormRequest
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
            'limit' => 'required|date_format:Y-m-d|after:yesterday',
            'status.*' => 'required',
            'priority.*' => 'required|distinct',
            'content.*' => 'required'
        ];
    }
}
