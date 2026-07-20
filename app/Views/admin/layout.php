<?php
// Vars par défaut
$currentRoute = service('uri')->getPath();
$sidebarItems = [
    'dashboard' => ['label' => 'Tableau de bord', 'icon' => '📊', 'route' => '/admin'],
    'transactions' => ['label' => 'Transactions', 'icon' => '📈', 'route' => '/admin/transactions'],
    'clients' => ['label' => 'Clients', 'icon' => '👥', 'route' => '/admin/clients'],
    'baremes' => ['label' => 'Barèmes', 'icon' => '📋', 'route' => '/admin/baremes'],
    'prefixes' => ['label' => 'Préfixes & Opérateurs', 'icon' => '📞', 'route' => '/admin/prefixes'],
    'gains' => ['label' => 'Gains', 'icon' => '💰', 'route' => '/admin/gains'],
    'reversement' => ['label' => 'Reversements', 'icon' => '🔄', 'route' => '/admin/reversement'],
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
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --sidebar-width: 250px;
            --sidebar-bg: #1a1a2e;
            --sidebar-hover: #16213e;
            --primary: #4361ee;
            --primary-light: #eef0ff;
            --success: #16a34a;
            --danger: #dc3545;
            --warning: #f59e0b;
            --gray: #6b7280;
            --gray-light: #f3f4f6;
            --radius: 10px;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--gray-light);
            color: #1f2937;
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: #fff;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            transition: transform 0.3s;
        }
        .sidebar-logo {
            padding: 24px 20px;
            font-size: 22px;
            font-weight: 800;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .sidebar-logo span { background: var(--primary); padding: 6px 10px; border-radius: 8px; font-size: 16px; }
        .sidebar-nav { flex: 1; padding: 16px 12px; overflow-y: auto; }
        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 8px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 4px;
        }
        .sidebar-nav a:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .sidebar-nav a.active {
            background: var(--primary);
            color: #fff;
            font-weight: 600;
        }
        .sidebar-nav a .icon { font-size: 18px; width: 28px; text-align: center; }
        .sidebar-nav a .badge-count {
            margin-left: auto;
            background: rgba(255,255,255,0.15);
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
        }
        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-footer a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 8px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 13px;
            transition: all 0.2s;
        }
        .sidebar-footer a:hover { background: rgba(255,255,255,0.08); color: #f87171; }
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 12px;
            left: 12px;
            z-index: 200;
            background: var(--sidebar-bg);
            color: #fff;
            border: none;
            padding: 10px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 20px;
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 90;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 24px 32px;
            min-height: 100vh;
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .page-header h2 {
            font-size: 26px;
            font-weight: 700;
            color: #111827;
        }
        .page-header .header-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .page-header .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fff;
            padding: 8px 16px 8px 12px;
            border-radius: 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            font-size: 14px;
        }
        .page-header .user-info .avatar {
            width: 32px; height: 32px;
            background: var(--primary);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
        }

        /* ===== COMPONENTS ===== */
        .message {
            padding: 14px 20px;
            border-radius: var(--radius);
            margin-bottom: 20px;
            font-weight: 500;
            border-left: 4px solid;
            font-size: 14px;
        }
        .message.success { background: #dcfce7; color: #166534; border-color: var(--success); }
        .message.error { background: #fef2f2; color: #991b1b; border-color: var(--danger); }

        .card {
            background: #fff;
            border-radius: var(--radius);
            box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            padding: 24px;
            margin-bottom: 24px;
        }
        .card h3 {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 16px;
        }

        .table-wrapper {
            background: #fff;
            border-radius: var(--radius);
            box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            overflow: auto;
        }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f9fafb; }
        th { text-align: left; padding: 14px 16px; font-size: 13px; font-weight: 600; color: var(--gray); text-transform: uppercase; letter-spacing: 0.3px; }
        td { padding: 12px 16px; border-bottom: 1px solid #e5e7eb; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f9fafb; }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn:active { transform: scale(0.97); }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: #3651d9; }
        .btn-success { background: var(--success); color: #fff; }
        .btn-success:hover { background: #15803d; }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-danger:hover { background: #b91c1c; }
        .btn-warning { background: var(--warning); color: #fff; }
        .btn-warning:hover { background: #d97706; }
        .btn-outline { background: transparent; color: var(--gray); border: 1px solid #d1d5db; }
        .btn-outline:hover { background: var(--gray-light); }
        .btn-sm { padding: 6px 14px; font-size: 13px; }

        .badge {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-depot { background: #dcfce7; color: #166534; }
        .badge-retrait { background: #fef2f2; color: #991b1b; }
        .badge-transfert { background: #fffbeb; color: #92400e; }

        .form-group { display: flex; flex-direction: column; margin-bottom: 14px; }
        .form-group label { font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 5px; }
        .form-group input, .form-group select {
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-group input:focus, .form-group select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(67,97,238,0.1); }
        .form-row { display: flex; flex-wrap: wrap; gap: 14px; align-items: flex-end; }
        .form-row .form-group { flex: 1; min-width: 140px; }

        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 28px; }
        .stat-card {
            background: #fff;
            border-radius: var(--radius);
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            border-top: 3px solid var(--primary);
        }
        .stat-card .stat-label { font-size: 12px; color: var(--gray); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }
        .stat-card .stat-value { font-size: 26px; font-weight: 800; color: #111827; margin-top: 6px; }
        .stat-card .stat-sub { font-size: 13px; color: var(--gray); margin-top: 4px; }

        .info-box {
            background: #eef2ff; border: 1px solid var(--primary);
            border-radius: var(--radius); padding: 16px 20px;
            margin-bottom: 20px; color: #1e3a5f; font-size: 14px;
            line-height: 1.6;
        }

        .empty { text-align: center; padding: 48px 20px; color: var(--gray); }
        .empty .empty-icon { font-size: 48px; margin-bottom: 12px; }
        .empty p { font-style: italic; }
        .text-muted { color: var(--gray); font-size: 13px; }
        .mono { font-family: 'Courier New', monospace; font-weight: 600; }

        .inline-form { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-toggle { display: block; }
            .sidebar-overlay.show { display: block; }
            .main-content { margin-left: 0; padding: 16px; padding-top: 60px; }
            .page-header h2 { font-size: 20px; }
        }
    </style>
</head>
<body>
    <!-- Toggle button for mobile -->
    <button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()">☰</button>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <span>📱</span> Mobile Money
        </div>
        <nav class="sidebar-nav">
            <?php foreach ($sidebarItems as $key => $item): ?>
                <a href="<?= $item['route'] ?>" class="<?= $isActive($item['route']) ?>">
                    <span class="icon"><?= $item['icon'] ?></span>
                    <?= $item['label'] ?>
                </a>
            <?php endforeach; ?>
        </nav>
        <div class="sidebar-footer">
            <a href="/admin/logout">🚪 Déconnexion</a>
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

        <?php if (session()->has('message')): ?>
            <div class="message success"><?= session('message') ?></div>
        <?php endif; ?>
        <?php if (session()->has('error')): ?>
            <div class="message error"><?= session('error') ?></div>
        <?php endif; ?>

        <?= $content ?? '' ?>
    </main>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }
    </script>
</body>
</html>
