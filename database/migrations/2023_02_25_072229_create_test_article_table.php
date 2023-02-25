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
        if(!Schema::connection('sqlite')->hasTable('articles')) {
            Schema::connection('sqlite')->create('articles', function (Blueprint $table) {
                $table->increments('ar_id');
                $table->integer('ar_user_id')->unsigned();
                $table->string('ar_title');
                $table->text('ar_description');
                $table->timestamp('ar_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('ar_updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

                DB::connection('sqlite')->unprepared('
                    CREATE TRIGGER articles_updated_at_trigger
                    AFTER UPDATE ON articles
                    FOR EACH ROW
                    BEGIN
                        UPDATE articles SET updated_at = CURRENT_TIMESTAMP WHERE ar_id = OLD.ar_id;
                    END
                ');

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
        Schema::connection('sqlite')->dropIfExists('articles');
    }
};
