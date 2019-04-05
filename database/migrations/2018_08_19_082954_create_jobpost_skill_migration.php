<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobpostSkillMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobpost_skill', function (Blueprint $table) {
            $table->integer('jobpost_id');
            $table->integer('skill_id');

            $table->foreign('jobpost_id')
                ->references('id')
                ->on('jobposts');
            $table->foreign('skill_id')
                ->references('id')
                ->on('skills');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobpost_skill');
    }
}
