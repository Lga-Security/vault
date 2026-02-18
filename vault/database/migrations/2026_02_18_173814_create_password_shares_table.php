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
            $table->foreignid('password_entry_id')->constrained('password_entries');
            $table->foreingid('shared_by_user_id')->constrained('users');
            $table->foreignid('share_with_user_id')->constrained('users');
            $tabme->enum('access_level',['view','edit']);
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
