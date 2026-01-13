<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table( 'categories', function ( Blueprint $table ) {
            $table->boolean( 'show_in_home' )->default( false );
            $table->boolean( 'show_in_menu' )->default( false );
            $table->boolean( 'show_in_popular' )->default( false );
            $table->boolean( 'show_in_not_popular' )->default( false );
            $table->string( 'thumbnail' )->nullable();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table( 'categories', function ( Blueprint $table ) {
            $table->dropColumn( 'show_in_home' );
            $table->dropColumn( 'show_in_menu' );
            $table->dropColumn( 'show_in_popular' );
            $table->dropColumn( 'show_in_not_popular' );
            $table->dropColumn( 'thumbnail' );
        } );
    }
};
