<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('server_plugin');
            $table->string('hostname')->nullable();
            $table->string('ip')->nullable();
            $table->integer('port')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->text('access_key')->nullable();
            $table->integer('max_load');
            $table->boolean('enable')->default(true);
            $table->string('api_access_address')->comment('填入是hostname还是ip就行了');
            $table->boolean('api_access_ssl')->default(false);
            $table->boolean('access_ssl')->default(false);
            $table->string('status_address')->nullable();
            $table->json('extra')->nullable();
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
        Schema::dropIfExists('servers');
    }
}
