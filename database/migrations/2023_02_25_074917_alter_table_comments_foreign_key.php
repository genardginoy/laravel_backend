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
        if(Schema::hasTable('comments')) {
            Schema::table('comments', function (Blueprint $table) {
                $table->dropForeign('comments_cm_td_id_foreign');
                $table->dropColumn('cm_td_id');
                $table->integer('cm_ar_id')->unsigned()->nullable(false)->after('cm_id');
                $table->foreign('cm_ar_id')->references('ar_id')->on('articles');
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
        if(Schema::hasTable('comments')) {
            if (!Schema::hasColumn('comments', 'cm_td_id')) {
                Schema::table('comments', function (Blueprint $table) {
                    $table->integer('cm_td_id')->unsigned()->nullable(false)->after('cm_id');
                    $table->foreign('cm_td_id')->references('td_id')->on('todos');

                    $table->dropForeign('articles_cm_ar_id_foreign');
                    $table->dropColumn('cm_ar_id');

                });
            }
        }
    }
};
