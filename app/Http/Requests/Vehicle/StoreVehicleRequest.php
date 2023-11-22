<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'plate_number' => 'required',
            'description'  => 'nullable'
        ];
    }
}
