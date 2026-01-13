<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest {
    public function prepareForValidation(): void {
        $messenger = [
            'whatsapp' => ! ! $this->get( 'whatsapp' ),
            'viber'    => ! ! $this->get( 'viber' ),
            'telegram' => ! ! $this->get( 'telegram' ),
        ];
        $this->merge( [ 'messenger' => $messenger ] );
    }

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'title'           => 'required|string|max:50',
            'text'            => 'required|string|max:500',
            'city'            => 'required|string|max:50',
            'contact'         => 'required|string|max:50',
            'min'             => 'required|string|max:50',
            'price'           => 'required|string|max:50',
            'select_category' => 'required|numeric',
            'selectedOptions' => 'nullable|array',
        ];
    }
}
