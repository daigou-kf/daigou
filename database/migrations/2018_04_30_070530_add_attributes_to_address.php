<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttributesToAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addresses',function(Blueprint $table){
            $table->string('phone','20');
            $table->string('province','40');
            $table->string('city','40');
            $table->string('suburb','40');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses',function(Blueprint $table){
            $table->dropColumn('phone');
            $table->dropColumn('province');
            $table->dropColumn('city');
            $table->dropColumn('suburb');
        });
    }
}
