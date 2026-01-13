<?php

namespace Support\Traits;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

trait MoveImage {
    public function replacePath( Model $model ): void {


        /** @var Product $model */
        $thumbnail = $model->thumbnail;

        if ( ! $thumbnail ) {
            return;
        }

        $storage = Storage::disk( 'images' );
        $dir     = $model->thumbnailDir();
        $dirItem = $dir . '/original/' . $model->id . '/';
        $storage->makeDirectory( $dirItem );
        $thumbnails = [];
        if ( is_array( $thumbnail ) ) {
            foreach ( $thumbnail as $thumb ) {
                $thumbnails[] = $dirItem . str( $thumb )->afterLast( '/' )->value();
                if ( $storage->exists( $thumb ) ) {
                    $sourcePath      = public_path( 'storage/' . $thumb );
                    $destinationPath = public_path( 'storage/' . $dirItem . basename( $thumb ) );
                    rename( $sourcePath, $destinationPath );
                }

            }
        }

        $model->thumbnail = $thumbnails;
        $model->update();
    }
}
