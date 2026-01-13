<?php

namespace App\Filters;


use App\Filters\AbstractFilter;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Support\ValueObjects\Price;

class PriceFilter extends AbstractFilter {

    public function title(): string {
        return 'Цена';
    }

    public function key(): string {
        return 'price';
    }

    public function apply( Builder $query ): Builder {
        return $query->when( $this->requestValue(), function ( Builder $q ) {
            $q->whereBetween( 'price', [
                $this->requestValue( 'from', 0 ) * 100,
                $this->requestValue( 'to', 100000 ) * 100
            ] );
        } );
    }

    public function values(): array {
        $max_price_product = cache()->remember( 'max_price_product', now()->addDay(), function () {
            return Product::query()->max( 'price' );
        } );

        return [
            'from' => 0,
            'to'   => Price::make( $max_price_product )->value()
        ];
    }

    public function view(): string {
        return 'catalog.filters.price';
    }
}
