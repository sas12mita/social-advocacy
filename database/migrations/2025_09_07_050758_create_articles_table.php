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
            $table->id();
            $table->text('heading');
            $table->text('nep_heading')->nullable();
            $table->text('slug');
            $table->foreignId('article_category_id')->constrained('article_categories')->cascadeOnDelete();
            $table->text('body');
            $table->text('nep_body')->nullable();
            $table->json('image')->nullable();
            $table->integer('view')->nullable();
            $table->boolean('published_status')->default(false);
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
