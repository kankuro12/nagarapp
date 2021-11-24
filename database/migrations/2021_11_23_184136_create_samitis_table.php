<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSamitisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('samitis', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->boolean('show')->default(true);
            $table->integer('order')->default(0);
            $table->string('nagarcode',10)->default('44:2');
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
        Schema::dropIfExists('samitis');
    }
}
