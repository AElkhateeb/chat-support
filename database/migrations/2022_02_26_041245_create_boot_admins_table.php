<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBootAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boot_admins', function (Blueprint $table) {
             $table->increments('id');
             $table->string('pattern');
             $table->Integer('previous');
             $table->boolean('checked');
            $table->foreign('previous')->references('id')->on('boot_admins')->onDelete('cascade');
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
        Schema::dropIfExists('boot_admins');
    }
}
