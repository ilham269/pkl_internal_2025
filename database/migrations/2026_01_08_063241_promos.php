<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();

            // Relasi ke produk (promo bisa spesifik ke 1 produk)
            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            // Informasi Promo
            $table->string('title');
            $table->text('description')->nullable();

            // Diskon
            $table->unsignedTinyInteger('discount'); // persen (0–100)

            // Banner / thumbnail promo
            $table->string('image')->nullable();

            // Periode Promo
            $table->date('start_date');
            $table->date('end_date');

            // Status
            $table->boolean('active')->default(true);

            $table->timestamps();

            // Index untuk performa
            $table->index(['active', 'start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
