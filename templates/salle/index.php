<div class="toolbar">
    <h1>Salles</h1>
    <a href="/salles/create">Ajouter une salle</a>
</div>

<form method="GET" action="/salles" class="filters">
    <label>
        Nom
        <input type="text" name="nom" value="<?= htmlspecialchars($filters['nom'] ?? '') ?>">
    </label>
    <label>
        Bâtiment
        <input type="text" name="batiment" value="<?= htmlspecialchars($filters['batiment'] ?? '') ?>">
    </label>
    <label>
        Type
        <select name="type">
            <option value="">Tous</option>
            <?php foreach (['cours', 'informatique', 'laboratoire', 'amphitheatre', 'reunion'] as $type): ?>
                <option value="<?= $type ?>" <?= ($filters['type'] ?? '') === $type ? 'selected' : '' ?>><?= $type ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <label>
        Active
        <select name="active">
            <option value="">Tous</option>
            <option value="1" <?= ($filters['active'] ?? '') === '1' ? 'selected' : '' ?>>Oui</option>
            <option value="0" <?= ($filters['active'] ?? '') === '0' ? 'selected' : '' ?>>Non</option>
        </select>
    </label>
    <button type="submit">Rechercher</button>
</form>

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
                <td class="actions">
                    <a href="/salles/<?= (int) $salle->id ?>">Voir</a>
                    <a href="/salles/<?= (int) $salle->id ?>/edit">Modifier</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php $salles->appends($filters); ?>
<div class="pagination">
    <?php if ($salles->total() === 0): ?>
        <small>0/0 — aucun résultat</small>
    <?php else: ?>
        <?php if ($salles->previousPageUrl()): ?>
            <a href="<?= htmlspecialchars($salles->previousPageUrl()) ?>">Précédent</a>
        <?php endif; ?>
        <span>Page <?= $salles->currentPage() ?> / <?= $salles->lastPage() ?></span>
        <?php if ($salles->nextPageUrl()): ?>
            <a href="<?= htmlspecialchars($salles->nextPageUrl()) ?>">Suivant</a>
        <?php endif; ?>
    <?php endif; ?>
</div>
