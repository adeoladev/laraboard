<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->id();
            $table->string('reply_id');
            $table->json('reply_to')->nullable();
            $table->json('reply_from')->nullable();
            $table->string('thread_id');
            $table->string('name')->default('Anonymous');
            $table->string('message', 500);
            $table->string('thumbnail')->nullable();
            $table->string('file')->nullable();
            $table->string('file_type')->nullable();
            $table->string('ip_address');
            $table->string('board');
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
        Schema::dropIfExists('replies');
    }
}
