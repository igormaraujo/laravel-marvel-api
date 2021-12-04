<?php

namespace App\Http\Requests;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ComicRequest extends FormRequest
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
            'nameStartsWith'  => 'required',
            'orderBy'  => ['required', Rule::in(['name', '-name', 'modified', '-modified'])],
            'limit'  => 'required|integer|max:100|min:1',
            'offset'  => 'required|integer|min:0',
        ];
    }

    // cancel redirect at validation error
    protected function failedValidation(Validator $validator){
      return;
    }
}
