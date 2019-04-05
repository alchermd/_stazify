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
            // Common fields
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('account_type');
            $table->string('contact_number');
            $table->text('address');
            $table->text('about');
            $table->text('avatar_url');
            $table->rememberToken();
            $table->timestamps();

            // Student fields
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->unsignedInteger('age')->nullable();
            $table->text('resume_url')->nullable();
            $table->unsignedInteger('course_id')->nullable();
            $table->string('school')->nullable();

            // Company fields
            $table->string('company_name')->nullable();
            $table->string('website')->nullable();
            $table->unsignedInteger('industry_id')->nullable();
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
