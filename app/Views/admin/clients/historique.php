<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Historique des transactions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/admin/clients">Mobile Money - Administration</a>
        </div>
    </nav>

    <div class="container my-5">
        <div class="card shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-secondary">📋 Historique des transactions</h5>
                <span class="badge bg-primary rounded-pill"><?= count($transactions) ?> transaction(s)</span>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <a href="/admin/clients" class="btn btn-outline-secondary btn-sm">← Retour à la liste des clients</a>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="border rounded p-3 bg-light">
                            <div class="text-muted small text-uppercase">Téléphone</div>
                            <div class="fw-bold mt-1"><?= esc($client['numero_telephone'] ?? $client['telephone'] ?? '-') ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3 bg-light">
                            <div class="text-muted small text-uppercase">Nom</div>
                            <div class="fw-bold mt-1"><?= esc($client['nom'] ?? '-') ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3 bg-light">
                            <div class="text-muted small text-uppercase">Solde actuel</div>
                            <div class="fw-bold mt-1" style="color: <?= $client['solde'] >= 0 ? '#28a745' : '#dc3545' ?>;">
                                <?= number_format($client['solde'], 0, ',', ' ') ?> Ar
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (empty($transactions)): ?>
                    <div class="text-center py-5">
                        <p class="text-muted mb-0">Aucune transaction enregistrée pour ce client.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Opération</th>
                                    <th>Montant</th>
                                    <th>Frais</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transactions as $t): ?>
                                    <tr>
                                        <td><?= esc($t['id']) ?></td>
                                        <td><?= esc($t['date_transaction'] ?? '-') ?></td>
                                        <td>
                                            <?php
                                                $badgeClass = 'secondary';
                                                if (($t['type_nom'] ?? '') === 'depot') $badgeClass = 'success';
                                                elseif (($t['type_nom'] ?? '') === 'retrait') $badgeClass = 'danger';
                                                elseif (($t['type_nom'] ?? '') === 'transfert') $badgeClass = 'primary';
                                            ?>
                                            <span class="badge bg-<?= $badgeClass ?>">
                                                <?= esc(ucfirst($t['type_nom'] ?? 'N/A')) ?>
                                            </span>
                                        </td>
                                        <td class="fw-medium"><?= number_format($t['montant'], 2, ',', ' ') ?> Ar</td>
                                        <td><?= number_format($t['frais_appliques'], 2, ',', ' ') ?> Ar</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
