<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('matches')) {
            Schema::create('matches', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->string('tournamentId');
                $table->integer('roundNumber');
                $table->integer('matchOrder');
                $table->string('teamAId')->nullable();
                $table->string('teamBId')->nullable();
                $table->integer('scoreA')->nullable();
                $table->integer('scoreB')->nullable();
                $table->string('winnerId')->nullable();
                $table->string('status')->default('SCHEDULED');
                $table->dateTime('scheduledAt')->nullable();
                $table->dateTime('playedAt')->nullable();
                $table->text('notes')->nullable();
                $table->dateTime('createdAt')->useCurrent();
                $table->dateTime('updatedAt')->useCurrent()->useCurrentOnUpdate();

                $table->unique(['tournamentId', 'roundNumber', 'matchOrder']);
                $table->index('tournamentId');
                $table->index('scheduledAt');
                $table->index('status');

                $table->foreign('tournamentId')->references('id')->on('tournaments')->onDelete('cascade');
                $table->foreign('teamAId')->references('id')->on('teams')->onDelete('set null');
                $table->foreign('teamBId')->references('id')->on('teams')->onDelete('set null');
                $table->foreign('winnerId')->references('id')->on('teams')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
