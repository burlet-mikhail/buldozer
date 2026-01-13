<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CallbackMailNotification extends Mailable {
    use Queueable, SerializesModels;

    public array $callback;

    public function __construct( array $callback ) {
        $this->callback = $callback;
    }

    public function build(): CallbackMailNotification {
        return $this->view( 'mail.callback_mail', [ 'callback' => $this->callback ] )
                    ->subject( 'Новая заявка!' );
    }
}
