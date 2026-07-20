<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suivi des Transactions</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; padding: 30px; color: #333; }
        .container { max-width: 1200px; margin: 0 auto; }

        h2 { margin-bottom: 25px; color: #1a1a2e; font-size: 28px; border-bottom: 3px solid #4361ee; padding-bottom: 10px; display: inline-block; }

        .message { padding: 12px 18px; border-radius: 6px; margin-bottom: 20px; font-weight: 500; border-left: 4px solid; }
        .message.success { background: #d4edda; color: #155724; border-color: #28a745; }
        .message.error { background: #f8d7da; color: #721c24; border-color: #dc3545; }

        /* Gains box */
        .gains-box {
            background: linear-gradient(135deg, #4361ee, #3a56d4);
            color: #fff;
            border-radius: 12px;
            padding: 25px 30px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }
        .gains-box .label { font-size: 14px; opacity: 0.9; text-transform: uppercase; letter-spacing: 1px; }
        .gains-box .amount { font-size: 36px; font-weight: 800; }
        .gains-box .amount small { font-size: 18px; font-weight: 400; opacity: 0.8; }

        /* Filtres */
        .filter-section {
            background: #fff;
            border-radius: 10px;
            padding: 20px 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            margin-bottom: 25px;
        }
        .filter-section h3 { margin-bottom: 15px; color: #4361ee; font-size: 18px; }
        .filter-row { display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end; }
        .filter-group { display: flex; flex-direction: column; }
        .filter-group label { font-size: 13px; font-weight: 600; color: #555; margin-bottom: 5px; }
        .filter-group select,
        .filter-group input {
            padding: 9px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
        }
        .filter-group select:focus,
        .filter-group input:focus { border-color: #4361ee; }

        .btn {
            padding: 9px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-filter { background: #4361ee; color: #fff; }
        .btn-filter:hover { background: #3651d9; }
        .btn-reset { background: #6c757d; color: #fff; }
        .btn-reset:hover { background: #5a6268; }

        /* Tableau */
        .table-wrapper {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            overflow: hidden;
        }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #4361ee; color: #fff; }
        th { text-align: left; padding: 14px 16px; font-size: 14px; font-weight: 600; }
        td { padding: 12px 16px; border-bottom: 1px solid #e9ecef; }
        tr:last-child td { border-bottom: none; }
        tr:hover { background: #f8f9ff; }

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

        .empty { text-align: center; padding: 40px; color: #888; font-style: italic; }
        .text-muted { color: #888; font-size: 13px; }
        .mono { font-family: 'Courier New', monospace; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <h2>📈 Suivi des Transactions</h2>

        <?php if (session()->has('message')): ?><div class="message success"><?= session('message') ?></div><?php endif; ?>

        <!-- Carte des gains -->
        <div class="gains-box">
            <div>
                <div class="label">💰 Total des gains (frais récoltés)</div>
                <div class="amount"><?= number_format($total_gains, 2, ',', ' ') ?> <small>FCFA</small></div>
            <div style="text-align:right; font-size:14px; opacity:0.9;">
                <?php if ($filter_type): ?>
                    Filtré par type d'opération
                <?php else: ?>
                    Toutes opérations confondues
                <?php endif; ?>
            </div>

        <!-- Filtres -->
        <div class="filter-section">
            <h3>🔍 Filtrer les transactions</h3>
            <form action="/admin/transactions" method="get">
                <div class="filter-row">
                    <div class="filter-group">
                        <label for="type_op_id">Type d'opération</label>
                        <select name="type_op_id" id="type_op_id">
                            <option value="">Tous</option>
                            <?php foreach ($types_operation as $type): ?>
                                <option value="<?= esc($type['id']) ?>" <?= ($filter_type == $type['id']) ? 'selected' : '' ?>>
                                    <?= esc(ucfirst($type['nom'])) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="date_debut">Date début</label>
                        <input type="date" name="date_debut" id="date_debut" value="<?= esc($filter_debut ?? '') ?>">
                    </div>
                    <div class="filter-group">
                        <label for="date_fin">Date fin</label>
                        <input type="date" name="date_fin" id="date_fin" value="<?= esc($filter_fin ?? '') ?>">
                    </div>
                    <button type="submit" class="btn btn-filter">Filtrer</button>
                    <a href="/admin/transactions" class="btn btn-reset" style="text-decoration:none;">Réinitialiser</a>
                </div>
            </form>
        </div>

        <!-- Liste des transactions -->
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Client</th>
                        <th>Opération</th>
                        <th>Montant</th>
                        <th>Frais appliqués</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($transactions)): ?>
                        <tr><td colspan="6" class="empty">Aucune transaction trouvée.</td></tr>
                    <?php else: ?>
                        <?php foreach ($transactions as $t): ?>
                        <tr>
                            <td>#<?= esc($t['id']) ?></td>
                            <td class="text-muted"><?= esc(date('d/m/Y H:i', strtotime($t['date_transaction']))) ?></td>
                            <td>
                                <?= esc($t['client_nom'] ?? 'Inconnu') ?>
                                <span class="text-muted">(<?= esc($t['telephone'] ?? '-') ?>)</span>
                            </td>
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
