<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'plate_number' => 'required',
            'description'  => 'nullable'
        ];
    }
}
