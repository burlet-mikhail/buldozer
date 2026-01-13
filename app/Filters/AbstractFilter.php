<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Stringable;


abstract class AbstractFilter implements Stringable {

    public function __invoke( Builder $query, $next ) {
        return $next( $this->apply( $query ) );
    }

    abstract public function title(): string;

    abstract public function key(): string;

    abstract public function apply( Builder $query ): Builder;

    abstract public function values(): mixed;

    abstract public function view(): string;

    public function requestValue( string $index = null, mixed $default = null ): mixed {

        $requestValue = request( 'filters.' . $this->key() . ( $index ? ".$index" : "" ), $default );

        if ( is_array( $requestValue ) ) {
            $requestValue = array_filter( $requestValue, function ( $value ) {
                return $value !== null;
            } );
        }

        return $requestValue;

    }

    public function name( string $index = null ): string {
        // name="filters[key]?[index]"
        return str( $this->key() )
            ->wrap( '[', ']' )
            ->prepend( 'filters' )
            ->when( $index, fn( $str ) => $str->append( "[$index]" ) )
            ->value();
    }

    public function id( string $index = null ): string {
        return str( $this->name( $index ) )
            ->slug( '_' )
            ->value();
    }

    public function __toString(): string {
        return view( $this->view(), [
            'filter' => $this
        ] )->render();
    }
}
