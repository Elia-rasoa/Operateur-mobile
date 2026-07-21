<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
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
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .login-card .logo {
            text-align: center;
            margin-bottom: 32px;
        }
        .login-card .logo .icon {
            font-size: 48px;
        }
        .login-card .logo h1 {
            font-size: 24px;
            font-weight: 800;
            color: #1a1a2e;
            margin-top: 8px;
        }
        .login-card .logo p {
            color: #6b7280;
            font-size: 14px;
            margin-top: 4px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }
        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 15px;
            outline: none;
            transition: all 0.2s;
        }
        .form-group input:focus {
            border-color: #4361ee;
            box-shadow: 0 0 0 3px rgba(67,97,238,0.1);
        }
        .btn-login {
            width: 100%;
            padding: 14px;
            background: #4361ee;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-login:hover { background: #3651d9; }
        .message {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
            font-size: 14px;
            text-align: center;
        }
        .message.error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
        }
        .back-link:hover { color: #4361ee; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">
            <div class="icon">🔐</div>
            <h1>Administration</h1>
            <p>Connectez-vous pour gérer la plateforme</p>
        </div>

        <?php if (session()->has('error')): ?>
            <div class="message error"><?= session('error') ?></div>
        <?php endif; ?>

        <form action="/admin/login/authentifier" method="post">
            <div class="form-group">
                <label for="identifiant">Identifiant</label>
                <input type="text" id="identifiant" name="identifiant" placeholder="admin" required autocomplete="username">
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="••••••••" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn-login">Se connecter</button>
        </form>

        <a href="/" class="back-link">← Retour à l'accueil client</a>
    </div>
</body>
</html>
