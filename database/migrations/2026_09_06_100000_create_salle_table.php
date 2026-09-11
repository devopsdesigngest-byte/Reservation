<?php

use Illuminate\Database\Capsule\Manager as Capsule;
class CreateSalleTable
{
    public function up(): void
    {
        if (Capsule::schema()->hasTable('salle')) {
            echo "Table 'salle' existe déjà.\n";
            return;
        }
        Capsule::schema()->create('salle', function ($table) {
            $table->increments('id');
            $table->string('nom');
            $table->string('batiment');
            $table->integer('capacite');
            $table->enum('type', ['cours', 'informatique', 'laboratoire', 'amphitheatre', 'reunion']);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
        echo "Table 'salle' créée.\n";
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('salle');
        echo "Table 'salle' supprimée.\n";
    }
}