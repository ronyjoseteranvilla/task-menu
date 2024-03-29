<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('field');
            $table->bigInteger('menu_id')->nullable()->unsigned();
            $table->bigInteger('parent_id')->nullable()->unsigned();
            $table->bigInteger('level')->nullable();

            $table->timestamps();

            $table->foreign('menu_id')->references('id')->on('menus');
            $table->foreign('parent_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
