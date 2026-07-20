<div class="info-box">
    <strong>🏢 Opérateur courant :</strong>
    <?php if ($operateurCourant): ?>
        <span style="color:#4361ee; font-weight:700;"><?= esc($operateurCourant['nom_operateur']) ?></span>
        (préfixe <span style="color:#4361ee; font-weight:700;"><?= esc($operateurCourant['prefixe']) ?></span>)
    <?php else: ?>
        <span class="text-muted">Non configuré — allez dans <a href="/admin/prefixes">Préfixes & Opérateurs</a></span>
    <?php endif; ?>
    <br>
    <strong>💡 Principe :</strong> Pour chaque opérateur tiers, le montant total des transferts externes
    moins la commission de gestion retenue donne le <strong>montant net à reverser</strong>.
</div>

<!-- Configuration du % de frais de gestion -->
<div class="card">
    <h3>⚙️ Commission de gestion</h3>
    <form action="/admin/reversement" method="get">
        <div class="form-row">
            <div class="form-group">
                <label for="frais_gestion_pct">Frais de gestion retenus (%)</label>
                <input type="number" name="frais_gestion_pct" id="frais_gestion_pct"
                       value="<?= esc($fraisGestionPct) ?>" step="0.5" min="0" max="100">
            </div>
            <button type="submit" class="btn btn-primary">Recalculer</button>
        </div>
    </form>
</div>

<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Opérateur tiers</th>
                <th>Préfixe</th>
                <th>Transactions</th>
                <th>Total montant</th>
                <th>Total frais</th>
                <th>Commission gestion</th>
                <th>Montant à reverser</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($reversements)): ?>
                <tr><td colspan="7" class="empty"><div class="empty"><div class="empty-icon">🔄</div><p>Aucune transaction externe trouvée pour le moment.</p></div></td></tr>
            <?php else: ?>
                <?php foreach ($reversements as $r): ?>
                <tr>
                    <td><strong><?= esc($r['operateur_nom']) ?></strong></td>
                    <td><span class="badge" style="background:#d4edda; color:#155724;"><?= esc($r['prefixe']) ?></span></td>
                    <td class="text-muted"><?= $r['nb_transactions'] ?></td>
                    <td class="mono"><?= number_format($r['total_montant'], 0, ',', ' ') ?> FCFA</td>
                    <td class="mono" style="color:#dc3545;"><?= number_format($r['total_frais'], 0, ',', ' ') ?> FCFA</td>
                    <td class="mono" style="color:#f59e0b;">- <?= number_format($r['commission_gestion'], 0, ',', ' ') ?> FCFA</td>
                    <td class="mono"><span style="display:inline-block; background:#fff3cd; padding:2px 10px; border-radius:4px; font-weight:700;"><?= number_format($r['montant_reverser'], 0, ',', ' ') ?> FCFA</span></td>
                </tr>
                <?php endforeach; ?>
                <!-- Ligne total -->
                <tr style="background:#e8ecff !important; font-weight:700;">
                    <td colspan="2"><strong>TOTAL GÉNÉRAL</strong></td>
                    <td><strong><?= array_sum(array_column($reversements, 'nb_transactions')) ?></strong></td>
                    <td class="mono"><strong><?= number_format($totalGlobal, 0, ',', ' ') ?> FCFA</strong></td>
                    <td class="mono"><strong><?= number_format($totalFraisGlobal, 0, ',', ' ') ?> FCFA</strong></td>
                    <td class="mono"><strong>- <?= number_format($totalCommissionGlobal, 0, ',', ' ') ?> FCFA</strong></td>
                    <td class="mono"><strong><?= number_format($totalReversementGlobal, 0, ',', ' ') ?> FCFA</strong></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
