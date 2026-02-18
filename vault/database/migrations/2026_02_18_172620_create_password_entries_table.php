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
        Schema::create('password_entries', function (Blueprint $table) {
            $table->id('id');
            $table->foreignid('vault_id')->constrained('vaults');
            $table->foreingid('category_id')->constrained('categories')->nullable();
            $table->string('site_name');
            $table->text('username');
            $table->text('password');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_entries');
    }
};
