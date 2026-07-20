<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Clients</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; padding: 30px; color: #333; }
        .container { max-width: 1000px; margin: 0 auto; }
        h2 { margin-bottom: 25px; color: #1a1a2e; font-size: 28px; border-bottom: 3px solid #4361ee; padding-bottom: 10px; display: inline-block; }
        .message { padding: 12px 18px; border-radius: 6px; margin-bottom: 20px; font-weight: 500; border-left: 4px solid; }
        .message.success { background: #d4edda; color: #155724; border-color: #28a745; }
        .message.error { background: #f8d7da; color: #721c24; border-color: #dc3545; }
        .table-wrapper { background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #4361ee; color: #fff; }
        th { text-align: left; padding: 14px 16px; font-size: 14px; font-weight: 600; }
        td { padding: 12px 16px; border-bottom: 1px solid #e9ecef; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover { background: #f8f9ff; }
        .btn { padding: 7px 16px; border: none; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-block; transition: background 0.2s; }
        .btn-details { background: #4361ee; color: #fff; }
        .btn-details:hover { background: #3651d9; }
        .solde-positif { color: #28a745; font-weight: 700; }
        .solde-negatif { color: #dc3545; font-weight: 700; }
        .phone-link { color: #4361ee; font-weight: 600; text-decoration: none; }
        .phone-link:hover { text-decoration: underline; }
        .empty { text-align: center; padding: 40px; color: #888; font-style: italic; }
        .stats-row {
            display: flex; gap: 20px; margin-bottom: 25px; flex-wrap: wrap;
        }
        .stat-card {
            background: #fff; border-radius: 10px; padding: 20px 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07); flex: 1; min-width: 180px;
        }
        .stat-card .stat-label { font-size: 13px; color: #888; text-transform: uppercase; letter-spacing: 0.5px; }
        .stat-card .stat-value { font-size: 28px; font-weight: 800; color: #1a1a2e; margin-top: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>👥 Gestion des Clients</h2>

        <?php if (session()->has('message')): ?><div class="message success"><?= session('message') ?></div><?php endif; ?>
        <?php if (session()->has('error')): ?><div class="message error"><?= session('error') ?></div><?php endif; ?>

        <!-- Stats -->
        <?php
            $total_clients = count($clients);
            $solde_total = array_sum(array_column($clients, 'solde'));
        ?>
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-label">Total clients</div>
                <div class="stat-value"><?= $total_clients ?></div>
            <div class="stat-card">
                <div class="stat-label">Solde total</div>
                <div class="stat-value" style="color:#4361ee;"><?= number_format($solde_total, 0, ',', ' ') ?> FCFA</div>
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
                        <tr><td colspan="5" class="empty">Aucun client enregistré.</td></tr>
                    <?php else: ?>
                        <?php foreach ($clients as $c): ?>
                        <tr>
                            <td>#<?= esc($c['id']) ?></td>
                            <td><a href="/admin/clients/historique/<?= esc($c['id']) ?>" class="phone-link"><?= esc($c['telephone']) ?></a></td>
                            <td><?= esc($c['nom'] ?? '-') ?></td>
                            <td class="<?= $c['solde'] >= 0 ? 'solde-positif' : 'solde-negatif' ?>">
                                <?= number_format($c['solde'], 0, ',', ' ') ?> FCFA
                            </td>
                            <td>
                                <a href="/admin/clients/historique/<?= esc($c['id']) ?>" class="btn btn-details">📋 Historique</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
</body>
</html>
