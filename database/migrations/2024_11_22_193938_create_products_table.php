<?php

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
            $table->id(); // Primary key
            $table->string('product_id')->nullable()->default(null)->unique(); // Secondary identifier for business use // Cikkszám
            $table->string('product_number')->nullable()->unique();;
            $table->string('ean', 13)->nullable()->unique(); // EAN kód

            $table->string('name'); // Termék neve
            $table->string('packaging', 25)->nullable(); // Csomagolás
            $table->text('description')->nullable(); // Termék leírása
            $table->decimal('price', 18, 2)->nullable(); // Termék ára
            $table->boolean('on_sale')->default(false); // Akciós-e
            $table->boolean('is_active')->default(false, );

            // SEO DATA
            $table->json('og_data')->nullable()->default(null);
            $table->json('meta_data')->nullable()->default(null);

            $table->fullText(['name', 'product_id', 'description', 'product_number', 'ean', 'packaging'], 'adob_fulltext');

            //relationships
            $table->foreignId('brand_id')
                ->constrained()         // Reference the 'id' column in the 'brands' table
                ->restrictOnDelete();   // Prevent deletion of the brand if products exist

            $table->timestamps();
            $table->softDeletes();

            $table->index('name');
            $table->index('brand_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
