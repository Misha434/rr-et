<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikeScriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('like_scripts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('script_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();

            $table->foreign('script_id')
            ->references('id')
            ->on('scripts')
            ->onDelete('cascade');
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

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
        Schema::dropIfExists('like_scripts');
    }
}
