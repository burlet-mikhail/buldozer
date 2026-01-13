<?php

namespace App\Models;

use App\Collections\OptionValueCollection;
use App\Collections\ProductCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OptionValue extends Model {
    protected $fillable = [ 'id', 'title', 'option_id' ];

    public function option(): BelongsTo {
        return $this->belongsTo( Option::class );
    }

    public function optionInCard(): BelongsTo {
        return $this->belongsTo( Option::class );
    }

    public function products(): BelongsToMany {
        return $this->belongsToMany( Product::class );
    }

    public function newCollection( array $models = [] ): OptionValueCollection {
        return new OptionValueCollection( $models );
    }
}

