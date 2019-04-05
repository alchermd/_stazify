<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificationRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verification_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id');
            $table->text('message');
            $table->string('attachment');
            $table->timestamps();

            $table->foreign('company_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verification_requests');
    }
}
