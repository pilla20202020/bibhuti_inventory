<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;


class PurchaseRequest extends FormRequest
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
        $rules = [
            'supplier_id'=>'required'
        ];

        return $rules;
    }
}
