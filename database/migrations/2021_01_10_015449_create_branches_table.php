<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('address')->nullable();
            $table->string('company_reg')->nullable();
            $table->text('description')->nullable();
            $table->string('keywords')->nullable();
            $table->enum('status',['active','in_active'])->nullable()->default('in_active');
            $table->enum('is_main',['yes','no'])->nullable()->default('no');
            $table->enum('visibility',['visible','invisible'])->nullable()->default('invisible');
            $table->enum('availability',['available','not_available'])->nullable()->default('not_available');
            $table->enum('is_deleted',['yes','no'])->nullable()->default('no');
            $table->timestamp('deleted_at')->nullable();
            $table->bigInteger('created_by')->unsigned()->index()->nullable();
            $table->bigInteger('last_updated_by')->unsigned()->index()->nullable();
            $table->bigInteger('last_deleted_by')->unsigned()->index()->nullable();
            // $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreign('last_updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreign('last_deleted_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('branches');
    }
}
