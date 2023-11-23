<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TriggerGrupos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        CREATE TRIGGER log_insert_grupos AFTER INSERT ON grupos
        FOR EACH ROW
        BEGIN
            INSERT INTO log(evento,tabla) VALUES ('Insercion','grupos');
        END"
        );

        DB::unprepared("
        CREATE TRIGGER log_update_grupos AFTER UPDATE ON grupos
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
