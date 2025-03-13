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
        Schema::create('applications_role', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->unique();
            $table->integer('statut')->default(0);
            $table->unsignedBigInteger('application_id');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications_role');
    }
};
