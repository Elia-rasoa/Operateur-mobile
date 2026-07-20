<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Money - Accès Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-sm" style="width: 400px; border-radius: 12px;">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary">Mobile Money</h3>
                    <p class="text-muted small">Accédez instantanément à votre compte</p>
                </div>
                
                <!-- Gestion des alertes d'erreurs -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger p-2 small text-center" role="alert">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('/login/authentifier') ?>" method="POST">
                    <div class="mb-4">
                        <label for="telephone" class="form-label font-weight-bold small text-secondary">Numéro de téléphone</label>
                        <input type="text" class="form-control form-control-lg" id="telephone" name="telephone" placeholder="Ex: 033XXXXXXXX" required autocomplete="off">
                        <div class="form-text text-muted" style="font-size: 0.8rem;">
                            Les nouveaux numéros valides seront enregistrés automatiquement.
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-medium shadow-sm">
                        Se connecter
                    </button>

                    <a href="<?= base_url('/admin') ?>" class="btn btn-outline-secondary btn-lg w-100 fw-medium mt-3">
                        Basculer vers admin
                    </a>
                </form>
            </div>
        </div>
    </div>

</body>
</html>