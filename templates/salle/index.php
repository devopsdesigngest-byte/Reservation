<h1>Liste des salles</h1>

<a href="/salles/create">Ajouter une salle</a>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Bâtiment</th>
            <th>Capacité</th>
            <th>Type</th>
            <th>Active</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($salles as $salle): ?>
            <tr>
                <td><?= htmlspecialchars($salle->nom) ?></td>
                <td><?= htmlspecialchars($salle->batiment) ?></td>
                <td><?= htmlspecialchars((string) $salle->capacite) ?></td>
                <td><?= htmlspecialchars($salle->type) ?></td>
                <td><?= $salle->active ? 'Oui' : 'Non' ?></td>
                <td>
                    <a href="/salles/<?= (int) $salle->id ?>">Voir</a>
                    <a href="/salles/<?= (int) $salle->id ?>/edit">Modifier</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div>
    <a href="<?= $pagination['precedent'] ?? '#' ?>">
        Précédent
    </a>

    <span>
        Page <?= $pagination['page'] ?> / <?= $pagination['totalPages'] ?>
    </span>

    <a href="<?= $pagination['suivant'] ?? '#' ?>">
        Suivant
    </a>
</div>