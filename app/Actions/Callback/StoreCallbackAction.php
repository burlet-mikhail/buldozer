<?php

namespace App\Actions\Callback;

use App\Http\Requests\StoreCallbackRequest;
use App\Models\Callback;

class StoreCallbackAction {
    public function handle( StoreCallbackRequest $request ): void {
        Callback::query()->create( [
            'name'       => $request->validated( 'name' ),
            'phone'      => $request->validated( 'phone' ),
            'product_id' => $request->validated( 'product_id' ),
            'user_id'    => $request->validated( 'user_id' ),
        ] );
    }
}
