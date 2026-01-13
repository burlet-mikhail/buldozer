<?php

namespace Support\Thumbnail;

use Illuminate\Database\Eloquent\Model;
use Support\Traits\Models\HasThumbnail;

class Thumbnail {


    public function makeOneImage( Model $model, $size, $class = '', $method = 'resize' ): string {
        if ( ! count( $model->images ) ) {
            return view( 'component.image' )->render();
        }


        $url = $model->makeThumbnail( $model->image(), $size, $model->id, $method );

        return self::makeHtml( $url, $class );
    }

    public function makeImageUrl( Model $model, $size, $class = '', $method = 'resize' ): string {
        if ( ! count( $model->images ) ) {
            return view( 'component.image' )->render();
        }

        $url = $model->makeThumbnail( $model->image(), $size, $model->id, $method );

        return self::makeHtml( $url, $class );
    }

    public function originalImage( $image, $id ): string {
        $dir  = str( $image )->before( '/' )->value();
        $name = str( $image )->afterLast( '/' )->value();

        return '/storage/' . $dir . '/original/' . $id . '/' . $name;
    }


    public function makeHtml( $url, $class ): string {
        return view( 'component.image', compact( 'url', 'class' ) )->render();
    }


}
