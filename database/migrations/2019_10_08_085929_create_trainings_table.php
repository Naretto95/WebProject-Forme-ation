<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->string('name');
            $table->string('domain');
            $table->string('diploma');
            $table->float('cost', 5, 2);
            $table->date('date');
            $table->time('start');
            $table->time('end');
            $table->string('location');
            $table->float('Ncoord', 7,5);
            $table->float('Ecoord', 7,5);
            $table->string('region');
            $table->string('department');
            $table->text('description');
            $table->text('funding');
            $table->text('prospect');
            $table->enum('verificated', [0, 1])->default(0);
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainings');
    }
}
