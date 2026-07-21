<!-- Stats -->
<?php
    $total_clients = count($clients);
    $solde_total = array_sum(array_column($clients, 'solde'));
?>
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Total clients</div>
        <div class="stat-value"><?= esc($total_clients) ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Solde total</div>
        <div class="stat-value" style="color:#4361ee;"><?= number_format($solde_total, 0, ',', ' ') ?> FCFA</div>
    </div>
</div>

<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Téléphone</th>
                <th>Nom</th>
                <th>Solde</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($clients)): ?>
                <tr><td colspan="5" class="empty"><div class="empty"><div class="empty-icon">👥</div><p>Aucun client enregistré.</p></div></td></tr>
            <?php else: ?>
                <?php foreach ($clients as $c): ?>
                <tr>
                    <td>#<?= esc($c['id']) ?></td>
                    <td><a href="/admin/clients/historique/<?= esc($c['id']) ?>" style="color:#4361ee; font-weight:600; text-decoration:none;"><?= esc($c['numero_telephone'] ?? '-') ?></a></td>
                    <td><?= esc($c['nom'] ?? '-') ?></td>
                    <td class="<?= $c['solde'] >= 0 ? 'solde-positif' : 'solde-negatif' ?>" style="font-weight:700;">
                        <?= number_format($c['solde'], 0, ',', ' ') ?> FCFA
                    </td>
                    <td>
                        <a href="/admin/clients/historique/<?= esc($c['id']) ?>" class="btn btn-primary btn-sm">📋 Historique</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
