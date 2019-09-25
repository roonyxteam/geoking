<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
            
            'query' => 'required |min:3|max:25',
            //'type' => 'required',
        ];
    }

  
  public function messages()
{
    return [
        
        'query.required' => 'Enter the search request',
        //'type.required' => 'Select type',
      
    ];
}



}
