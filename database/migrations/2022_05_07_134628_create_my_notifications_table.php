<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_notifications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('content');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('comment_id')->nullable()->default(null);
            $table->string('target')->nullable();
            $table->unsignedBigInteger('target_id')->nullable();
            $table->foreign('comment_id')
                  ->references('id')
                  ->on('comments')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');    
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');    
            $table->boolean('seen')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_notifications');
    }
}
