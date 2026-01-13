<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table( 'options', function ( Blueprint $table ) {
            $table->string( 'sing' )->nullable();
        } );
    }

    public function down(): void {
        Schema::table( 'options', function ( Blueprint $table ) {
            $table->dropColumn( 'sing' );
        } );
    }
};
