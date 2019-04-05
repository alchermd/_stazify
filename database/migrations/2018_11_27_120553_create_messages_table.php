<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sender_id');
            $table->unsignedInteger('recipient_id');
            $table->string('subject');
            $table->text('body');
            $table->timestamp('read_at')->nullable();
            $table->timestamp('removed_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('sender_id')
                ->references('id')
                ->on('users');
            $table->foreign('recipient_id')
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
        Schema::dropIfExists('messages');
    }
}
