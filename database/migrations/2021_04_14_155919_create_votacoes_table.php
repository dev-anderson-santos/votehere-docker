<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votacoes', function (Blueprint $table) {
            $table->id();
            $table->dateTime('data_inicio');
            $table->time('hora_inicio');
            $table->dateTime('data_fim');
            $table->time('hora_fim');
            $table->boolean('status')->nullable()->default(false);
            $table->boolean('avisar_encerramento')->nullable()->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votacoes');
    }
}
