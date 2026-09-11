<h1>Nouvelle réservation</h1>

<?php if (isset($errors['general'])): ?>
    <?php foreach ($errors['general'] as $msg): ?>
        <p class="error"><?= htmlspecialchars($msg) ?></p>
    <?php endforeach; ?>
<?php endif; ?>

<form method="POST" action="/reservations">
    <label>
        Salle
        <select name="salle_id">
            <?php foreach ($salles as $salle): ?>
                <option value="<?= (int) $salle->id ?>" <?= ($old['salle_id'] ?? '') == $salle->id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($salle->nom) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php foreach ($errors['salle_id'] ?? [] as $msg): ?>
            <span class="field-error"><?= htmlspecialchars($msg) ?></span>
        <?php endforeach; ?>
    </label>

    <label>
        Responsable
        <input type="text" name="responsable" value="<?= htmlspecialchars($old['responsable'] ?? '') ?>">
        <?php foreach ($errors['responsable'] ?? [] as $msg): ?>
            <span class="field-error"><?= htmlspecialchars($msg) ?></span>
        <?php endforeach; ?>
    </label>

    <label>
        Email
        <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
        <?php foreach ($errors['email'] ?? [] as $msg): ?>
            <span class="field-error"><?= htmlspecialchars($msg) ?></span>
        <?php endforeach; ?>
    </label>

    <label>
        Motif
        <textarea name="motif"><?= htmlspecialchars($old['motif'] ?? '') ?></textarea>
        <?php foreach ($errors['motif'] ?? [] as $msg): ?>
            <span class="field-error"><?= htmlspecialchars($msg) ?></span>
        <?php endforeach; ?>
    </label>

    <label>
        Date de début
        <input type="datetime-local" name="date_debut" value="<?= htmlspecialchars($old['date_debut'] ?? '') ?>">
        <?php foreach ($errors['date_debut'] ?? [] as $msg): ?>
            <span class="field-error"><?= htmlspecialchars($msg) ?></span>
        <?php endforeach; ?>
    </label>

    <label>
        Date de fin
        <input type="datetime-local" name="date_fin" value="<?= htmlspecialchars($old['date_fin'] ?? '') ?>">
        <?php foreach ($errors['date_fin'] ?? [] as $msg): ?>
            <span class="field-error"><?= htmlspecialchars($msg) ?></span>
        <?php endforeach; ?>
    </label>

    <button type="submit">Réserver</button>
</form>