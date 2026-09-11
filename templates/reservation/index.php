<h1>Liste des réservations</h1>
<a href="/reservations/create">Nouvelle réservation</a>

<table>
    <thead>
        <tr>
            <th>Responsable</th>
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
            <td><?= htmlspecialchars($reservation->motif) ?></td>
            <td><?= htmlspecialchars($reservation->date_debut->format('d/m/Y H:i')) ?></td>
            <td><?= htmlspecialchars($reservation->date_fin->format('d/m/Y H:i')) ?></td>
            <td><?= htmlspecialchars($reservation->statut) ?></td>
            <td>
                <a href="/reservations/<?= (int) $reservation->id ?>">Voir</a>
                <?php if ($reservation->statut === 'confirmée'): ?>
                <form method="POST" action="/reservations/<?= (int) $reservation->id ?>/cancel" style="display:inline">
                    <button type="submit">Annuler</button>
                </form>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>