<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('tournaments')) {
            Schema::create('tournaments', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->string('name');
                $table->string('season')->default('Season 1');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->string('game');
                $table->string('type')->default('PLAYOFF');
                $table->string('status')->default('DRAFT');
                $table->string('bannerUrl')->nullable();
                $table->dateTime('startDate');
                $table->dateTime('endDate')->nullable();
                $table->dateTime('createdAt')->useCurrent();
                $table->dateTime('updatedAt')->useCurrent()->useCurrentOnUpdate();

                $table->index('status');
                $table->index('name');
                $table->unique(['name', 'season']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
