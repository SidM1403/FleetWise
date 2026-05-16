<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'vehicle_number' => 'required|string|unique:vehicles,vehicle_number',
            'vehicle_type' => 'required|string',
            'model' => 'required|string',
            'capacity' => 'required|string',
            'registration_date' => 'required|date',
            'insurance_expiry' => 'required|date',
            'status' => 'required|string|in:active,maintenance,inactive',
        ];
    }
}
