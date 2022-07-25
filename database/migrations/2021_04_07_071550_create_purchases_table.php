<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('available_stock')->nullable();
            $table->string('defective_stock')->nullable();
            $table->string('buying_price')->nullable();
            $table->timestamp('buying_date')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->enum('status',['active','in_active'])->nullable()->default('in_active');
            $table->enum('visibility',['visible','invisible'])->nullable()->default('invisible');
            $table->enum('availability',['available','not_available'])->nullable()->default('not_available');
            $table->enum('is_deleted',['yes','no'])->nullable()->default('no');
            $table->enum('is_default',['yes','no'])->nullable()->default('no');
            $table->timestamp('deleted_at')->nullable();
            $table->bigInteger('branch_id')->unsigned()->index()->nullable();
            $table->bigInteger('created_by')->unsigned()->index()->nullable();
            $table->bigInteger('last_updated_by')->unsigned()->index()->nullable();
            $table->bigInteger('last_deleted_by')->unsigned()->index()->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('last_updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('last_deleted_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('purchases');
    }
}
