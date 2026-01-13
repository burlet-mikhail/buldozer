<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property  $name
 * @property  $phone
 * @property  $product_id
 * @property  $user_id
 */
class Callback extends Model {

    protected $fillable = [ 'name', 'phone', 'product_id', 'user_id' ];

    public function product(): BelongsTo {
        return $this->belongsTo( Product::class );
    }

    public function user(): BelongsTo {
        return $this->belongsTo( User::class );
    }
}
