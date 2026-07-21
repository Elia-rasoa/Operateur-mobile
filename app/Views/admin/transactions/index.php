<!-- Carte des gains -->
<div class="gains-box">
    <div>
        <div class="label">💰 Total des gains (frais récoltés)</div>
        <div class="amount"><?= number_format($total_gains, 2, ',', ' ') ?> <small>FCFA</small></div>
    </div>
    <div class="text-end small opacity-75">
        <?php if ($filter_type): ?>
            Filtré par type d'opération
        <?php else: ?>
            Toutes opérations confondues
        <?php endif; ?>
    </div>
</div>

<!-- Filtres -->
<div class="card shadow-sm border-0 rounded-3 p-4 mb-4">
    <h3 class="h5 fw-bold mb-3">🔍 Filtrer les transactions</h3>
    <form action="/admin/transactions" method="get">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <div class="form-group mb-0">
                    <label for="type_op_id" class="form-label small fw-semibold">Type d'opération</label>
                    <select name="type_op_id" id="type_op_id" class="form-select">
                        <option value="">Tous</option>
                        <?php foreach ($types_operation as $type): ?>
                            <option value="<?= esc($type['id']) ?>" <?= ($filter_type == $type['id']) ? 'selected' : '' ?>>
                                <?= esc(ucfirst($type['nom'])) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mb-0">
                    <label for="type_reseau" class="form-label small fw-semibold">Réseau</label>
                    <select name="type_reseau" id="type_reseau" class="form-select">
                        <option value="">Tous</option>
                        <option value="interne" <?= ($filter_reseau === 'interne') ? 'selected' : '' ?>>Interne</option>
                        <option value="externe" <?= ($filter_reseau === 'externe') ? 'selected' : '' ?>>Externe</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mb-0">
                    <label for="date_debut" class="form-label small fw-semibold">Date début</label>
                    <input type="date" name="date_debut" id="date_debut" class="form-control" value="<?= esc($filter_debut ?? '') ?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mb-0">
                    <label for="date_fin" class="form-label small fw-semibold">Date fin</label>
                    <input type="date" name="date_fin" id="date_fin" class="form-control" value="<?= esc($filter_fin ?? '') ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Filtrer</button>
                    <a href="/admin/transactions" class="btn btn-outline-secondary text-decoration-none">Réinitialiser</a>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Liste des transactions -->
<div class="table-wrapper">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Client</th>
                <th>Opération</th>
                <th>Réseau</th>
                <th class="text-end">Montant</th>
                <th class="text-end">Frais appliqués</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($transactions)): ?>
                <tr><td colspan="7" class="text-center py-5 text-muted">📈 Aucune transaction trouvée.</td></tr>
            <?php else: ?>
                <?php foreach ($transactions as $t): ?>
                <tr>
                    <td>#<?= esc($t['id']) ?></td>
                    <td class="text-muted small"><?= esc(date('d/m/Y H:i', strtotime($t['date_transaction']))) ?></td>
                    <td>
                        <?= esc($t['client_nom'] ?? 'Inconnu') ?>
                        <span class="text-muted small">(<?= esc($t['telephone'] ?? '-') ?>)</span>
                    </td>
                    <td>
                        <span class="badge badge-<?= esc($t['type_nom'] ?? '') ?>">
                            <?= esc(ucfirst($t['type_nom'] ?? 'N/A')) ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($t['type_reseau'] === 'externe'): ?>
                            <span class="badge badge-externe">🌍 Externe</span>
                        <?php else: ?>
                            <span class="badge badge-interne">🔵 Interne</span>
                        <?php endif; ?>
                    </td>
                    <td class="mono text-end"><?= number_format($t['montant'], 0, ',', ' ') ?> FCFA</td>
                    <td class="mono text-end text-danger"><?= number_format($t['frais_appliques'], 0, ',', ' ') ?> FCFA</td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

