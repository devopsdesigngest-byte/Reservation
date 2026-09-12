<section class="box">
    <h1>Réservation #<?= (int) $reservation->id ?></h1>
    <p>Responsable : <?= htmlspecialchars($reservation->responsable) ?></p>
    <p>Email : <?= htmlspecialchars($reservation->email) ?></p>
    <p>Salle : <?= htmlspecialchars($reservation->salle->nom ?? '—') ?></p>
    <p>Motif : <?= htmlspecialchars($reservation->motif) ?></p>
    <p>Début : <?= htmlspecialchars($reservation->date_debut->format('d/m/Y H:i')) ?></p>
    <p>Fin : <?= htmlspecialchars($reservation->date_fin->format('d/m/Y H:i')) ?></p>
    <p>Statut : <?= htmlspecialchars($reservation->statut) ?></p>
    <p>
        <?php if ($reservation->statut === 'confirmée'): ?>
            <form method="POST" action="/reservations/<?= (int) $reservation->id ?>/cancel" class="inline">
                <button type="submit">Annuler</button>
            </form>
        <?php endif; ?>
        <a href="/reservations">Retour</a>
    </p>
</section>
