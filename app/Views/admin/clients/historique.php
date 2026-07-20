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
            <a class="navbar-brand fw-bold" href="#">Mobile Money - Administration</a>
        </div>
    </nav>

    <div class="container my-5">
        <div class="card shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-secondary">📋 Historique des transactions</h5>
                <span class="badge bg-primary rounded-pill"><?= count($transactions) ?> transaction(s)</span>
            </div>
            <div class="card-body p-0">
                <?php if (empty($transactions)): ?>
                    <div class="text-center py-5">
                        <p class="text-muted mb-0">Aucune transaction enregistrée pour le moment.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Source</th>
                                    <th>Destinataire</th>
                                    <th>Montant</th>
                                    <th>Frais</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transactions as $t): ?>
                                    <tr>
                                        <td><?= esc($t['id']) ?></td>
                                        <td><?= esc($t['date_transaction']) ?></td>
                                        <td>
                                            <?php
                                                $badgeClass = 'secondary';
                                                if ($t['type_operation'] === 'depot') $badgeClass = 'success';
                                                elseif ($t['type_operation'] === 'retrait') $badgeClass = 'danger';
                                                elseif ($t['type_operation'] === 'transfert') $badgeClass = 'primary';
                                            ?>
                                            <span class="badge bg-<?= $badgeClass ?>">
                                                <?= esc($t['type_operation']) ?>
                                            </span>
                                        </td>
                                        <td><?= esc($t['source_phone'] ?? '-') ?></td>
                                        <td><?= esc($t['dest_phone'] ?? '-') ?></td>
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

