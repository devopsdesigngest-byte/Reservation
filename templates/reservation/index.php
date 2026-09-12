<div class="toolbar">
    <h1>Réservations</h1>
    <a href="/reservations/create">Nouvelle réservation</a>
</div>

<form method="GET" action="/reservations" class="filters">
    <label>
        Responsable
        <input type="text" name="responsable" value="<?= htmlspecialchars($filters['responsable'] ?? '') ?>">
    </label>
    <label>
        Email
        <input type="text" name="email" value="<?= htmlspecialchars($filters['email'] ?? '') ?>">
    </label>
    <label>
        Statut
        <select name="statut">
            <option value="">Tous</option>
            <option value="confirmée" <?= ($filters['statut'] ?? '') === 'confirmée' ? 'selected' : '' ?>>Confirmée</option>
            <option value="annulée" <?= ($filters['statut'] ?? '') === 'annulée' ? 'selected' : '' ?>>Annulée</option>
        </select>
    </label>
    <label>
        Salle
        <select name="salle_id">
            <option value="">Toutes</option>
            <?php foreach ($salles as $salle): ?>
                <option value="<?= (int) $salle->id ?>" <?= (string) ($filters['salle_id'] ?? '') === (string) $salle->id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($salle->nom) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>
    <button type="submit">Rechercher</button>
</form>

<table>
    <thead>
        <tr>
            <th>Responsable</th>
            <th>Salle</th>
            <th>Motif</th>
            <th>Début</th>
            <th>Fin</th>
            <th>Statut</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reservations as $reservation): ?>
        <tr>
            <td><?= htmlspecialchars($reservation->responsable) ?></td>
            <td><?= htmlspecialchars($reservation->salle->nom ?? '—') ?></td>
            <td><?= htmlspecialchars($reservation->motif) ?></td>
            <td><?= htmlspecialchars($reservation->date_debut->format('d/m/Y H:i')) ?></td>
            <td><?= htmlspecialchars($reservation->date_fin->format('d/m/Y H:i')) ?></td>
            <td><?= htmlspecialchars($reservation->statut) ?></td>
            <td class="actions">
                <a href="/reservations/<?= (int) $reservation->id ?>">Voir</a>
                <?php if ($reservation->statut === 'confirmée'): ?>
                <form method="POST" action="/reservations/<?= (int) $reservation->id ?>/cancel" class="inline">
                    <button type="submit">Annuler</button>
                </form>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php $reservations->appends($filters); ?>
<div class="pagination">
    <?php if ($reservations->total() === 0): ?>
        <small>0/0 — aucun résultat</small>
    <?php else: ?>
        <?php if ($reservations->previousPageUrl()): ?>
            <a href="<?= htmlspecialchars($reservations->previousPageUrl()) ?>">Précédent</a>
        <?php endif; ?>
        <span>Page <?= $reservations->currentPage() ?> / <?= $reservations->lastPage() ?></span>
        <?php if ($reservations->nextPageUrl()): ?>
            <a href="<?= htmlspecialchars($reservations->nextPageUrl()) ?>">Suivant</a>
        <?php endif; ?>
    <?php endif; ?>
</div>
