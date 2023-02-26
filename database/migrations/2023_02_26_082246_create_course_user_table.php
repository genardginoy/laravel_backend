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
        if(!Schema::hasTable('course_user')) {
            Schema::create('course_user', function (Blueprint $table) {
                $table->id();
                $table->integer('course_id')->unsigned();
                $table->unsignedBigInteger('user_id')->unsigned();
                $table->timestamp('cr_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('cr_updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

                $table->foreign('course_id')->references('cr_id')->on('courses');
                $table->foreign('user_id')->references('id')->on('users');
            });
        }

        if(!Schema::connection('sqlite')->hasTable('course_user')) {
            Schema::connection('sqlite')->create('course_user', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('course_id')->unsigned();
                $table->unsignedBigInteger('user_id')->unsigned();
                $table->timestamp('cr_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('cr_updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            });

            DB::connection('sqlite')->unprepared('
                CREATE TRIGGER course_user_updated_at_trigger
                AFTER UPDATE ON course_user
                FOR EACH ROW
                BEGIN
                    UPDATE course_user SET updated_at = CURRENT_TIMESTAMP WHERE id = OLD.id;
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
        Schema::dropIfExists('course_user');
        DB::connection('sqlite')->unprepared('DROP TRIGGER IF EXISTS  course_user_updated_at_trigger');
        Schema::connection('sqlite')->dropIfExists('courses');
    }
};
