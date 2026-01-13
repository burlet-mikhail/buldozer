<?php

namespace App\Http\Controllers;

use App\Actions\Callback\StoreCallbackAction;
use App\Http\Requests\StoreCallbackRequest;
use App\Jobs\CallbackMailSendJob;
use MoonShine\Laravel\Notifications\MoonShineNotification;
use MoonShine\Laravel\Notifications\NotificationButton;

class CallbackController extends Controller
{
    public function __invoke(StoreCallbackRequest $request): void
    {
        (new StoreCallbackAction())->handle($request);

        CallbackMailSendJob::dispatch($request->validated());

        MoonShineNotification::send(
            message: 'Новая заявка',
            button: new NotificationButton('Перейти в заявки', '/admin/resource/callback-resource')
        );
    }
}
