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
        // Illuminate\Support\Facades\DB::setDefaultConnection('sqlite');

        if(!Schema::connection('sqlite')->hasTable('todos')) {
            Schema::connection('sqlite')->create('todos', function (Blueprint $table) {
                $table->increments('td_id');
                $table->unsignedBigInteger('td_user_id')->unsigned()->nullable(false);
                $table->string('td_title');
                $table->text('td_description');
                $table->string('td_status', 1);
                $table->timestamp('td_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('td_updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            });

            DB::connection('sqlite')->unprepared('
                CREATE TRIGGER todos_updated_at_trigger
                AFTER UPDATE ON todos
                FOR EACH ROW
                BEGIN
                    UPDATE todos SET td_updated_at = CURRENT_TIMESTAMP WHERE td_id = OLD.td_id;
                END
            ');

        }

        // Illuminate\Support\Facades\DB::setDefaultConnection('mysql');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        // Illuminate\Support\Facades\DB::setDefaultConnection('sqlite');
        DB::connection('sqlite')->unprepared('DROP TRIGGER IF EXISTS todos_updated_at_trigger');
        Schema::connection('sqlite')->dropIfExists('todos');
        // Illuminate\Support\Facades\DB::setDefaultConnection('mysql');
        Schema::enableForeignKeyConstraints();
    }
};
