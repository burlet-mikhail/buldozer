<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller {

    public function create(): View {
        return view( 'auth.register' );
    }


    public function store( RegistrationRequest $request ): RedirectResponse {


        $user = User::create( [
            'name'      => $request->name,
            'phone'     => $request->phone,
            'company'   => $request->company,
            'email'     => $request->email,
            'messenger' => $request->messenger,
            'password'  => Hash::make( $request->password ),
        ] );

        event( new Registered( $user ) );

        Auth::login( $user );

        return redirect( RouteServiceProvider::HOME );
    }
}
