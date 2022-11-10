<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Task table DDL
 */
class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // task テーブル作成
        Schema::create('task', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('content', 100);
            $table->string('person_in_charge', 100);
            // NULL値可能なcreated_atとupdated_atカラム追加
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
        Schema::dropIfExists('task');
    }
}
