<?php

use App\Model\Salle;

$salles = [
    ['nom' => 'Amphithéâtre A', 'batiment' => 'Bâtiment A', 'capacite' => 250, 'type' => 'amphitheatre', 'active' => true],
    ['nom' => 'Salle B12', 'batiment' => 'Bâtiment B', 'capacite' => 40, 'type' => 'cours', 'active' => true],
    ['nom' => 'Laboratoire Chimie', 'batiment' => 'Bâtiment C', 'capacite' => 24, 'type' => 'laboratoire', 'active' => true],
    ['nom' => 'Salle Informatique 1', 'batiment' => 'Bâtiment B', 'capacite' => 30, 'type' => 'informatique', 'active' => true],
    ['nom' => 'Salle de réunion', 'batiment' => 'Bâtiment A', 'capacite' => 12, 'type' => 'reunion', 'active' => true],
];
$creation = 0;
$existantes = 0;
foreach ($salles as $donnees) {
    $salle = Salle::firstOrCreate(['nom' => $donnees['nom']], $donnees);
    if ($salle->wasRecentlyCreated) $creation++;
    else $existantes++;
}
echo "Seed terminé : $creation créée(s), $existantes déjà existante(s).\n";