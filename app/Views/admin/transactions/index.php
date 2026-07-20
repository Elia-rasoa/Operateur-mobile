<!-- Carte des gains -->
<div class="gains-box">
    <div>
        <div class="label">💰 Total des gains (frais récoltés)</div>
        <div class="amount"><?= number_format($total_gains, 2, ',', ' ') ?> <small>FCFA</small></div>
    <div style="text-align:right; font-size:14px; opacity:0.9;">
        <?php if ($filter_type): ?>
            Filtré par type d'opération
        <?php else: ?>
            Toutes opérations confondues
        <?php endif; ?>
    </div>

<!-- Filtres -->
<div class="card">
    <h3>🔍 Filtrer les transactions</h3>
    <form action="/admin/transactions" method="get">
        <div class="form-row">
            <div class="form-group">
                <label for="type_op_id">Type d'opération</label>
                <select name="type_op_id" id="type_op_id">
                    <option value="">Tous</option>
                    <?php foreach ($types_operation as $type): ?>
                        <option value="<?= esc($type['id']) ?>" <?= ($filter_type == $type['id']) ? 'selected' : '' ?>>
                            <?= esc(ucfirst($type['nom'])) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="type_reseau">Réseau</label>
                <select name="type_reseau" id="type_reseau">
                    <option value="">Tous</option>
                    <option value="interne" <?= ($filter_reseau === 'interne') ? 'selected' : '' ?>>Interne</option>
                    <option value="externe" <?= ($filter_reseau === 'externe') ? 'selected' : '' ?>>Externe</option>
                </select>
            </div>
            <div class="form-group">
                <label for="date_debut">Date début</label>
                <input type="date" name="date_debut" id="date_debut" value="<?= esc($filter_debut ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="date_fin">Date fin</label>
                <input type="date" name="date_fin" id="date_fin" value="<?= esc($filter_fin ?? '') ?>">
            </div>
            <button type="submit" class="btn btn-primary">Filtrer</button>
            <a href="/admin/transactions" class="btn btn-outline" style="text-decoration:none;">Réinitialiser</a>
        </div>
    </form>
</div>

<!-- Liste des transactions -->
<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Client</th>
                <th>Opération</th>
                <th>Réseau</th>
                <th>Montant</th>
                <th>Frais appliqués</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($transactions)): ?>
                <tr><td colspan="7" class="empty"><div class="empty"><div class="empty-icon">📈</div><p>Aucune transaction trouvée.</p></div></td></tr>
            <?php else: ?>
                <?php foreach ($transactions as $t): ?>
                <tr>
                    <td>#<?= esc($t['id']) ?></td>
                    <td class="text-muted"><?= esc(date('d/m/Y H:i', strtotime($t['date_transaction']))) ?></td>
                    <td>
                        <?= esc($t['client_nom'] ?? 'Inconnu') ?>
                        <span class="text-muted">(<?= esc($t['telephone'] ?? '-') ?>)</span>
                    </td>
                    <td>
                        <span class="badge badge-<?= esc($t['type_nom'] ?? '') ?>">
                            <?= esc(ucfirst($t['type_nom'] ?? 'N/A')) ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($t['type_reseau'] === 'externe'): ?>
                            <span class="badge badge-retrait">🌍 Externe</span>
                        <?php else: ?>
                            <span class="badge badge-depot">🔵 Interne</span>
                        <?php endif; ?>
                    </td>
                    <td class="mono"><?= number_format($t['montant'], 0, ',', ' ') ?> FCFA</td>
                    <td class="mono" style="color:#dc3545;"><?= number_format($t['frais_appliques'], 0, ',', ' ') ?> FCFA</td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
