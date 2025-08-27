<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('short_description');
            $table->text('full_description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('image_url');
            $table->string('technology');
            $table->string('price');
            $table->integer('downloads')->default(0);
            $table->integer('purchases')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};