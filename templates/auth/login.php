<section class="box">
    <h1>Connexion</h1>

    <p class="info"><?= htmlspecialchars('NB: Mode test : toute combinaison passe' ?? $info) ?></p>

    <?php foreach ($errors['general'] ?? [] as $msg): ?>
        <p class="error"><?= htmlspecialchars($msg) ?></p>
    <?php endforeach; ?>

    <form method="POST" action="/login">
        <label>
            Email
            <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
        </label>
        <label>
            Mot de passe
            <input type="password" name="password" required>
        </label>
        <button type="submit">Se connecter</button>
    </form>
</section>
