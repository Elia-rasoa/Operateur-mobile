<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Barèmes</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; padding: 30px; color: #333; }

        .container { max-width: 1100px; margin: 0 auto; }

        h2 { margin-bottom: 25px; color: #1a1a2e; font-size: 28px; border-bottom: 3px solid #4361ee; padding-bottom: 10px; display: inline-block; }

        .message {
            padding: 12px 18px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: 500;
            border-left: 4px solid;
        }
        .message.success { background: #d4edda; color: #155724; border-color: #28a745; }
        .message.error { background: #f8d7da; color: #721c24; border-color: #dc3545; }

        /* ---- Ajout ---- */
        .add-section {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            margin-bottom: 30px;
        }
        .add-section h3 { margin-bottom: 18px; color: #4361ee; font-size: 20px; }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: flex-end;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-width: 140px;
        }
        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
        }
        .form-group select,
        .form-group input {
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-group select:focus,
        .form-group input:focus { border-color: #4361ee; }

        .btn {
            padding: 10px 22px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }
        .btn:active { transform: scale(0.97); }

        .btn-add {
            background: #4361ee;
            color: #fff;
            height: 40px;
            align-self: flex-end;
        }
        .btn-add:hover { background: #3651d9; }

        .btn-edit {
            background: #ffc107;
            color: #333;
            padding: 6px 14px;
            font-size: 13px;
        }
        .btn-edit:hover { background: #e0a800; }

        .btn-delete {
            background: #dc3545;
            color: #fff;
            padding: 6px 14px;
            font-size: 13px;
        }
        .btn-delete:hover { background: #c82333; }

        /* ---- Tableau ---- */
        .table-wrapper {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            overflow: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead {
            background: #4361ee;
            color: #fff;
        }
        th {
            text-align: left;
            padding: 14px 16px;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }
        td {
            padding: 12px 16px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
        }
        tr:last-child td { border-bottom: none; }
        tr:hover { background: #f8f9ff; }

        .inline-form { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
        .inline-form select,
        .inline-form input {
            padding: 7px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 13px;
            outline: none;
            width: 110px;
        }
        .inline-form select:focus,
        .inline-form input:focus { border-color: #4361ee; }

        .inline-form input[type="number"] { width: 90px; }
        .inline-form select { width: 120px; }

        .actions { display: flex; gap: 6px; flex-wrap: wrap; }

        .empty { text-align: center; padding: 40px; color: #888; font-style: italic; }
    </style>
</head>
<body>
    <div class="container">
        <h2>📊 Configuration des Barèmes</h2>

        <?php if (session()->has('message')): ?>
            <div class="message success"><?= session('message') ?></div>
        <?php endif; ?>

        <?php if (session()->has('error')): ?>
            <div class="message error"><?= session('error') ?></div>
        <?php endif; ?>

        <!-- Formulaire d'ajout -->
        <div class="add-section">
            <h3>➕ Ajouter une nouvelle tranche</h3>
            <form action="/admin/baremes/add" method="post">
                <div class="form-row">
                    <div class="form-group">
                        <label for="type_op_id">Type d'opération</label>
                        <select name="type_op_id" id="type_op_id" required>
                            <option value="">Sélectionner...</option>
                            <?php foreach ($types_operation as $type): ?>
                                <option value="<?= esc($type['id']) ?>"><?= esc(ucfirst($type['nom'])) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="montant_min">Montant min</label>
                        <input type="number" name="montant_min" id="montant_min" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="montant_max">Montant max</label>
                        <input type="number" name="montant_max" id="montant_max" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="frais">Frais</label>
                        <input type="number" name="frais" id="frais" step="0.01" min="0" required>
                    </div>
                    <button type="submit" class="btn btn-add">Ajouter</button>
                </div>
            </form>
        </div>

        <!-- Liste des barèmes -->
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Opération</th>
                        <th>Min</th>
                        <th>Max</th>
                        <th>Frais</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($baremes)): ?>
                        <tr><td colspan="5" class="empty">Aucun barème configuré pour le moment.</td></tr>
                    <?php else: ?>
                        <?php foreach ($baremes as $b): ?>
                        <tr>
                            <form action="/admin/baremes/update/<?= $b['id'] ?>" method="post">
                                <td>
                                    <select name="type_op_id" class="inline-form" style="width:130px;">
                                        <?php foreach ($types_operation as $type): ?>
                                            <option value="<?= esc($type['id']) ?>" <?= $type['id'] == $b['type_op_id'] ? 'selected' : '' ?>>
                                                <?= esc(ucfirst($type['nom'])) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><input type="number" name="montant_min" value="<?= esc($b['montant_min']) ?>" step="0.01" min="0" style="width:100px; padding:7px 10px; border:1px solid #ccc; border-radius:5px;"></td>
                                <td><input type="number" name="montant_max" value="<?= esc($b['montant_max']) ?>" step="0.01" min="0" style="width:100px; padding:7px 10px; border:1px solid #ccc; border-radius:5px;"></td>
                                <td><input type="number" name="frais" value="<?= esc($b['frais']) ?>" step="0.01" min="0" style="width:90px; padding:7px 10px; border:1px solid #ccc; border-radius:5px;"></td>
                                <td class="actions">
                                    <button type="submit" class="btn btn-edit">💾 Modifier</button>
                            </form>
                                    <form action="/admin/baremes/delete/<?= $b['id'] ?>" method="post" onsubmit="return confirm('Supprimer cette tranche ?');">
                                        <button type="submit" class="btn btn-delete">🗑 Supprimer</button>
                                    </form>
                                </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
