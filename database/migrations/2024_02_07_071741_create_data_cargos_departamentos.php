<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Departamento;
use App\Models\Cargo;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Departamento::create(['nombre' => 'Tecnologia de la informacion', 'usuario_creacion' => 1]);
        Departamento::create(['nombre' => 'Legal', 'usuario_creacion' => 1]);
        Departamento::create(['nombre' => 'Seguridad', 'usuario_creacion' => 1]);
        Departamento::create(['nombre' => 'Eventos', 'usuario_creacion' => 1]);
        Cargo::create(['nombre' => 'Administrador', 'usuario_creacion' => 1]);
        Cargo::create(['nombre' => 'Abogado', 'usuario_creacion' => 1]);
        Cargo::create(['nombre' => 'Desarrollador', 'usuario_creacion' => 1]);
        Cargo::create(['nombre' => 'Guardia', 'usuario_creacion' => 1]);
        Cargo::create(['nombre' => 'Pollero', 'usuario_creacion' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      
    }
};
