<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUserAdminAndShoppingCartAndOrderItemFavourites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users',function(Blueprint $table){
            $table->tinyInteger('staff')->default(0);
        });

        Schema::table('shopping_carts',function(Blueprint $table){
           $table->unique(['product_id','user_id']);
        });

        Schema::table('order_products',function(Blueprint $table){
            $table->unique(['product_id','order_id']);
        });

        Schema::table('favourites',function(Blueprint $table){
            $table->unique(['product_id','user_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users',function(Blueprint $table){
            $table->dropColumn('staff');
        });

        Schema::table('shopping_carts',function(Blueprint $table){
            $table->dropUnique(['product_id','user_id']);
        });

        Schema::table('order_products',function(Blueprint $table){
            $table->dropUnique(['product_id','order_id']);
        });

        Schema::table('favourites',function(Blueprint $table){
            $table->dropUnique(['product_id','user_id']);
        });
    }
}
