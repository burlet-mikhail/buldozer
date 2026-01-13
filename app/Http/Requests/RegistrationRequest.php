<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegistrationRequest extends FormRequest {


    public function prepareForValidation() {
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
            'name'     => [ 'required', 'string', 'max:255' ],
            'email'    => [ 'required', 'string', 'email', 'max:255', 'unique:' . User::class ],
            'password' => [ 'required', 'confirmed', Password::defaults() ],
            'phone'    => [ 'required', 'string', 'max:25' ],
            'company'  => [ 'required', 'string', 'max:150' ],
        ];
    }
}
