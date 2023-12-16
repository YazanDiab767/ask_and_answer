<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMajorsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('majors_table', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('college_id');
            $table->timestamps();

            $table->foreign('college_id')
                ->references('id')
                ->on('colleges')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('majors_tables');
    }
}
