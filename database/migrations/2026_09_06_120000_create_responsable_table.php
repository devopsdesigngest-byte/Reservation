<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class CreateResponsableTable
{
    public function up(): void
    {
        if (Capsule::schema()->hasTable('responsable')) {
            echo "Table 'responsable' existe déjà.\n";
            return;
        }
        Capsule::schema()->create('responsable', function ($table) {
            $table->increments('id');
            $table->string('nom');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('responsable');
    }
}
