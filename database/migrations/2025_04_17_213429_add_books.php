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
            $table->string('name', 50);
            $table->string('image', 50);
            $table->string('isbn', 13);
            $table->foreignId('author_id')->constrained('authors');
            $table->timestamps();
        });
    }
};
