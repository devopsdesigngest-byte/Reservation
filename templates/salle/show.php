<section class="box">
    <h1><?= htmlspecialchars($salle->nom) ?></h1>
    <p>Bâtiment : <?= htmlspecialchars($salle->batiment) ?></p>
    <p>Capacité : <?= htmlspecialchars((string) $salle->capacite) ?></p>
    <p>Type : <?= htmlspecialchars($salle->type) ?></p>
    <p>Active : <?= $salle->active ? 'Oui' : 'Non' ?></p>
    <p>
        <a href="/salles/<?= (int) $salle->id ?>/edit">Modifier</a>
        —
        <a href="/salles">Retour</a>
    </p>
</section>
