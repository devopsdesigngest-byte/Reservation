<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réservation de salles</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="/salles">Salles</a>
            <a href="/reservations">Réservations</a>
            <?php if (!empty($authUser)): ?>
                <span><?= htmlspecialchars($authUser['nom']) ?></span>
                <form method="POST" action="/logout" class="inline">
                    <button type="submit">Déconnexion</button>
                </form>
            <?php else: ?>
                <a href="/login">Connexion</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
        <?= $content ?>
    </main>
</body>
</html>
