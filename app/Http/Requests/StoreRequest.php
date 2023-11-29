<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'from_warehouse_id' => 'required|numeric|min:1',
            'to_warehouse_id'   => 'required|numeric|min:1'
        ];
    }

    /**
     * Show the Messages for rules above.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'from_warehouse_id.required' => 'Please select from warehouse',
            'to_warehouse_id.required'   => 'Please select to warehouse.',         
            'from_warehouse_id.numeric' => 'Please select from warehouse',
            'to_warehouse_id.numeric'   => 'Please select to warehouse.'
            
        ];
    }
}
