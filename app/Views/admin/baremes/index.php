<!-- Formulaire d'ajout -->
<div class="card">
    <h3>➕ Ajouter une nouvelle tranche</h3>
    <form action="/admin/baremes/add" method="post">
        <div class="form-row">
            <div class="form-group">
                <label for="type_op_id">Type d'opération</label>
                <select name="type_op_id" id="type_op_id" required>
                    <option value="">Sélectionner...</option>
                    <?php foreach ($types_operation as $type): ?>
                        <option value="<?= esc($type['id']) ?>"><?= esc(ucfirst($type['nom'])) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="montant_min">Montant min</label>
                <input type="number" name="montant_min" id="montant_min" step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label for="montant_max">Montant max</label>
                <input type="number" name="montant_max" id="montant_max" step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label for="frais">Frais (FCFA)</label>
                <input type="number" name="frais" id="frais" step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label for="commission_externe_pct" style="color: #b8860b; font-weight: 700;">Commission externe (%)</label>
                <input type="number" name="commission_externe_pct" id="commission_externe_pct" step="0.1" min="0" value="0" style="width:90px;">
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </div>
    </form>
</div>

<div class="info-box">
    <strong>💡 Commission d'interconnexion :</strong> Pour les transferts vers d'autres opérateurs (externe), un pourcentage supplémentaire peut être appliqué en plus des frais normaux.
</div>

<!-- Liste des barèmes -->
<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Opération</th>
                <th>Min</th>
                <th>Max</th>
                <th>Frais</th>
                <th>Commission externe</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($baremes)): ?>
                <tr><td colspan="6" class="empty"><div class="empty"><div class="empty-icon">📋</div><p>Aucun barème configuré pour le moment.</p></div></td></tr>
            <?php else: ?>
                <?php foreach ($baremes as $b): ?>
                <tr>
                    <form action="/admin/baremes/update/<?= $b['id'] ?>" method="post">
                        <td>
                            <select name="type_op_id" style="width:130px; padding:7px 10px; border:1px solid #d1d5db; border-radius:5px;">
                                <?php foreach ($types_operation as $type): ?>
                                    <option value="<?= esc($type['id']) ?>" <?= $type['id'] == $b['type_op_id'] ? 'selected' : '' ?>>
                                        <?= esc(ucfirst($type['nom'])) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><input type="number" name="montant_min" value="<?= esc($b['montant_min']) ?>" step="0.01" min="0" style="width:90px; padding:7px 10px; border:1px solid #d1d5db; border-radius:5px;"></td>
                        <td><input type="number" name="montant_max" value="<?= esc($b['montant_max']) ?>" step="0.01" min="0" style="width:90px; padding:7px 10px; border:1px solid #d1d5db; border-radius:5px;"></td>
                        <td><input type="number" name="frais" value="<?= esc($b['frais']) ?>" step="0.01" min="0" style="width:80px; padding:7px 10px; border:1px solid #d1d5db; border-radius:5px;"></td>
                        <td>
                            <input type="number" name="commission_externe_pct"
                                   value="<?= esc($b['commission_externe_pct'] ?? 0) ?>"
                                   step="0.1" min="0" style="width:70px; padding:7px 10px; border:1px solid #f59e0b; border-radius:5px;">
                            <span style="font-size:12px; color:#888;">%</span>
                        </td>
                        <td class="actions" style="white-space:nowrap; display:flex; gap:6px;">
                            <button type="submit" class="btn btn-warning btn-sm">💾 Modifier</button>
                    </form>
                            <form action="/admin/baremes/delete/<?= $b['id'] ?>" method="post" onsubmit="return confirm('Supprimer cette tranche ?');" style="display:inline;">
                                <button type="submit" class="btn btn-danger btn-sm">🗑 Supprimer</button>
                            </form>
                        </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
