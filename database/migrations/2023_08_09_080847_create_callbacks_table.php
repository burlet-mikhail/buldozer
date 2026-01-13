<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'callbacks', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'name' );
            $table->string( 'phone' );
            $table->foreignIdFor( Product::class )->nullable();
            $table->foreignIdFor( User::class )->nullable();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'callbacks' );
    }
};
