<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lgs_sliders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255)->nullable()->default(null);;
            $table->longText('description')->nullable()->default(null);
            $table->enum('style', array('1','2'))->nullable()->default('1')->comment('1 for vue_flux .');
            $table->text('style_options')->nullable()->default(null);
            $table->enum('is_active', array('1','2'))->nullable()->default('1')->comment('0 equal to deactive and 1 is active');
            $table->integer('created_by')->unsigned()->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lgs_sliders');
    }
}
