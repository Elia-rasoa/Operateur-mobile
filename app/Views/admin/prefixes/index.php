<!-- Configuration opérateur courant -->
<div class="card">
    <h3>🏢 Mon opérateur (opérateur courant)</h3>
    <form action="/admin/prefixes/operateur-courant" method="post">
        <div class="form-row">
            <div class="form-group">
                <label for="nom_operateur">Nom de l'opérateur</label>
                <input type="text" name="nom_operateur" id="nom_operateur"
                       value="<?= esc($operateur_courant['nom_operateur'] ?? '') ?>"
                       placeholder="Ex: MonOpérateur" required>
            </div>
            <div class="form-group">
                <label for="prefixe">Préfixe</label>
                <input type="text" name="prefixe" id="prefixe"
                       value="<?= esc($operateur_courant['prefixe'] ?? '') ?>"
                       placeholder="Ex: 034" maxlength="5" required>
            </div>
            <button type="submit" class="btn btn-success">💾 Enregistrer</button>
        </div>
    </form>
</div>

<!-- Ajout préfixe autre opérateur -->
<div class="card">
    <h3>➕ Ajouter un autre opérateur (préfixe tiers)</h3>
    <form action="/admin/prefixes/add" method="post">
        <div class="form-row">
            <div class="form-group">
                <label for="code">Code préfixe</label>
                <input type="text" name="code" id="code" placeholder="Ex: 032" maxlength="5" required>
            </div>
            <div class="form-group">
                <label for="operateur_nom">Nom de l'opérateur</label>
                <input type="text" name="operateur_nom" id="operateur_nom" placeholder="Ex: Opérateur B">
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </div>
    </form>
</div>

<div class="info-box">
    <strong>💡 Comment ça marche ?</strong><br>
    Les préfixes listés ci-dessous sont ceux des <strong>autres opérateurs</strong>. Si un client envoie de l'argent vers un numéro dont le préfixe est dans cette liste, la transaction sera marquée comme <strong>"externe"</strong> (interconnexion). Sinon, elle sera <strong>"interne"</strong> (même réseau).
</div>

<div class="table-wrapper">
    <table>
        <thead>
            <tr><th>ID</th><th>Préfixe</th><th>Opérateur</th><th>Action</th></tr>
        </thead>
        <tbody>
            <?php if (empty($prefixes)): ?>
                <tr><td colspan="4" class="empty"><div class="empty"><div class="empty-icon">📞</div><p>Aucun opérateur tiers configuré.</p></div></td></tr>
            <?php else: ?>
                <?php foreach ($prefixes as $p): ?>
                <tr>
                    <td><?= esc($p['id']) ?></td>
                    <td><span class="badge badge-positif" style="background:#e8ecf8; color:#4361ee; font-weight:700; font-size:16px;"><?= esc($p['code']) ?></span></td>
                    <td>
                        <?php if (!empty($p['operateur_nom'])): ?>
                            <span class="badge badge-depot"><?= esc($p['operateur_nom']) ?></span>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <form action="/admin/prefixes/delete/<?= $p['id'] ?>" method="post" onsubmit="return confirm('Supprimer le préfixe <?= esc($p['code']) ?> ?');">
                            <button type="submit" class="btn btn-danger btn-sm">🗑 Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
