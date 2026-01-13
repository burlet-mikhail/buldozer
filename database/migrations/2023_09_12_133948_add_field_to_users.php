<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table( 'users', function ( Blueprint $table ) {
            $table->string( 'phone' );
            $table->string( 'company' )->nullable();
            $table->json( 'messenger' )->nullable();
        } );
    }

    public function down(): void {
        Schema::table( 'users', function ( Blueprint $table ) {
            $table->dropColumn( 'phone' );
            $table->dropColumn( 'company' );
            $table->dropColumn( 'messenger' );
        } );
    }
};
