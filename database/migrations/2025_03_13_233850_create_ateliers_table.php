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
        Schema::create('ateliers', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description');
            $table->foreignId('local_id')->nullable()->constrained('locals')->onDelete('set null');
            $table->foreignId('campus_id')->nullable()->constrained('campuses')->onDelete('cascade');
            $table->string('url_inscription')->nullable();
            $table->date('date');
            $table->time('heure_debut');
            $table->integer('duree_minutes');
            $table->string('statut');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ateliers');
    }
};
