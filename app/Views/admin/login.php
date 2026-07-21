<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .login-card .card-body {
            padding: 2.5rem;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-logo .icon {
            font-size: 3rem;
        }
        .login-logo h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1a1a2e;
            margin-top: 0.5rem;
        }
        .login-logo p {
            color: #6b7280;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .btn-login {
            width: 100%;
            padding: 0.75rem;
            font-weight: 700;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="card login-card">
        <div class="card-body">
            <div class="login-logo">
                <div class="icon">🔐</div>
                <h1>Administration</h1>
                <p>Connectez-vous pour gérer la plateforme</p>
            </div>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger d-flex align-items-center gap-2" role="alert">
                    <span>❌</span>
                    <span><?= session('error') ?></span>
                </div>
            <?php endif; ?>

            <form action="/admin/login/authentifier" method="post">
                <div class="mb-3">
                    <label for="identifiant" class="form-label fw-semibold">Identifiant</label>
                    <input type="text" class="form-control form-control-lg" id="identifiant" name="identifiant" placeholder="admin" required autocomplete="username">
                </div>
                <div class="mb-4">
                    <label for="mot_de_passe" class="form-label fw-semibold">Mot de passe</label>
                    <input type="password" class="form-control form-control-lg" id="mot_de_passe" name="mot_de_passe" placeholder="••••••••" required autocomplete="current-password">
                </div>
                <button type="submit" class="btn btn-primary btn-login btn-lg">Se connecter</button>
            </form>

            <a href="/" class="d-block text-center mt-4 text-decoration-none text-secondary small">← Retour à l'accueil client</a>
        </div>
    </div>
</body>
</html>

