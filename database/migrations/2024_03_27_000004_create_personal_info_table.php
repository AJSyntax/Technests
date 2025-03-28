<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('personal_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('bio');
            $table->json('contact_info');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('personal_info');
    }
}; 