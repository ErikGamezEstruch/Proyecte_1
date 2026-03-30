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
        Schema::create('projectes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients');
            $table->foreignId('gestor_id')->constrained('users')->onDelete('cascade');
            $table->string('nom');
            $table->string('codi_projecte')->unique();
            $table->enum('estat', ['PLANIFICACIO', 'EN_CURS', 'PAUSAT', 'FINALIZAT', 'CANCELAT'])->default('PLANIFICACIO');
            $table->date('data_inici')->nullable();
            $table->date('data_fi_prevista')->nullable();
            $table->date('data_fi_real')->nullable();
            $table->integer('pressupost_hores_estimades')->unsigned();
            $table->decimal('pressupost_hores_reals', 10, 2)->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projectes');
    }
};
