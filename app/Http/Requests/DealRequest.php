<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealRequest extends FormRequest
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
            'Deal_Name' => 'required|string',
            'Overall_Sales_Duration' => 'required|integer',
            'Sales_Cycle_Duration' => 'required|integer',
            'Stage' => 'required|string',
            'Closing_Date' => 'required|date_format:Y-m-d',
        ];
    }
}
