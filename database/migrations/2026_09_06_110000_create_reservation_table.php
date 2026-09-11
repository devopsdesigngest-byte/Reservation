<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class CreateReservationTable
{
    public function up(): void
    {
        if (Capsule::schema()->hasTable('reservation')) {
            echo "Table 'reservation' existe déjà.\n";
            return;
        }
        Capsule::schema()->create('reservation', function ($table) {
            $table->increments('id');
            $table->unsignedInteger('salle_id');
            $table->string('responsable');
            $table->string('email');
            $table->string('motif');
            $table->dateTime('date_debut');
            $table->dateTime('date_fin');
            $table->enum('statut', ['confirmée', 'annulée']);
            $table->timestamps();
            $table->foreign('salle_id')->references('id')->on('salle');
        });
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('reservation');
    }
}