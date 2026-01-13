<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCallbackRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name'       => 'required|string',
            'phone'      => 'required|string',
            'product_id' => 'nullable|numeric',
            'user_id'    => 'nullable|numeric',
        ];
    }
}
