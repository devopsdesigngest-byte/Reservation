<h1><?= $salle === null ? 'Créer une salle' : 'Modifier la salle' ?></h1>

<form method="POST" action="<?= $salle === null ? '/salles' : '/salles/' . (int) $salle->id . '/edit' ?>">
    <label>
        Nom
        <input type="text" name="nom" value="<?= htmlspecialchars($old['nom'] ?? ($salle->nom ?? '')) ?>">
        <?php foreach ($errors['nom'] ?? [] as $msg): ?>
            <span class="field-error"><?= htmlspecialchars($msg) ?></span>
        <?php endforeach; ?>
    </label>

    <label>
        Bâtiment
        <input type="text" name="batiment" value="<?= htmlspecialchars($old['batiment'] ?? ($salle->batiment ?? '')) ?>">
        <?php foreach ($errors['batiment'] ?? [] as $msg): ?>
            <span class="field-error"><?= htmlspecialchars($msg) ?></span>
        <?php endforeach; ?>
    </label>

    <label>
        Capacité
        <input type="number" name="capacite" value="<?= htmlspecialchars((string) ($old['capacite'] ?? ($salle->capacite ?? ''))) ?>">
        <?php foreach ($errors['capacite'] ?? [] as $msg): ?>
            <span class="field-error"><?= htmlspecialchars($msg) ?></span>
        <?php endforeach; ?>
    </label>

    <label>
        Type
        <select name="type">
            <?php foreach (['cours', 'informatique', 'laboratoire', 'amphitheatre', 'reunion'] as $type): ?>
                <option value="<?= $type ?>" <?= ($old['type'] ?? ($salle->type ?? '')) === $type ? 'selected' : '' ?>>
                    <?= htmlspecialchars($type) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php foreach ($errors['type'] ?? [] as $msg): ?>
            <span class="field-error"><?= htmlspecialchars($msg) ?></span>
        <?php endforeach; ?>
    </label>

    <label>
        <input type="checkbox" name="active" value="1" <?= ($old['active'] ?? $salle->active ?? true) ? 'checked' : '' ?>>
        Active
    </label>

    <button type="submit">Enregistrer</button>
</form>