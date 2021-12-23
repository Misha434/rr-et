<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdToScriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scripts', function (Blueprint $table) {
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')
            ->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scripts', function (Blueprint $table) {
            $table->dropForeign('scripts_category_id_foreign');
        });
    }
}
