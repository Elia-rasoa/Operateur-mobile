<!DOCTYPE html>
<html>
<head><title>Gestion des Barèmes</title></head>
<body>
    <h2>Gestion des Barèmes</h2>
    
    <?php if (session()->has('message')): ?>
        <p style="color: green;"><?= session('message') ?></p>
    <?php endif; ?>

    <table border="1">
        <tr>
            <th>Opération</th>
            <th>Min</th>
            <th>Max</th>
            <th>Frais</th>
            <th>Action</th>
        </tr>
        <?php foreach ($baremes as $b): ?>
        <tr>
            <td><?= esc($b['type_nom']) ?></td>
            <td><?= esc($b['montant_min']) ?></td>
            <td><?= esc($b['montant_max']) ?></td>
            <td>
                <form action="/admin/baremes/update/<?= $b['id'] ?>" method="post">
                    <input type="number" name="frais" value="<?= esc($b['frais']) ?>" step="0.01">
            </td>
            <td>
                    <button type="submit">Modifier</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>