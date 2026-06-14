<?php
/**
 * @author Benoit Tremblay.
 * @author John Sebastaian gestions clés étrangéres
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
        Schema::create('locals', function (Blueprint $table) {
            $table->id();
            $table->string('numeroLocal')->unique();
            $table->foreignId('campus_id')
                ->constrained('campuses')
                ->onDelete('cascade');
            $table->integer('capacite');
            $table->boolean('disponibilite');
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locals');
    }
};
