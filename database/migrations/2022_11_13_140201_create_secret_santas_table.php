<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Таблица подопечных.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secret_santas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()
            ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('secret_santas');
    }
};
