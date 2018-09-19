<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBasicAttributesToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products',function(Blueprint $table){
           $table->string('name','40');
           $table->string('description','100')->nullable();
           $table->float('price');
           $table->string('img_url','100');
           $table->integer('sale')->default(0);
           $table->unsignedInteger('category_id');

           $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products',function(Blueprint $table){
           $table->dropColumn('name');
           $table->dropColumn('description');
           $table->dropColumn('price');
           $table->dropColumn('img_url');
           $table->dropColumn('sale');
           $table->dropColumn('category_id');
        });
    }
}
