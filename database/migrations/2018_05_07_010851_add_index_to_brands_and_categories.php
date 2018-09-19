<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexToBrandsAndCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories',function(Blueprint $table){
            $table->tinyInteger('order')->unique()->nullable();
        });
        Schema::table('brands',function(Blueprint $table){
            $table->tinyInteger('order')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories',function(Blueprint $table){
            $table->dropColumn('order');
        });
        Schema::table('brands',function(Blueprint $table){
            $table->dropColumn('order');
        });
    }
}
