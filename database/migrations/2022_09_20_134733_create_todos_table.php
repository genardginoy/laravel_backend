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
        if(!Schema::hasTable('todos')) {
            Schema::create('todos', function (Blueprint $table) {
                $table->increments('td_id');
                $table->string('td_title');
                $table->text('td_description');
                $table->string('td_status', 1);
                $table->timestamp('td_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('td_updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('todos');
    }
};
