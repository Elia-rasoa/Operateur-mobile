<!-- Dashboard Stats -->
<section class="stats" aria-label="Indicateurs clés">
    <article class="stat"><div class="stat-label">Clients</div><div class="stat-value"><?= number_format($totalClients, 0, ',', ' ') ?></div></article>
    <article class="stat"><div class="stat-label">Solde total</div><div class="stat-value"><?= number_format($soldeTotal, 0, ',', ' ') ?> FCFA</div></article>
    <article class="stat"><div class="stat-label">Transactions</div><div class="stat-value"><?= number_format($totalTransactions, 0, ',', ' ') ?></div></article>
    <article class="stat"><div class="stat-label">Gains (frais)</div><div class="stat-value"><?= number_format($totalGains, 0, ',', ' ') ?> FCFA</div></article>
</section>

<!-- Mini résumé gains par réseau -->
<div class="gains-mini">
    <div class="item">
        <div class="item-label">🔵 Gains internes</div>
        <div class="item-value interne"><?= number_format($gainsInternes ?? 0, 0, ',', ' ') ?> FCFA</div>
    <div class="item">
        <div class="item-label">🌍 Gains externes</div>
        <div class="item-value externe"><?= number_format($gainsExternes ?? 0, 0, ',', ' ') ?> FCFA</div>
</div>

<h2>Modules d'administration</h2>
<section class="modules" aria-label="Modules d'administration">
    <a class="module" href="<?= site_url('admin/baremes') ?>">
        <span class="icon">📊</span>
        <span><h3>Barèmes</h3><p><?= esc((string) $totalBaremes) ?> tranche(s) tarifaire(s) configurée(s).</p></span>
        <span class="arrow">→</span>
    </a>
    <a class="module" href="<?= site_url('admin/prefixes') ?>">
        <span class="icon">📞</span>
        <span><h3>Préfixes & Opérateurs</h3><p><?= esc((string) $totalPrefixes) ?> opérateur(s) tiers enregistré(s).</p></span>
        <span class="arrow">→</span>
    </a>
    <a class="module" href="<?= site_url('admin/transactions') ?>">
        <span class="icon">📈</span>
        <span><h3>Transactions</h3><p>Consulter les opérations, les filtres et les gains.</p></span>
        <span class="arrow">→</span>
    </a>
    <a class="module" href="<?= site_url('admin/clients') ?>">
        <span class="icon">👥</span>
        <span><h3>Clients</h3><p>Consulter les soldes et l'historique de chaque client.</p></span>
        <span class="arrow">→</span>
    </a>
    <a class="module" href="<?= site_url('admin/gains') ?>">
        <span class="icon">💰</span>
        <span><h3>Situation des gains</h3><p>Analyse détaillée : gains internes, externes et commissions d'interconnexion.</p></span>
        <span class="arrow">→</span>
    </a>
    <a class="module" href="<?= site_url('admin/reversement') ?>">
        <span class="icon">🔄</span>
        <span><h3>Récapitulatif reversement</h3><p>Montants à reverser aux opérateurs tiers.</p></span>
        <span class="arrow">→</span>
    </a>
</section>
