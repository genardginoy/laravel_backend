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
        if(!Schema::hasTable('courses')) {
            Schema::create('courses', function (Blueprint $table) {
                $table->increments('cr_id');
                $table->string('cr_title');
                $table->text('cr_description');
                $table->timestamp('cr_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('cr_updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            });
        }

        if(!Schema::connection('sqlite')->hasTable('courses')) {
            Schema::connection('sqlite')->create('courses', function (Blueprint $table) {
                $table->increments('cr_id');
                $table->string('cr_title');
                $table->text('cr_description');
                $table->timestamp('cr_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('cr_updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            });

            DB::connection('sqlite')->unprepared('
                CREATE TRIGGER courses_updated_at_trigger
                AFTER UPDATE ON courses
                FOR EACH ROW
                BEGIN
                    UPDATE courses SET cr_updated_at = CURRENT_TIMESTAMP WHERE cr_id = OLD.cr_id;
                END
            ');

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
        DB::connection('sqlite')->unprepared('DROP TRIGGER IF EXISTS  courses_updated_at_trigger');
        Schema::connection('sqlite')->dropIfExists('courses');
    }
};
