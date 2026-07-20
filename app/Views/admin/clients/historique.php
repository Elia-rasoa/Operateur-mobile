<div class="back-link" style="margin-bottom:20px;">
    <a href="/admin/clients" style="color:#4361ee; text-decoration:none; font-weight:600;">← Retour à la liste des clients</a>
</div>

<!-- Infos client -->
<div class="card" style="display:flex; gap:30px; flex-wrap:wrap;">
    <div>
        <div style="font-size:12px; color:#888; text-transform:uppercase; letter-spacing:0.5px;">Téléphone</div>
        <div style="font-size:20px; font-weight:700; color:#1a1a2e; margin-top:3px;"><?= esc($client['numero_telephone'] ?? $client['telephone'] ?? '-') ?></div>
    <div>
        <div style="font-size:12px; color:#888; text-transform:uppercase; letter-spacing:0.5px;">Nom</div>
        <div style="font-size:20px; font-weight:700; color:#1a1a2e; margin-top:3px;"><?= esc($client['nom'] ?? '-') ?></div>
    <div>
        <div style="font-size:12px; color:#888; text-transform:uppercase; letter-spacing:0.5px;">Solde actuel</div>
        <div style="font-size:20px; font-weight:700; margin-top:3px; color: <?= $client['solde'] >= 0 ? '#28a745' : '#dc3545' ?>;">
            <?= number_format($client['solde'], 0, ',', ' ') ?> FCFA
        </div>
</div>

<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Opération</th>
                <th>Montant</th>
                <th>Frais</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($transactions)): ?>
                <tr><td colspan="5" class="empty"><div class="empty"><div class="empty-icon">📋</div><p>Aucune transaction pour ce client.</p></div></td></tr>
            <?php else: ?>
                <?php foreach ($transactions as $t): ?>
                <tr>
                    <td>#<?= esc($t['id']) ?></td>
                    <td class="text-muted"><?= esc(date('d/m/Y H:i', strtotime($t['date_transaction']))) ?></td>
                    <td>
                        <span class="badge badge-<?= esc($t['type_nom'] ?? '') ?>">
                            <?= esc(ucfirst($t['type_nom'] ?? 'N/A')) ?>
                        </span>
                    </td>
                    <td class="mono"><?= number_format($t['montant'], 0, ',', ' ') ?> FCFA</td>
                    <td class="mono" style="color:#dc3545;"><?= number_format($t['frais_appliques'], 0, ',', ' ') ?> FCFA</td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
