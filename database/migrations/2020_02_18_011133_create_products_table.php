<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_group_id');
            $table->string('name');
            $table->string('type')
                ->comment('hosting: 虚机,reseller: 分销,vps: VPS,server:独服,others:其他');
            $table->longText('description')->nullable();
            $table->boolean('hide');
            $table->boolean('enable');
            $table->json('price')->nullable()->comment('价格表');
            $table->json('config')->nullable();
            $table->integer('order')->default(0);
            $table->string('server_plugin')->nullable();
            $table->integer('server_id')->default(0);
            $table->longText('free_domain')->nullable();
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
        Schema::dropIfExists('products');
    }
}
