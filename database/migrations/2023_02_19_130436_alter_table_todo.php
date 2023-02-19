<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('todos')) {
            Schema::table('todos', function (Blueprint $table) {
                $table->unsignedBigInteger('td_user_id')->unsigned()->nullable(false)->after('td_id');
                $table->foreign('td_user_id')->references('id')->on('users');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('todos')) {
            Schema::table('todos', function (Blueprint $table) {
                $table->dropForeign('todos_td_user_id_foreign');
                $table->dropColumn('td_user_id');
            });
        }
    }
};
