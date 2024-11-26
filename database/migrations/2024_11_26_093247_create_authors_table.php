<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('first_name', 255)->nullable(false); // VARCHAR(255) NOT NULL
            $table->string('last_name', 255)->nullable(false); // VARCHAR(255) NOT NULL
            $table->string('password', 255)->nullable(false); // Encrypted password, VARCHAR(255) NOT NULL
            $table->string('email', 255)->unique()->nullable(false); // Unique email, VARCHAR(255) NOT NULL
            $table->boolean('is_verified')->default(false)->nullable(false); // Email verification status, default false
            $table->rememberToken(); 
            $table->string('photo', 255)->nullable(true); // Optional, VARCHAR(255)
            $table->string('bio', 50)->nullable(true); // Optional, VARCHAR(50)
            $table->timestamps(); // Timestamps for created_at and updated_at
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
