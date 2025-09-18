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
        Schema::create('our_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('nep_title')->nullable();
            $table->string('description');
            $table->text('nep_description')->nullable();
            $table->string('image');
            $table->date('campaigns_date');
            $table->boolean('publish_status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('our_campaigns');
    }
};
