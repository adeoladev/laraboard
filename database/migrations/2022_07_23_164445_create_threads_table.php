<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->id();
            $table->string('thread_id');
            $table->string('name')->default('Anonymous');
            $table->string('title')->nullable();
            $table->string('message', 500);
            $table->integer('replies')->default(0);
            $table->integer('files')->default(0);
            $table->string('thumbnail')->nullable();
            $table->string('file')->nullable();
            $table->string('ip_address')->nullable();
            $table->boolean('archived')->nullable();
            $table->boolean('pinned')->nullable();
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
        Schema::dropIfExists('threads');
    }
}
