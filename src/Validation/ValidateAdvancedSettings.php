<?php

namespace CryptaTech\Seat\SeatSrp\Validation;

use Illuminate\Foundation\Http\FormRequest;

class ValidateAdvancedSettings extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'default_source' => 'integer|present',
            'default_base' => 'integer|present',
            'default_hull_pc' => 'integer|present',
            'default_fit_pc' => 'integer|present',
            'default_cargo_pc' => 'integer|present',
            'default_price_cap' => 'integer|present|nullable',
        ];
    }
}
