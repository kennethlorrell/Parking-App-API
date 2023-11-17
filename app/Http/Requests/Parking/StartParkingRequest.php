<?php

namespace App\Http\Requests\Parking;

use Illuminate\Foundation\Http\FormRequest;

class StartParkingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'vehicle_id' => [
                'required',
                'numeric',
                'integer',
                'exists:vehicles,id,deleted_at,NULL,user_id,' . auth()->id(),
            ],
            'zone_id' => [
                'required',
                'numeric',
                'integer',
                'exists:zones,id'
            ]
        ];
    }
}
