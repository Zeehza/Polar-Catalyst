<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('contact_submissions')) {
            Schema::create('contact_submissions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->string('name');
                $table->string('company')->nullable();
                $table->string('email');
                $table->text('message');
                $table->boolean('emailSent')->default(false);
                $table->boolean('discordSent')->default(false);
                $table->boolean('isRead')->default(false);
                $table->dateTime('createdAt')->useCurrent();

                $table->index('isRead');
                $table->index('createdAt');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_submissions');
    }
};
