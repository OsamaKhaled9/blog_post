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
            $table->id(); // primary key
            $table->string('first_name'); //Author first name
            $table->string('last_name'); //Author last name
            $table->string('password'); // Author Password
            $table->string('email')->unique(); // Author Email must be unique
            $table->boolean('is_verified')->default(false); // Whether email is verified or not (default false)
            $table->rememberToken(); // Author remember token when is logged in
            $table->string('photo'); //Author Photo stored in database as string to the location
            $table->string('bio');//Author bio
            $table->timestamps();
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
