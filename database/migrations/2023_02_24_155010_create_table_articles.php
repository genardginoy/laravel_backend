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
        if(!Schema::hasTable('articles')) {
            Schema::create('articles', function (Blueprint $table) {
                $table->increments('ar_id');
                $table->unsignedBigInteger('ar_user_id')->unsigned()->nullable(false);
                $table->string('ar_title');
                $table->text('ar_description');
                $table->timestamp('ar_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('ar_updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
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
        DB::connection('sqlite')->unprepared('DROP TRIGGER IF EXISTS articles_updated_at_trigger');
        Schema::dropIfExists('articles');
    }
};
