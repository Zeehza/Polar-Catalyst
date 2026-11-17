<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('teams')) {
            Schema::create('teams', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->string('name');
                $table->string('logoUrl')->nullable();
                $table->string('tournamentId');
                $table->integer('seed')->nullable();
                $table->string('group')->nullable();
                $table->string('status')->default('ACTIVE');
                $table->dateTime('createdAt')->useCurrent();

                $table->index('tournamentId');
                $table->unique(['tournamentId', 'name']);
                $table->foreign('tournamentId')->references('id')->on('tournaments')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
