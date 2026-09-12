<section class="box">
    <h1>405 — Méthode non autorisée</h1>
    <p>Autorisées : <?= htmlspecialchars(implode(', ', $allowed ?? [])) ?></p>
    <p><a href="/salles">Retour</a></p>
</section>
