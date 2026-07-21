<<<<<<< HEAD
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

=======
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
>>>>>>> d687bcc7720acd28d531df105b7e26846ce91e69
