<!-- Formulaire d'ajout -->
<div class="card shadow-sm border-0 rounded-3 p-4 mb-4">
    <h3 class="h5 fw-bold mb-3">➕ Ajouter une nouvelle tranche</h3>
    <form action="/admin/baremes/add" method="post">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <div class="form-group mb-0">
                    <label for="type_op_id" class="form-label small fw-semibold">Type d'opération</label>
                    <select name="type_op_id" id="type_op_id" class="form-select" required>
                        <option value="">Sélectionner...</option>
                        <?php foreach ($types_operation as $type): ?>
                            <option value="<?= esc($type['id']) ?>"><?= esc(ucfirst($type['nom'])) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mb-0">
                    <label for="montant_min" class="form-label small fw-semibold">Montant min</label>
                    <input type="number" name="montant_min" id="montant_min" class="form-control" step="0.01" min="0" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mb-0">
                    <label for="montant_max" class="form-label small fw-semibold">Montant max</label>
                    <input type="number" name="montant_max" id="montant_max" class="form-control" step="0.01" min="0" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mb-0">
                    <label for="frais" class="form-label small fw-semibold">Frais (FCFA)</label>
                    <input type="number" name="frais" id="frais" class="form-control" step="0.01" min="0" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mb-0">
                    <label for="commission_externe_pct" class="form-label small fw-semibold text-warning">Commission externe (%)</label>
                    <input type="number" name="commission_externe_pct" id="commission_externe_pct" class="form-control" step="0.1" min="0" value="0">
                </div>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Ajouter</button>
            </div>
        </div>
    </form>
</div>

<div class="info-box">
    <strong>💡 Commission d'interconnexion :</strong> Pour les transferts vers d'autres opérateurs (externe), un pourcentage supplémentaire peut être appliqué en plus des frais normaux.
</div>

<!-- Liste des barèmes -->
<div class="table-wrapper">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th>Opération</th>
                <th>Min</th>
                <th>Max</th>
                <th>Frais</th>
                <th>Commission externe</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($baremes)): ?>
                <tr><td colspan="6" class="text-center py-5 text-muted">📋 Aucun barème configuré pour le moment.</td></tr>
            <?php else: ?>
                <?php foreach ($baremes as $b): ?>
                <tr>
                    <form action="/admin/baremes/update/<?= $b['id'] ?>" method="post">
                        <td>
                            <select name="type_op_id" class="form-select form-select-sm" style="width:130px;">
                                <?php foreach ($types_operation as $type): ?>
                                    <option value="<?= esc($type['id']) ?>" <?= $type['id'] == $b['type_op_id'] ? 'selected' : '' ?>>
                                        <?= esc(ucfirst($type['nom'])) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><input type="number" name="montant_min" value="<?= esc($b['montant_min']) ?>" class="form-control form-control-sm" style="width:90px;" step="0.01" min="0"></td>
                        <td><input type="number" name="montant_max" value="<?= esc($b['montant_max']) ?>" class="form-control form-control-sm" style="width:90px;" step="0.01" min="0"></td>
                        <td><input type="number" name="frais" value="<?= esc($b['frais']) ?>" class="form-control form-control-sm" style="width:80px;" step="0.01" min="0"></td>
                        <td>
                            <div class="input-group input-group-sm" style="width:100px;">
                                <input type="number" name="commission_externe_pct"
                                       value="<?= esc($b['commission_externe_pct'] ?? 0) ?>"
                                       class="form-control" step="0.1" min="0">
                                <span class="input-group-text">%</span>
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="d-flex gap-1 justify-content-end">
                                <button type="submit" class="btn btn-warning btn-sm">💾 Modifier</button>
                    </form>
                                <form action="/admin/baremes/delete/<?= $b['id'] ?>" method="post" onsubmit="return confirm('Supprimer cette tranche ?');" class="d-inline">
                                    <button type="submit" class="btn btn-danger btn-sm">🗑 Supprimer</button>
                                </form>
                            </div>
                        </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

