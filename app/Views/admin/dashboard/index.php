<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord administrateur</title>
    <style>
        :root { --primary: #4361ee; --dark: #17213d; --muted: #667085; --surface: #ffffff; --background: #f4f6fb; }
        * { box-sizing: border-box; }
        body { margin: 0; color: var(--dark); background: var(--background); font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; }
        .topbar { background: linear-gradient(120deg, #243b8f, var(--primary)); color: #fff; padding: 28px max(24px, calc((100% - 1160px) / 2)); }
        .topbar p { margin: 6px 0 0; opacity: .85; }
        .layout { max-width: 1160px; margin: 0 auto; padding: 32px 24px 48px; }
        h1 { margin: 0; font-size: clamp(25px, 4vw, 34px); }
        h2 { margin: 34px 0 16px; font-size: 20px; }
        .stats, .modules { display: grid; gap: 16px; }
        .stats { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        .stat, .module { background: var(--surface); border-radius: 14px; box-shadow: 0 4px 16px rgba(30, 41, 59, .07); }
        .stat { padding: 20px; border-top: 4px solid var(--primary); }
        .stat-label { color: var(--muted); font-size: 13px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; }
        .stat-value { margin-top: 9px; font-size: 27px; font-weight: 800; }
        .stats .stat:nth-child(2) { border-color: #16a34a; }
        .stats .stat:nth-child(3) { border-color: #ea580c; }
        .stats .stat:nth-child(4) { border-color: #9333ea; }
        .modules { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .module { display: flex; align-items: center; gap: 18px; padding: 22px; text-decoration: none; color: inherit; transition: transform .18s, box-shadow .18s; }
        .module:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(30, 41, 59, .13); }
        .icon { align-items: center; background: #e8ecff; border-radius: 12px; display: flex; flex: 0 0 52px; height: 52px; justify-content: center; font-size: 25px; }
        .module:nth-child(2) .icon { background: #dcfce7; }
        .module:nth-child(3) .icon { background: #ffedd5; }
        .module:nth-child(4) .icon { background: #f3e8ff; }
        .module h3 { margin: 0 0 5px; font-size: 17px; }
        .module p { color: var(--muted); font-size: 14px; line-height: 1.4; margin: 0; }
        .arrow { color: var(--primary); font-size: 23px; margin-left: auto; }
        @media (max-width: 760px) { .stats, .modules { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 480px) { .stats, .modules { grid-template-columns: 1fr; } .layout { padding: 24px 16px; } }
    </style>
</head>
<body>
    <header class="topbar">
        <h1>Administration · Opérateur mobile</h1>
        <p>Vue d'ensemble et accès aux modules de gestion.</p>
    </header>

    <main class="layout">
        <section class="stats" aria-label="Indicateurs clés">
            <article class="stat"><div class="stat-label">Clients</div><div class="stat-value"><?= number_format($totalClients, 0, ',', ' ') ?></div></article>
            <article class="stat"><div class="stat-label">Solde total</div><div class="stat-value"><?= number_format($soldeTotal, 0, ',', ' ') ?> FCFA</div></article>
            <article class="stat"><div class="stat-label">Transactions</div><div class="stat-value"><?= number_format($totalTransactions, 0, ',', ' ') ?></div></article>
            <article class="stat"><div class="stat-label">Gains (frais)</div><div class="stat-value"><?= number_format($totalGains, 0, ',', ' ') ?> FCFA</div></article>
        </section>

        <h2>Modules d'administration</h2>
        <section class="modules" aria-label="Modules d'administration">
            <a class="module" href="<?= site_url('admin/baremes') ?>"><span class="icon">📊</span><span><h3>Barèmes</h3><p><?= esc((string) $totalBaremes) ?> tranche(s) tarifaire(s) configurée(s).</p></span><span class="arrow">→</span></a>
            <a class="module" href="<?= site_url('admin/prefixes') ?>"><span class="icon">📞</span><span><h3>Préfixes</h3><p><?= esc((string) $totalPrefixes) ?> préfixe(s) téléphonique(s) enregistré(s).</p></span><span class="arrow">→</span></a>
            <a class="module" href="<?= site_url('admin/transactions') ?>"><span class="icon">📈</span><span><h3>Transactions</h3><p>Consulter les opérations, les filtres et les gains.</p></span><span class="arrow">→</span></a>
            <a class="module" href="<?= site_url('admin/clients') ?>"><span class="icon">👥</span><span><h3>Clients</h3><p>Consulter les soldes et l'historique de chaque client.</p></span><span class="arrow">→</span></a>
        </section>
    </main>
</body>
</html>
