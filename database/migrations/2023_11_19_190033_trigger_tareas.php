<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TriggerTareas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        CREATE TRIGGER log_insert_tareas AFTER INSERT ON tareas
        FOR EACH ROW
        BEGIN
            INSERT INTO log(evento,tabla) VALUES ('Insercion','tareas');
        END"
        );

        DB::unprepared("
        CREATE TRIGGER log_update_tareas AFTER UPDATE ON tareas
        FOR EACH ROW
        BEGIN
            INSERT INTO log(evento,tabla) VALUES ('Modificacion','grupos');
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
