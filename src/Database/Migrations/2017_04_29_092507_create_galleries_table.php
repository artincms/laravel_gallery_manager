<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lgs_galleries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->string('description', 1000)->nullable()->default(null);
            $table->integer('default_img')->unsigned()->nullable()->default(null);
            $table->text('default_img_options')->nullable()->default(null);
            $table->integer('parent_id')->unsigned()->default(0);
            $table->integer('order')->default(0);
            $table->enum('is_active', array('0','1'))->default('0');
            $table->integer('visit')->unsigned()->default(0);
            $table->integer('like')->unsigned()->default(0);
            $table->integer('dis_like')->unsigned()->default(0);
            $table->integer('created_by')->unsigned()->default(0);
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
        Schema::dropIfExists('galleries');
    }
}
