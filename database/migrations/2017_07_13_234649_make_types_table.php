<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        // item type pivot table
        Schema::create('item_type', function (Blueprint $table) {
            $table->integer('item_id');
            $table->integer('type_id');
            $table->timestamps();

            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('type_id')->references('id')->on('types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('types');
        Schema::dropIfExists('item_type');
    }
}
