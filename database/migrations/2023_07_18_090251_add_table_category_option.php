<?php

use App\Models\Category;
use App\Models\Option;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create( 'category_option', function ( Blueprint $table ) {
            $table->id();

            $table->foreignIdFor( Category::class )
                  ->constrained()
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->foreignIdFor( Option::class )
                  ->constrained()
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

        } );
    }

    public function down(): void {
        Schema::dropIfExists( 'category_product' );
    }
};
