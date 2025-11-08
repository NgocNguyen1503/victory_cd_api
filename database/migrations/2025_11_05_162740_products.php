<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id()->index();
            $table->string('name', 255)->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->text('description')->nullable();
            $table->string('thumbnail_url', 255)->nullable();
            $table->string('audio_url', 255)->nullable();
            $table->string('brand', 255)->nullable();
            $table->float('price')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('total_sold')->nullable();
            $table->float('score')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
