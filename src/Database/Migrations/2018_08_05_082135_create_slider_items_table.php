<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSliderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slider_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('slider_id')->unsigned()->default(0);
            $table->integer('item_id')->unsigned()->default(0);
            $table->enum('is_active', array('1','2'))->default('1')->comment('0 equal to deactive and 1 is active');
            $table->integer('created_by')->unsigned()->default(0);
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
        Schema::dropIfExists('slider_items');
    }
}
