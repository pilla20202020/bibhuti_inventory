<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldRolesPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('roles', function (Blueprint $table) {
            $table->enum('is_deleted',['yes','no'])->nullable()->default('no');
            $table->timestamp('deleted_at')->nullable();
            $table->bigInteger('created_by')->unsigned()->index()->nullable();
            $table->bigInteger('last_updated_by')->unsigned()->index()->nullable();
            $table->bigInteger('last_deleted_by')->unsigned()->index()->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('last_updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('last_deleted_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->string('group_name')->nullable();
            $table->enum('is_deleted',['yes','no'])->nullable()->default('no');
            $table->timestamp('deleted_at')->nullable();
            $table->bigInteger('created_by')->unsigned()->index()->nullable();
            $table->bigInteger('last_updated_by')->unsigned()->index()->nullable();
            $table->bigInteger('last_deleted_by')->unsigned()->index()->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('last_updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('last_deleted_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->bigInteger('role_id')->unsigned()->index();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        //
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('is_deleted');
            $table->dropColumn('deleted_at');
            $table->dropColumn('created_by');
            $table->dropColumn('last_updated_by');
            $table->dropColumn('last_deleted_by');
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('is_deleted');
            $table->dropColumn('deleted_at');
            $table->dropColumn('created_by');
            $table->dropColumn('last_updated_by');
            $table->dropColumn('last_deleted_by');
        });

        Schema::dropIfExists('role_user');



    }
}
