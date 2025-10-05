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
        Schema::create('our_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('nep_title');
            $table->date('deadline');
            $table->text('description');
            $table->text('nep_description');
            $table->string('price');
            $table->boolean('publish_status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
