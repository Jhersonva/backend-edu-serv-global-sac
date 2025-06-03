<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_category_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('benefits');
            $table->timestamps();

            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};

