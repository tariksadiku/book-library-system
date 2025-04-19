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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50);
            $table->string('cover_url', 50);
            $table->string('isbn', 14);
            $table->foreignId('author_id')->constrained('authors');
            $table->timestamps();
        });
    }
};
