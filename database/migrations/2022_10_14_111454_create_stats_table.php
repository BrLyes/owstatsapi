<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->integer("kill")->nullable(false)->default(0);
            $table->integer("death")->nullable(false)->default(0);
            $table->integer("assist")->nullable(false)->default(0);
            $table->integer("damage")->nullable(false)->default(0);
            $table->float("accuracy")->nullable(false)->default(0.00);
            $table->foreignId("character_id")->constrained();
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
        Schema::dropIfExists('stats');
    }
};
