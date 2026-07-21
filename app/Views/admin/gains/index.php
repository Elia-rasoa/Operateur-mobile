<div class="info-box">
    <strong>🔍 Analyse des revenus :</strong><br>
    <strong>Gains internes</strong> → Frais sur les transactions entre clients du même réseau.<br>
    <strong>Gains externes</strong> → Frais sur les transactions vers d'autres opérateurs.<br>
    <strong>Commission interconnexion</strong> → Pourcentage supplémentaire appliqué aux transactions externes.
</div>

<!-- Filtres -->
<div class="card shadow-sm border-0 rounded-3 p-4 mb-4">
    <h3 class="h5 fw-bold mb-3">🔍 Filtrer par période</h3>
    <form action="/admin/gains" method="get">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <div class="form-group mb-0">
                    <label for="date_debut" class="form-label small fw-semibold">Date début</label>
                    <input type="date" name="date_debut" id="date_debut" class="form-control" value="<?= esc($date_debut ?? '') ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-0">
                    <label for="date_fin" class="form-label small fw-semibold">Date fin</label>
                    <input type="date" name="date_fin" id="date_fin" class="form-control" value="<?= esc($date_fin ?? '') ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Filtrer</button>
                    <a href="/admin/gains" class="btn btn-outline-secondary text-decoration-none">Réinitialiser</a>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Cartes gains -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card" style="border-top-color: #16a34a;">
            <div class="stat-label">🔵 Gains internes</div>
            <div class="stat-value" style="color:#16a34a;"><?= number_format($gainsInternes, 0, ',', ' ') ?> FCFA</div>
            <div class="stat-sub">Transactions entre clients du même réseau</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="border-top-color: #ea580c;">
            <div class="stat-label">🌍 Gains externes</div>
            <div class="stat-value" style="color:#ea580c;"><?= number_format($gainsExternes, 0, ',', ' ') ?> FCFA</div>
            <div class="stat-sub">Transactions vers d'autres opérateurs</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="border-top-color: #f59e0b;">
            <div class="stat-label">📈 Commission interconnexion</div>
            <div class="stat-value" style="color:#f59e0b;"><?= number_format($commissionInterconnexion, 0, ',', ' ') ?> FCFA</div>
            <div class="stat-sub">% supplémentaire sur transactions externes</div>
        </div>
    </div>
    <div class="col-12">
        <div class="stat-card" style="border-top-color: #4361ee;">
            <div class="stat-label">🏆 Total des gains</div>
            <div class="stat-value" style="color:#4361ee;"><?= number_format($totalGains, 0, ',', ' ') ?> FCFA</div>
        </div>
    </div>
</div>

