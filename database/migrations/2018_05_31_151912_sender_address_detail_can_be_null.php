<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SenderAddressDetailCanBeNull extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sender_addresses',function(Blueprint $table){
            $table->string('detail','200')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sender_addresses',function(Blueprint $table){
            $table->string('detail','200')->change();
        });
    }
}
