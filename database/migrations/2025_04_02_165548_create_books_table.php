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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('isbn', 20)->unique();
            $table->foreignId('publisher_id')->constrained('publishers')->onDelete('cascade');
            $table->year('year_published');
            $table->unsignedTinyInteger('edition')->nullable();
            $table->unsignedInteger('stock_total')->default(1);
            $table->unsignedInteger('stock_available')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
