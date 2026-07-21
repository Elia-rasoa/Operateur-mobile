<!-- Stats -->
<?php
    $totalClients = count($clients);
    $soldeTotal = array_sum(array_column($clients, 'solde'));
?>
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="stat-card">
            <div class="stat-label">Total clients</div>
            <div class="stat-value"><?= esc($totalClients) ?></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="stat-card">
            <div class="stat-label">Solde total</div>
            <div class="stat-value" style="color:#4361ee;"><?= number_format($soldeTotal, 0, ',', ' ') ?> FCFA</div>
        </div>
    </div>
</div>

<div class="table-wrapper">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Téléphone</th>
                <th>Nom</th>
                <th class="text-end">Solde</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($clients)): ?>
                <tr><td colspan="5" class="text-center py-5 text-muted">👥 Aucun client enregistré.</td></tr>
            <?php else: ?>
                <?php foreach ($clients as $c): ?>
                <tr>
                    <td>#<?= esc($c['id']) ?></td>
                    <td><a href="/admin/clients/historique/<?= esc($c['id']) ?>" class="fw-semibold text-decoration-none" style="color:#4361ee;"><?= esc($c['numero_telephone'] ?? '-') ?></a></td>
                    <td><?= esc($c['nom'] ?? '-') ?></td>
                    <td class="text-end <?= ($c['solde'] ?? 0) >= 0 ? 'solde-positif' : 'solde-negatif' ?>">
                        <?= number_format($c['solde'] ?? 0, 0, ',', ' ') ?> FCFA
                    </td>
                    <td class="text-end">
                        <a href="/admin/clients/historique/<?= esc($c['id']) ?>" class="btn btn-primary btn-sm">📋 Historique</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

