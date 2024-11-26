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
        Schema::create('articles', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId("author_id")->constrained("authors")->onDelete('cascade'); // Foreign key with cascade on delete
            $table->string("title", 255)->nullable(false); // VARCHAR(255) NOT NULL
            $table->string("description", 500)->nullable(false); // VARCHAR(500) NOT NULL
            $table->integer("status")->default(0)->nullable(false); // INT NOT NULL DEFAULT 0
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
