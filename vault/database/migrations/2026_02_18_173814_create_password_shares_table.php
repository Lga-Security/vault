<?php

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
        Schema::create('password_shares', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('password_entry_id')->constrained('password_entries');
            $table->foreignId('shared_by_user_id')->constrained('users');
            $table->foreignId('share_with_user_id')->constrained('users');
            $table->enum('access_level',['view','edit']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_shares');
    }
};
