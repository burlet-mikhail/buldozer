<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class Image {
    public function processFiles( $files, $id ): \Illuminate\Http\JsonResponse|array {

        if ( ! $files ) {
            return response()->json( [ 'error' => 'Файлы не были загружены' ], 400 );
        }
        $path = [];
        foreach ( $files as $file ) {
            if ( $file->isValid() ) {
                $fileName = uniqid( 'image_' ) . '.' . $file->getClientOriginalExtension();
                info( $fileName );
                $folder = 'products/original/' . $id . '/';
                Storage::disk( 'images' )->putFileAs( $folder, $file, $fileName );
                $path[] = $folder . $fileName;
                info( $folder . $fileName );
            }

        }

        return $path;
    }

}
