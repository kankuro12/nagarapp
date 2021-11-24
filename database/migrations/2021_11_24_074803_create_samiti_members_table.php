<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSamitiMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('samiti_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('samiti_id');
            $table->text('name');
            $table->text('phone')->nullable();
            $table->text('address')->nullable();
            $table->text('email')->nullable();
            $table->text('designation')->nullable();
            $table->text('desc')->nullable();
            $table->text('image')->nullable();
            $table->integer('order')->nullable();
            $table->integer('cols')->nullable();
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
        Schema::dropIfExists('samiti_members');
    }
}
