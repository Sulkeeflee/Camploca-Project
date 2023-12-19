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
        Schema::create('campgrounds', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->text('summary');
            $table->longText('description')->nullable();
            $table->string('location')->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->text('photo');
            $table->enum('condition',['default','new','hot'])->default('default');
            $table->enum('status',['active','inactive'])->default('inactive');
            $table->boolean('is_featured')->default(false); // Fix the typo here
            $table->unsignedBigInteger('cat_id')->nullable();
            $table->unsignedBigInteger('child_cat_id')->nullable();
            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('SET NULL');
            $table->foreign('child_cat_id')->references('id')->on('categories')->onDelete('SET NULL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campgrounds');
    }
};



