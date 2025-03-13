<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flux_historiques', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('demande_id');
            $table->unsignedBigInteger('validatedBy');
            $table->string('commentaires')->nullable();
            $table->integer('statut')->default(0);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    
    public function down(): void
    {
        Schema::dropIfExists('flux_historiques');
    }
};
