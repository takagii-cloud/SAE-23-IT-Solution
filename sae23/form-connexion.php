<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('asset/img/switch2.png') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #030E0C;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
            position: relative;
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .logo {
            position: absolute;
            top: -60px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 120px;
            background: url('asset/img/logo2.png') no-repeat center center;
            background-size: cover;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-top: 80px;
            margin-bottom: 20px;
            color: #030E0C;
            font-size: 28px;
            border-bottom: 2px solid #30D5A8;
            padding-bottom: 10px;
        }
        .info {
            background-color: #30D5A8;
            color: #F4FDFA;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .form-connexion {
            margin-top: 20px;
        }
        .form-connexion form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .form-connexion label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #030E0C;
            width: 100%;
            text-align: left;
        }
        .form-connexion .input-group {
            position: relative;
            width: 100%;
        }
        .form-connexion .input-group i {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #30D5A8;
        }
        .form-connexion input[type="text"],
        .form-connexion input[type="password"] {
            padding: 12px 12px 12px 35px;
            margin-bottom: 15px;
            border: 1px solid #30D5A8;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .form-connexion input[type="text"]:focus,
        .form-connexion input[type="password"]:focus {
            border-color: #B18AE7;
            box-shadow: 0 0 10px rgba(177, 138, 231, 0.5);
            outline: none;
        }
        .form-connexion input[type="submit"] {
            background-color: #30D5A8;
            color: #F4FDFA;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            box-sizing: border-box;
            transition: background-color 0.3s, transform 0.3s;
        }
        .form-connexion input[type="submit"]:hover {
            background-color: #B18AE7;
            transform: translateY(-2px);
        }
        .password-tips {
            font-size: 12px;
            color: #030E0C;
            text-align: left;
            margin-top: -10px;
            margin-bottom: 20px;
        }
        .support {
            margin-top: 20px;
            font-size: 14px;
            color: #030E0C;
        }
        footer {
            margin-top: 20px;
            font-size: 12px;
            color: #030E0C;
        }
        footer p {
            margin: 5px 0;
        }
        footer a {
            color: #30D5A8;
            text-decoration: none;
            font-weight: bold;
        }
        footer a:hover {
            color: #B18AE7;
        }
    </style>
    <!-- Inclusion des icônes FontAwesome pour les icônes dans les champs de texte -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="logo"></div>
        <h1>Connexion</h1>
        <div class="info">
            Bienvenue! Veuillez vous connecter pour accéder à votre tableau de bord.
        </div>
        <div class='form-connexion'>
            <form action='connexion.php' method='post'>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <label for='login'>Identifiant :</label>
                    <input type='text' id='login' name='login' required>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <label for='password'>Mot de passe :</label>
                    <input type='password' id='password' name='password' required>
                </div>
                <input type='submit' value='Se connecter'>
            </form>
        </div>
        <div class="support">
            Besoin d'aide ? <a href="mailto:support@ipam.com">Contactez le support</a>
        </div>
        <footer>
            <p>&copy; 2024 Ibouchdken Mohamad, Taha Adam</p>
        </footer>
    </div>
</body>
</html>
