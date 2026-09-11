<h1>Réservation #<?= (int) $reservation->id ?></h1>

<p>Responsable : <?= htmlspecialchars($reservation->responsable) ?></p>
<p>Email : <?= htmlspecialchars($reservation->email) ?></p>
<p>Motif : <?= htmlspecialchars($reservation->motif) ?></p>
<p>Début : <?= htmlspecialchars($reservation->date_debut->format('d/m/Y H:i')) ?></p>
<p>Fin : <?= htmlspecialchars($reservation->date_fin->format('d/m/Y H:i')) ?></p>
<p>Statut : <?= htmlspecialchars($reservation->statut) ?></p>

<a href="/reservations">Retour à la liste</a>