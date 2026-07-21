<div class="mb-4">
    <a href="/admin/clients" class="text-decoration-none fw-semibold" style="color:#4361ee;">← Retour à la liste des clients</a>
</div>

<div class="card shadow-sm border-0 rounded-3 p-4 mb-4">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="small text-muted text-uppercase fw-semibold" style="letter-spacing:0.5px;">Téléphone</div>
            <div class="h5 fw-bold mt-1" style="color:#1a1a2e;"><?= esc($client['numero_telephone'] ?? $client['telephone'] ?? '-') ?></div>
        </div>
        <div class="col-md-4">
            <div class="small text-muted text-uppercase fw-semibold" style="letter-spacing:0.5px;">Nom</div>
            <div class="h5 fw-bold mt-1" style="color:#1a1a2e;"><?= esc($client['nom'] ?? '-') ?></div>
        </div>
        <div class="col-md-4">
            <div class="small text-muted text-uppercase fw-semibold" style="letter-spacing:0.5px;">Solde actuel</div>
            <div class="h5 fw-bold mt-1" style="color: <?= ($client['solde'] ?? 0) >= 0 ? '#16a34a' : '#dc3545' ?>;">
                <?= number_format($client['solde'] ?? 0, 0, ',', ' ') ?> FCFA
            </div>
        </div>
    </div>
</div>

<div class="table-wrapper">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Opération</th>
                <th class="text-end">Montant</th>
                <th class="text-end">Frais</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($transactions)): ?>
                <tr><td colspan="5" class="text-center py-5 text-muted">📋 Aucune transaction pour ce client.</td></tr>
            <?php else: ?>
                <?php foreach ($transactions as $t): ?>
                <tr>
                    <td>#<?= esc($t['id']) ?></td>
                    <td class="text-muted small"><?= esc(date('d/m/Y H:i', strtotime($t['date_transaction']))) ?></td>
                    <td>
                        <span class="badge bg-<?= (($t['type_nom'] ?? '') === 'depot') ? 'success' : ((($t['type_nom'] ?? '') === 'retrait') ? 'danger' : 'primary') ?>">
                            <?= esc(ucfirst($t['type_nom'] ?? 'N/A')) ?>
                        </span>
                    </td>
                    <td class="mono text-end"><?= number_format($t['montant'], 0, ',', ' ') ?> FCFA</td>
                    <td class="mono text-end text-danger"><?= number_format($t['frais_appliques'], 0, ',', ' ') ?> FCFA</td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<<<<<<< HEAD

=======
>>>>>>> origin/main
