<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Importar DB para hacer insert

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('company_contact', function (Blueprint $table) {
            $table->id();
            $table->string('address', 250);
            $table->string('phone', 15);
            $table->text('email');
            $table->text('url_map');
            $table->text('cordenadas_map');
            $table->timestamps();
        });

        // Insertar registro inicial
        DB::table('company_contact')->insert([
            'address' => 'Av. Ejemplo 123, Ciudad',
            'phone' => '1234567890',
            'email' => 'contacto@empresa.com',
            'url_map' => 'https://maps.google.com/?q=Av+Ejemplo+123',
            'cordenadas_map' => '40.7128,-74.0060',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_contact');
    }
};
