<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->unique();
            $table->string('link')->nullable();
            $table->text('text')->nullable();
            $table->text('contact')->nullable();
            $table->boolean('premium')->default(false);
            $table->json('characteristic')->nullable();
            $table->foreignIdFor( Region::class);
            $table->foreignIdFor( User::class)->nullable();
            $table->timestamps();
        });

        Schema::create( 'category_product', function ( Blueprint $table ) {
            $table->id();

            $table->foreignIdFor( Category::class )
                  ->constrained()
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->foreignIdFor( Product::class )
                  ->constrained()
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

        } );
        Schema::create( 'region_product', function ( Blueprint $table ) {
            $table->id();

            $table->foreignIdFor( Region::class )
                  ->constrained()
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->foreignIdFor( Product::class )
                  ->constrained()
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('region_product');
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('products');
    }
};
