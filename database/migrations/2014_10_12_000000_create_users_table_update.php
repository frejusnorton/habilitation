<?php

use App\Helpers\Helper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->string('password');
            $table->string('role')->index();
            $table->integer('auth_type')->default(0);
            $table->integer('statut')->default(0);
            $table->integer('statut_delete')->default(0);
            $table->softDeletes();
            $table->rememberToken();
            $table->string('initiated_at')->nullable();
            $table->string('initiated_by')->nullable();
            $table->string('autorized_at')->nullable();
            $table->string('autorized_by')->nullable();
            $table->boolean('admin')->default(false);
            $table->boolean('leave')->default(false);

                
            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedBigInteger('agence_id');
            $table->unsignedBigInteger('departement_id')->nullable();
            $table->unsignedBigInteger('direction_id')->nullable();

            $table->unsignedBigInteger('validateur_1')->nullable();
            $table->unsignedBigInteger('validateur_2')->nullable();
            $table->unsignedBigInteger('validateur_3')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
