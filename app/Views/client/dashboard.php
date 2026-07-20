<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Money - Espace Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Mobile Money Client</a>
            <div class="d-flex align-items-center">
                <span class="navbar-text text-white me-3 d-none d-sm-inline">
                    En ligne : <strong><?= esc($client['numero_telephone'] ?? $client['telephone'] ?? '-') ?></strong>
                </span>
                <a href="<?= base_url('/client/historique') ?>" class="btn btn-sm btn-outline-light me-2">Historique</a>
                <a href="<?= base_url('/login/logout') ?>" class="btn btn-sm btn-outline-light">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row g-4">
            
            <!-- Carte Solde -->
            <div class="col-md-4">
                <div class="card text-white bg-success shadow-sm h-100" style="border-radius: 12px;">
                    <div class="card-body d-flex flex-column justify-content-center p-4">
                        <h6 class="text-uppercase mb-2 style-muted small text-white-50">Votre Solde Actuel</h6>
                        <h2 class="fw-bold mb-0">
                            <?= number_format($client['solde'], 2, ',', ' ') ?> <span class="fs-4">Ar</span>
                        </h2>
                    </div>
                </div>
            </div>

            <!-- Zone des Opérations -->
            <div class="col-md-8">
                <div class="card shadow-sm" style="border-radius: 12px;">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold text-secondary">Effectuer une opération</h5>
                    </div>
                    <div class="card-body p-4">
                        
                        <!-- Alertes Flash pour les futurs retours d'opérations -->
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success small" role="alert">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger small" role="alert">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <!-- Onglets pour basculer entre Dépôt, Retrait et Transfert -->
                        <nav>
                            <div class="nav nav-tabs mb-4" id="nav-tab" role="tablist">
                                <button class="nav-link active fw-medium" id="nav-depot-tab" data-bs-toggle="tab" data-bs-target="#nav-depot" type="button" role="tab">Dépôt</button>
                                <button class="nav-link fw-medium" id="nav-retrait-tab" data-bs-toggle="tab" data-bs-target="#nav-retrait" type="button" role="tab">Retrait</button>
                                <button class="nav-link fw-medium" id="nav-transfert-tab" data-bs-toggle="tab" data-bs-target="#nav-transfert" type="button" role="tab">Transfert</button>
                            </div>
                        </nav>

                        <div class="tab-content" id="nav-tabContent">
                            
                            <!-- Formulaire Dépôt -->
                            <div class="tab-pane fade show active" id="nav-depot" role="tabpanel">
                                <form action="<?= base_url('/client/transaction/depot') ?>" method="POST">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted">Montant à déposer (Ar)</label>
                                        <input type="number" name="montant" class="form-control" placeholder="Ex: 5000" required min="100">
                                    </div>
                                    <button type="submit" class="btn btn-success w-100">Confirmer le dépôt</button>
                                </form>
                            </div>

                            <!-- Formulaire Retrait -->
                            <div class="tab-pane fade" id="nav-retrait" role="tabpanel">
                                <form action="<?= base_url('/client/transaction/retrait') ?>" method="POST">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted">Montant à retirer (Ar)</label>
                                        <input type="number" name="montant" class="form-control" placeholder="Ex: 10000" required min="100">
                                    </div>
                                    <button type="submit" class="btn btn-danger w-100">Confirmer le retrait</button>
                                </form>
                            </div>

                            <!-- Formulaire Transfert -->
                            <div class="tab-pane fade" id="nav-transfert" role="tabpanel">
                                <form action="<?= base_url('/client/transaction/transfert') ?>" method="POST">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted">Numéro du destinataire</label>
                                        <input type="text" name="telephone_destinataire" class="form-control" placeholder="Ex: 033XXXXXXXX" required autocomplete="off">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted">Montant à transférer (Ar)</label>
                                        <input type="number" name="montant" class="form-control" placeholder="Ex: 2500" required min="100">
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Envoyer l'argent</button>
                                </form>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap Bundle JS (Obligatoire pour faire fonctionner les onglets/tabs) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>