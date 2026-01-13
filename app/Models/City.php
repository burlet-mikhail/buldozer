<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Traits\Models\HasSlug;

/**
 * @var  int $region_id
 */
class City extends Model {
    use HasFactory, HasSlug;

    protected $fillable = [ 'name', 'slug', 'region_id', 'active' ];

    public function region(): BelongsTo {
        return $this->belongsTo( Region::class );
    }

    public function scopeWithRegion( Builder $query ): Builder {
        return $query->whereHas( 'region', function ( $query ) {
            $query->where( 'id', region() );
        } );
    }

    public function scopeWithProductsInIds( Builder $query, $productIds ): Builder {
        return $query->whereHas( 'products', function ( $query ) use ( $productIds ) {
            $query->whereIn( 'products.id', $productIds );
        } );
    }

    public function products(): BelongsToMany {
        return $this->belongsToMany( Product::class );
    }
}
