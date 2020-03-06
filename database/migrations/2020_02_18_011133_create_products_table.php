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
            $table->boolean('require_domain');
            $table->boolean('ena_stock');
            $table->integer('stocks')->nullable();
            $table->boolean('hide');
            $table->boolean('enable');
            $table->json('price')->nullable()->comment('价格表');
            $table->json('price_configs')->nullable()->comment('价格配置');
            $table->json('server_configs')->nullable()->comment('服务器插件配置');
            $table->integer('order')->default(0);
            $table->string('server_plugin')->nullable();
            $table->integer('server_group_id')->nullable();
            $table->json('upgrade_downgrade_config')->nullable()->comment('升降级配置');
            $table->json('domain_configs')->nullable()->comment('域名配置');
            $table->json('extra')->nullable()->comment('其他设置');
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
