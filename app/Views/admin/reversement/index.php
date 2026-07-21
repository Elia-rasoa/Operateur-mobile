<div class="info-box">
    <strong>🏢 Opérateur courant :</strong>
    <?php if ($operateurCourant): ?>
        <span class="fw-bold" style="color:#4361ee;"><?= esc($operateurCourant['nom_operateur']) ?></span>
        (préfixe <span class="fw-bold" style="color:#4361ee;"><?= esc($operateurCourant['prefixe']) ?></span>)
    <?php else: ?>
        <span class="text-muted">Non configuré — allez dans <a href="/admin/prefixes">Préfixes & Opérateurs</a></span>
    <?php endif; ?>
    <br>
    <strong>💡 Principe :</strong> Pour chaque opérateur tiers, le montant total des transferts externes
    moins la commission de gestion retenue donne le <strong>montant net à reverser</strong>.
</div>

<!-- Configuration du % de frais de gestion -->
<div class="card shadow-sm border-0 rounded-3 p-4 mb-4">
    <h3 class="h5 fw-bold mb-3">⚙️ Commission de gestion</h3>
    <form action="/admin/reversement" method="get">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <div class="form-group mb-0">
                    <label for="frais_gestion_pct" class="form-label small fw-semibold">Frais de gestion retenus (%)</label>
                    <input type="number" name="frais_gestion_pct" id="frais_gestion_pct" class="form-control"
                           value="<?= esc($fraisGestionPct) ?>" step="0.5" min="0" max="100">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Recalculer</button>
            </div>
        </div>
    </form>
</div>

<div class="table-wrapper">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th>Opérateur tiers</th>
                <th>Préfixe</th>
                <th class="text-center">Transactions</th>
                <th class="text-end">Total montant</th>
                <th class="text-end">Total frais</th>
                <th class="text-end">Commission gestion</th>
                <th class="text-end">Montant à reverser</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($reversements)): ?>
                <tr><td colspan="7" class="text-center py-5 text-muted">🔄 Aucune transaction externe trouvée pour le moment.</td></tr>
            <?php else: ?>
                <?php foreach ($reversements as $r): ?>
                <tr>
                    <td><strong><?= esc($r['operateur_nom']) ?></strong></td>
                    <td><span class="badge" style="background:#d4edda; color:#155724;"><?= esc($r['prefixe']) ?></span></td>
                    <td class="text-center text-muted"><?= $r['nb_transactions'] ?></td>
                    <td class="mono text-end"><?= number_format($r['total_montant'], 0, ',', ' ') ?> FCFA</td>
                    <td class="mono text-end text-danger"><?= number_format($r['total_frais'], 0, ',', ' ') ?> FCFA</td>
                    <td class="mono text-end text-warning">- <?= number_format($r['commission_gestion'], 0, ',', ' ') ?> FCFA</td>
                    <td class="mono text-end"><span class="badge" style="background:#fff3cd; color:#856404; font-size:0.875rem;"><?= number_format($r['montant_reverser'], 0, ',', ' ') ?> FCFA</span></td>
                </tr>
                <?php endforeach; ?>
                <!-- Ligne total -->
                <tr class="table-primary fw-bold">
                    <td colspan="2"><strong>TOTAL GÉNÉRAL</strong></td>
                    <td class="text-center"><strong><?= array_sum(array_column($reversements, 'nb_transactions')) ?></strong></td>
                    <td class="mono text-end"><strong><?= number_format($totalGlobal, 0, ',', ' ') ?> FCFA</strong></td>
                    <td class="mono text-end"><strong><?= number_format($totalFraisGlobal, 0, ',', ' ') ?> FCFA</strong></td>
                    <td class="mono text-end"><strong>- <?= number_format($totalCommissionGlobal, 0, ',', ' ') ?> FCFA</strong></td>
                    <td class="mono text-end"><strong><?= number_format($totalReversementGlobal, 0, ',', ' ') ?> FCFA</strong></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

