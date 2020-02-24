<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoDescriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_description', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('diploma')->nullable();
            $table->string('monthes')->nullable();
            $table->text('description')->nullable();
            $table->text('test')->nullable();
            $table->text('prereq')->nullable();
            $table->text('prospect')->nullable();
            $table->text('funding')->nullable();
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
        Schema::dropIfExists('auto_description');
    }
}
