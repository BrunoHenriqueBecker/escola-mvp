<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->enum('tipo',['prova','trabalho','atividade']);
            $table->date('data')->nullable();
            $table->text('descricao')->nullable();
            $table->foreignId('turma_id')->constrained('turmas')->cascadeOnDelete();
            $table->timestamps();
            $table->index(['tipo','data']);
        });
    }
    public function down(): void { Schema::dropIfExists('activities'); }
};