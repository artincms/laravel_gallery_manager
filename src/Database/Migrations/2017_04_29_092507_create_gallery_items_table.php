<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lgs_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gallery_id')->unsigned();
            $table->integer('file_id')->unsigned()->nullable()->default(null);
            $table->string('title', 255)->nullable()->default(null);
            $table->string('description', 1000)->nullable()->default(null);
            $table->integer('visit')->unsigned()->default(0);
            $table->enum('is_active',['0','1'])->default('0');
            $table->enum('type', ['0','1','2'])->default('0')->comment('0 is picture 1 is Audio and 2 is video');
            $table->text('options')->nullable()->default(null);
            $table->integer('order')->default(0);
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
        Schema::dropIfExists('gallery_items');
    }
}
