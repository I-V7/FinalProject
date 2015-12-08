<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
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
        return
            [
                //title rule that requires an input of 5 or more characters
                'name' => 'required',
                //author rule
                'class' => 'required',
                //year rule
                'teamstyle' => 'required',
                //comments rule
                'language' => 'required'
            ];
    }
}
