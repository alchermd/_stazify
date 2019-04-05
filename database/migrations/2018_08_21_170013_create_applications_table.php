<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id'); // The applicant.
            $table->unsignedInteger('jobpost_id');
            $table->boolean('accepted')->nullable();
            $table->boolean('is_cancelled')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'jobpost_id']);
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->foreign('jobpost_id')
                ->references('id')
                ->on('jobposts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
