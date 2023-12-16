<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->text('image')->nullable();
            $table->enum('role',['admin','supervisor','student'])->default('student');
            $table->string('country');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('permissions')->nullable();
            $table->text('savedQuestions'); // questions saved by user
            $table->text('courses'); // courses would like to see its questions
            $table->unsignedBigInteger('major_id');
            $table->unsignedBigInteger('university_id');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('major_id')
            ->references('id')
            ->on('majors')
            ->onDelete('cascade');

            
            $table->foreign('university_id')
            ->references('id')
            ->on('universities')
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
        Schema::dropIfExists('users');
    }
}
