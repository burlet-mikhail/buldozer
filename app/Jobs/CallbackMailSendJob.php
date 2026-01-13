<?php

namespace App\Jobs;


use App\Mail\CallbackMailNotification;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class CallbackMailSendJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $callback;

    public function __construct( array $callback ) {
        $this->callback = $callback;
    }

    public function handle(): void {
        if ( $id = $this->callback['product_id'] ) {
            $product                   = Product::query()->find( $id );
            $this->callback['product'] = [
                'title' => $product->title,
                'link'  => route( 'products.show', $product->slug ),
            ];
        }
        Mail::to( config( 'mail.mail_admin' ) )->queue( new CallbackMailNotification( $this->callback ) );
    }
}
