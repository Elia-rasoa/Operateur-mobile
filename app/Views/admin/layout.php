<?php
// Vars par défaut
$currentRoute = service('uri')->getPath();
$sidebarItems = [
    'dashboard' => ['label' => 'Tableau de bord', 'route' => '/admin'],
    'transactions' => ['label' => 'Transactions', 'route' => '/admin/transactions'],
    'clients' => ['label' => 'Clients', 'route' => '/admin/clients'],
    'baremes' => ['label' => 'Barèmes', 'route' => '/admin/baremes'],
    'prefixes' => ['label' => 'Préfixes & Opérateurs', 'route' => '/admin/prefixes'],
    'gains' => ['label' => 'Gains', 'route' => '/admin/gains'],
    'reversement' => ['label' => 'Reversements', 'route' => '/admin/reversement'],
];
$isActive = function($route) use ($currentRoute) {
    return strpos($currentRoute, $route) === 0 ? 'active' : '';
};
$title = $title ?? 'Administration';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> - Administration</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Admin CSS centralisé -->
    <link href="/css/admin.css" rel="stylesheet">
</head>
<body>
    <!-- Toggle button for mobile -->
    <button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()">☰</button>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <span class="badge bg-primary"></span> Mobile Money
        </div>
        <nav class="sidebar-nav">
            <?php foreach ($sidebarItems as $key => $item): ?>
                <a href="<?= $item['route'] ?>" class="nav-link <?= $isActive($item['route']) ?>">
                    <?= $item['label'] ?>
                </a>
            <?php endforeach; ?>
        </nav>
        <div class="sidebar-footer">
            <a href="/admin/logout" class="nav-link">🚪 Déconnexion</a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <div class="page-header">
            <h2><?= esc($title) ?></h2>
            <div class="header-actions">
                <div class="user-info">
                    <div class="avatar">A</div>
                    <span>Admin</span>
                </div>
            </div>
        </div>

        <?php if (session()->has('message')): ?>
            <div class="alert alert-success d-flex align-items-center gap-2 border-start border-success border-4" role="alert">
                <span>✅</span>
                <span><?= session('message') ?></span>
            </div>
        <?php endif; ?>
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger d-flex align-items-center gap-2 border-start border-danger border-4" role="alert">
                <span>❌</span>
                <span><?= session('error') ?></span>
            </div>
        <?php endif; ?>

        <?= $content ?? '' ?>
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }
    </script>
</body>
</html>

