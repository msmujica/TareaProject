<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TriggerTienes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER log_insert_tienes AFTER INSERT ON tienes
            FOR EACH ROW
            BEGIN
                INSERT INTO log(evento,tabla) VALUES ('Insercion','tienes');
            END"
            );
    
            DB::unprepared("
            CREATE TRIGGER log_update_tienes AFTER UPDATE ON tienes
            FOR EACH ROW
            BEGIN
                INSERT INTO log(evento,tabla) VALUES ('Modificacion','tienes');
            END"
            );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
