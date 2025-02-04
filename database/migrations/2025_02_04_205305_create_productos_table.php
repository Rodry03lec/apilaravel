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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string("nombre", 200);
            $table->decimal("precio", 10, 2)->nullable();
            $table->string("imagen")->nullable();
            $table->text("descripcion")->nullable();
            $table->integer("stock")->nullable();
            $table->boolean("estado")->default(true);

            $table->unsignedBigInteger('categoria_id');
            $table->foreign("categoria_id")->references("id")->on('categorias');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
