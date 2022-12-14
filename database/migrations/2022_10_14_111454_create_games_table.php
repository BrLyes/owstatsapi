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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->integer("kill")->nullable(false)->default(0);
            $table->integer("death")->nullable(false)->default(0);
            $table->integer("assist")->nullable(false)->default(0);
            $table->integer("damage")->nullable(false)->default(0);
            $table->integer("heal")->nullable(false)->default(0);
            $table->integer("mitigate")->nullable(false)->default(0);
            $table->float("accuracy")->nullable(true)->default(null);
            $table->foreignId("character_id")->constrained()->cascadeOnUpdate();
            $table->foreignId("user_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamp('match_date')->nullable(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->softDeletes();
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
