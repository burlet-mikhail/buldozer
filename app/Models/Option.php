<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Option extends Model {
    protected $fillable = [ 'title', 'template', 'sing' ];

    public function optionValues(): HasMany {
        return $this->hasMany( OptionValue::class );
    }

    public function categories(): BelongsToMany {
        return $this->belongsToMany( Category::class );
    }
}
