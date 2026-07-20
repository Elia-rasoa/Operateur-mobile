<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Préfixes</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; padding: 30px; color: #333; }
        .container { max-width: 800px; margin: 0 auto; }
        h2 { margin-bottom: 25px; color: #1a1a2e; font-size: 28px; border-bottom: 3px solid #4361ee; padding-bottom: 10px; display: inline-block; }
        .message { padding: 12px 18px; border-radius: 6px; margin-bottom: 20px; font-weight: 500; border-left: 4px solid; }
        .message.success { background: #d4edda; color: #155724; border-color: #28a745; }
        .message.error { background: #f8d7da; color: #721c24; border-color: #dc3545; }
        .add-section { background: #fff; border-radius: 10px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); margin-bottom: 30px; }
        .add-section h3 { margin-bottom: 18px; color: #4361ee; font-size: 20px; }
        .form-row { display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap; }
        .form-group { display: flex; flex-direction: column; flex: 1; min-width: 200px; }
        .form-group label { font-size: 13px; font-weight: 600; color: #555; margin-bottom: 5px; }
        .form-group input { padding: 10px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; outline: none; }
        .form-group input:focus { border-color: #4361ee; }
        .btn { padding: 10px 22px; border: none; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; transition: background 0.2s; }
        .btn-add { background: #4361ee; color: #fff; height: 40px; }
        .btn-add:hover { background: #3651d9; }
        .btn-delete { background: #dc3545; color: #fff; padding: 6px 14px; font-size: 13px; }
        .btn-delete:hover { background: #c82333; }
        .table-wrapper { background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #4361ee; color: #fff; }
        th { text-align: left; padding: 14px 16px; font-size: 14px; font-weight: 600; }
        td { padding: 12px 16px; border-bottom: 1px solid #e9ecef; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover { background: #f8f9ff; }
        .code-badge { background: #e8ecf8; color: #4361ee; font-weight: 700; font-size: 16px; padding: 4px 14px; border-radius: 20px; display: inline-block; }
        .empty { text-align: center; padding: 40px; color: #888; font-style: italic; }
    </style>
</head>
<body>
    <div class="container">
        <h2>📞 Gestion des Préfixes</h2>

        <?php if (session()->has('message')): ?><div class="message success"><?= session('message') ?></div><?php endif; ?>
        <?php if (session()->has('error')): ?><div class="message error"><?= session('error') ?></div><?php endif; ?>

        <div class="add-section">
            <h3>➕ Ajouter un préfixe</h3>
            <form action="/admin/prefixes/add" method="post">
                <div class="form-row">
                    <div class="form-group">
                        <label for="code">Code préfixe</label>
                        <input type="text" name="code" id="code" placeholder="Ex: 038" maxlength="5" required>
                    </div>
                    <button type="submit" class="btn btn-add">Ajouter</button>
                </div>
            </form>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr><th>ID</th><th>Code</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php if (empty($prefixes)): ?>
                        <tr><td colspan="3" class="empty">Aucun préfixe configuré.</td></tr>
                    <?php else: ?>
                        <?php foreach ($prefixes as $p): ?>
                        <tr>
                            <td><?= esc($p['id']) ?></td>
                            <td><span class="code-badge"><?= esc($p['code']) ?></span></td>
                            <td>
                                <form action="/admin/prefixes/delete/<?= $p['id'] ?>" method="post" onsubmit="return confirm('Supprimer le préfixe <?= esc($p['code']) ?> ?');">
                                    <button type="submit" class="btn btn-delete">🗑 Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
</body>
</html>
