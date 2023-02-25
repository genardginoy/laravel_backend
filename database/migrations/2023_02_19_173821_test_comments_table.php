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

        if(!Schema::connection('sqlite')->hasTable('comments')) {
            Schema::connection('sqlite')->create('comments', function (Blueprint $table) {
                $table->increments('cm_id');
                $table->integer('cm_ar_id')->unsigned()->nullable(false);
                $table->string('cm_title');
                $table->text('cm_description');
                $table->timestamp('cm_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('cm_updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            });

            DB::connection('sqlite')->unprepared('
                CREATE TRIGGER comments_updated_at_trigger
                AFTER UPDATE ON comments
                FOR EACH ROW
                BEGIN
                    UPDATE comments SET cm_updated_at = CURRENT_TIMESTAMP WHERE cm_id = OLD.cm_id;
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
        DB::connection('sqlite')->unprepared('DROP TRIGGER IF EXISTS  comments_updated_at_trigger');
        Schema::connection('sqlite')->dropIfExists('comments');
        // Illuminate\Support\Facades\DB::setDefaultConnection('mysql');
        Schema::enableForeignKeyConstraints();
    }
};
