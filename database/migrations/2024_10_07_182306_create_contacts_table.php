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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();

            $table->date('date_email')->nullable();
            $table->string('email_destinataire')->nullable();
            $table->string('objet_destinataire')->nullable();
            $table->text('message')->nullable();
            $table->bigInteger('espace_id')->nullable();
            $table->bigInteger('compte_id')->nullable();
            $table->bigInteger('annee_id')->nullable();
            $table->bigInteger('inscription_id')->nullable();
            $table->bigInteger('utilisateur_id')->nullable();
           

            $table->integer('etat')->default(1);
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
        Schema::dropIfExists('contacts');
    }
};
