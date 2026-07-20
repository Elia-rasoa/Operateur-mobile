<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique - Mobile Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-primary mb-1">Historique de vos transactions</h3>
                <p class="text-muted mb-0">Consultation de toutes vos opérations</p>
            </div>
            <a href="<?= base_url('/client/dashboard') ?>" class="btn btn-outline-primary">← Retour au tableau de bord</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted small">Téléphone</p>
                        <p class="fw-bold mb-0"><?= esc($client['numero_telephone'] ?? $client['telephone'] ?? '-') ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted small">Solde actuel</p>
                        <p class="fw-bold mb-0 text-success"><?= number_format($client['solde'], 2, ',', ' ') ?> Ar</p>
                    </div>
                </div>

                <?php if (empty($transactions)): ?>
                    <div class="alert alert-info mb-0">Aucune transaction enregistrée pour le moment.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Montant</th>
                                    <th>Frais</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transactions as $t): ?>
                                    <tr>
                                        <td><?= esc(date('d/m/Y H:i', strtotime($t['date_transaction']))) ?></td>
                                        <td><span class="badge bg-primary-subtle text-primary"><?= esc(ucfirst($t['type_nom'] ?? 'N/A')) ?></span></td>
                                        <td><?= number_format($t['montant'], 2, ',', ' ') ?> Ar</td>
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
</body>
</html>
