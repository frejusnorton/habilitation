<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Helpers\Helper;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('titre')->unique();
            $table->string('titreSecondaire')->nullable();
            $table->string('routeName')->nullable();
            $table->string('icone')->nullable();
            $table->boolean('isSubMenu')->default(false);
            $table->unsignedBigInteger('parent')->nullable();
            $table->boolean('hasSubMenu')->default(false);
            $table->string('position')->nullable();
            $table->timestamp('initiated_at')->nullable();
            $table->string('initiated_by')->nullable();
            $table->timestamp('autorized_at')->nullable();
            $table->string('autorized_by')->nullable();
            $table->integer('statut')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
