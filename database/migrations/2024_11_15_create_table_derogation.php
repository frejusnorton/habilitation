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
        Schema::create('derogations', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email');
            $table->string('poste');

            $table->string('reference');
            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('profil_id');
            $table->unsignedBigInteger('created_by');

            $table->integer('statut')->defaut(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('derogations');
    }
};
