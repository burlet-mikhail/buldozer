<?php

namespace App\Models;

use App\QueryBuilders\ProductQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;

/**
 * @property int $id
 * @property string $title
 * @property  $slug
 * @property  $link
 * @property  $text
 * @property  $contact
 * @property  $characteristic
 * @property  $region_id
 * @property  $user_id
 * @property  $success
 * @property  $images
 * @property  $viewing
 * @property  $min
 * @property  $price
 * @property array $thumbnail
 */
class Product extends Model {
    use HasFactory, HasThumbnail, HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'link',
        'name',
        'city',
        'company_name',
        'text',
        'contact',
        'characteristic',
        'phone',
        'region_id',
        'user_id',
        'thumbnail',
        'viewing',
        'min',
        'price',
        'messenger',
        'active',
    ];

    public function newEloquentBuilder( $query ): ProductQueryBuilder {
        return new ProductQueryBuilder( $query );
    }

    protected $casts = [
        'characteristic' => 'array',
        'thumbnail'      => 'array',
        'messenger'      => 'array',
    ];

    public function scopeInRegion( $query ) {
        return $query->whereHas( 'region', function ( $query ) {
            $query->where( 'id', region() );
        } );
    }

    public function scopeOptionInCard( $query ) {
        return $query->with( [
            'optionValues' => function ( $query ) {
                $query->whereHas( 'option', function ( $query ) {
                    $query->where( 'show_in_card', true );
                } )->with( 'option' );
            },
        ] );
    }

    public function categories(): BelongsToMany {
        return $this->belongsToMany( Category::class )->orderBy( 'name' );
    }

    public function optionValues(): BelongsToMany {
        return $this->belongsToMany( OptionValue::class );
    }


    public function options() {
        $categoryIds = $this->categories->pluck( 'id' )->all();

        return Option::whereIn( 'id', function ( $query ) use ( $categoryIds ) {
            $query->select( 'option_id' )
                  ->from( 'category_option' )
                  ->whereIn( 'category_id', $categoryIds );
        } )->with( 'optionValues' );
    }


    public function cities(): BelongsToMany {
        return $this->belongsToMany( City::class );
    }


    public function region(): BelongsTo {
        return $this->belongsTo( Region::class );
    }

    public function user(): BelongsTo {
        return $this->belongsTo( User::class );
    }


    public function getMorphClass(): string {
        return 'product';
    }

    public static function slugFrom(): string {
        return 'title';
    }


    public function thumbnailDir(): string {
        return 'products';
    }
}
