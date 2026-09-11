<h1><?= htmlspecialchars($salle->nom) ?></h1>

<p>Bâtiment : <?= htmlspecialchars($salle->batiment) ?></p>
<p>Capacité : <?= htmlspecialchars((string) $salle->capacite) ?> places</p>
<p>Type : <?= htmlspecialchars($salle->type) ?></p>
<p>Statut : <?= $salle->active ? 'Active' : 'Inactive' ?></p>

<a href="/salles/<?= (int) $salle->id ?>/edit">Modifier</a>
<a href="/salles">Retour à la liste</a>