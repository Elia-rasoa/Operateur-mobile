<!-- Configuration opérateur courant -->
<div class="card shadow-sm border-0 rounded-3 p-4 mb-4">
    <h3 class="h5 fw-bold mb-3">🏢 Mon opérateur (opérateur courant)</h3>
    <form action="/admin/prefixes/operateur-courant" method="post">
        <div class="row g-3 align-items-end">
            <div class="col-md-5">
                <div class="form-group mb-0">
                    <label for="nom_operateur" class="form-label small fw-semibold">Nom de l'opérateur</label>
                    <input type="text" name="nom_operateur" id="nom_operateur" class="form-control"
                           value="<?= esc($operateur_courant['nom_operateur'] ?? '') ?>"
                           placeholder="Ex: MonOpérateur" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-0">
                    <label for="prefixe" class="form-label small fw-semibold">Préfixe</label>
                    <input type="text" name="prefixe" id="prefixe" class="form-control"
                           value="<?= esc($operateur_courant['prefixe'] ?? '') ?>"
                           placeholder="Ex: 034" maxlength="5" required>
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-success w-100">💾 Enregistrer</button>
            </div>
        </div>
    </form>
</div>

<!-- Ajout préfixe autre opérateur -->
<div class="card shadow-sm border-0 rounded-3 p-4 mb-4">
    <h3 class="h5 fw-bold mb-3">➕ Ajouter un autre opérateur (préfixe tiers)</h3>
    <form action="/admin/prefixes/add" method="post">
        <div class="row g-3 align-items-end">
            <div class="col-md-5">
                <div class="form-group mb-0">
                    <label for="code" class="form-label small fw-semibold">Code préfixe</label>
                    <input type="text" name="code" id="code" class="form-control" placeholder="Ex: 032" maxlength="5" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-0">
                    <label for="operateur_nom" class="form-label small fw-semibold">Nom de l'opérateur</label>
                    <input type="text" name="operateur_nom" id="operateur_nom" class="form-control" placeholder="Ex: Opérateur B">
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Ajouter</button>
            </div>
        </div>
    </form>
</div>

<div class="info-box">
    <strong>💡 Comment ça marche ?</strong><br>
    Les préfixes listés ci-dessous sont ceux des <strong>autres opérateurs</strong>. Si un client envoie de l'argent vers un numéro dont le préfixe est dans cette liste, la transaction sera marquée comme <strong>"externe"</strong> (interconnexion). Sinon, elle sera <strong>"interne"</strong> (même réseau).
</div>

<div class="table-wrapper">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr><th>ID</th><th>Préfixe</th><th>Opérateur</th><th class="text-end">Action</th></tr>
        </thead>
        <tbody>
            <?php if (empty($prefixes)): ?>
                <tr><td colspan="4" class="text-center py-5 text-muted">📞 Aucun opérateur tiers configuré.</td></tr>
            <?php else: ?>
                <?php foreach ($prefixes as $p): ?>
                <tr>
                    <td><?= esc($p['id']) ?></td>
                    <td><span class="badge" style="background:#e8ecf8; color:#4361ee; font-weight:700; font-size:1rem;"><?= esc($p['code']) ?></span></td>
                    <td>
                        <?php if (!empty($p['operateur_nom'])): ?>
                            <span class="badge badge-depot"><?= esc($p['operateur_nom']) ?></span>
                        <?php else: ?>
                            <span class="text-muted small">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-end">
                        <form action="/admin/prefixes/delete/<?= $p['id'] ?>" method="post" onsubmit="return confirm('Supprimer le préfixe <?= esc($p['code']) ?> ?');" class="d-inline">
                            <button type="submit" class="btn btn-danger btn-sm">🗑 Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

