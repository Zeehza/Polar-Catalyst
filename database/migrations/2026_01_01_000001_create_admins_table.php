<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('admins')) {
            Schema::create('admins', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->string('username')->unique();
                $table->string('passwordHash');
                $table->dateTime('createdAt')->useCurrent();
                $table->dateTime('updatedAt')->useCurrent()->useCurrentOnUpdate();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
