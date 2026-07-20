<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique - <?= esc($client['telephone']) ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; padding: 30px; color: #333; }
        .container { max-width: 1000px; margin: 0 auto; }
        h2 { margin-bottom: 5px; color: #1a1a2e; font-size: 28px; border-bottom: 3px solid #4361ee; padding-bottom: 10px; display: inline-block; }
        .back-link { margin-bottom: 25px; display: block; }
        .back-link a { color: #4361ee; text-decoration: none; font-weight: 600; }
        .back-link a:hover { text-decoration: underline; }
        .message { padding: 12px 18px; border-radius: 6px; margin-bottom: 20px; font-weight: 500; border-left: 4px solid; }
        .message.success { background: #d4edda; color: #155724; border-color: #28a745; }
        .message.error { background: #f8d7da; color: #721c24; border-color: #dc3545; }
        .client-info {
            background: #fff;
            border-radius: 10px;
            padding: 20px 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            margin-bottom: 25px;
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }
        .client-info .info-item { }
        .client-info .info-label { font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: 0.5px; }
        .client-info .info-value { font-size: 20px; font-weight: 700; color: #1a1a2e; margin-top: 3px; }
        .table-wrapper { background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #4361ee; color: #fff; }
        th { text-align: left; padding: 14px 16px; font-size: 14px; font-weight: 600; }
        td { padding: 12px 16px; border-bottom: 1px solid #e9ecef; }
        tr:last-child td { border-bottom: none; }
        tr:hover { background: #f8f9ff; }
        .mono { font-family: 'Courier New', monospace; font-weight: 600; }
        .badge {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-depot { background: #d4edda; color: #155724; }
        .badge-retrait { background: #f8d7da; color: #721c24; }
        .badge-transfert { background: #fff3cd; color: #856404; }
        .text-muted { color: #888; font-size: 13px; }
        .empty { text-align: center; padding: 40px; color: #888; font-style: italic; }
    </style>
</head>
<body>
    <div class="container">
        <div class="back-link"><a href="/admin/clients">← Retour à la liste des clients</a></div>
        <h2>📋 Historique des transactions</h2>

        <!-- Infos client -->
        <div class="client-info">
            <div class="info-item">
                <div class="info-label">Téléphone</div>
                <div class="info-value"><?= esc($client['numero_telephone'] ?? $client['telephone'] ?? '-') ?></div>
            <div class="info-item">
                <div class="info-label">Nom</div>
                <div class="info-value"><?= esc($client['nom'] ?? '-') ?></div>
            <div class="info-item">
                <div class="info-label">Solde actuel</div>
                <div class="info-value" style="color: <?= $client['solde'] >= 0 ? '#28a745' : '#dc3545' ?>;">
                    <?= number_format($client['solde'], 0, ',', ' ') ?> FCFA
                </div>
        </div>

        <?php if (session()->has('message')): ?><div class="message success"><?= session('message') ?></div><?php endif; ?>

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
                        <tr><td colspan="5" class="empty">Aucune transaction pour ce client.</td></tr>
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
</body>
</html>
