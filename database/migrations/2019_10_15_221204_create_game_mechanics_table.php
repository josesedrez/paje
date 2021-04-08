<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameMechanicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_mechanics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('evaluation_id')->unsigned();
            $table->float('objective_grade');
            $table->float('challenge_grade');
            $table->float('rule_grade');
            $table->float('control_grade');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('evaluation_id')->references('id')->on('evaluations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_mechanics');
    }
}
