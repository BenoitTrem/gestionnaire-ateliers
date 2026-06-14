<?php

/**
 * @author John Sebastian Zuleta Franco
 */

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
        Schema::create('animateur_atelier', function (Blueprint $table) {
            $table->foreignId('animateur_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('atelier_id')
                ->constrained()
                ->onDelete('cascade');

            $table->primary(['animateur_id', 'atelier_id']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animateur_atelier');
    }
};
