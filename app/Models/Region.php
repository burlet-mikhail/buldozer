<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Traits\Models\HasSlug;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property bool $active
 * @property bool $default
 */
class Region extends Model {
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'active',
        'default',
    ];

    public function products(): HasMany {
        return $this->hasMany( Product::class );
    }

    public function cities(): HasMany {
        return $this->hasMany( City::class )->orderBy( 'name' );
    }


}
