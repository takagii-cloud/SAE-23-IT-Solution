<?php
include 'fonctions.php';
redirectionSiNonConnecte($_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Menu Principal</title>
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
        .menu {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.3);
            width: 420px;
            text-align: center;
        }
        h1 {
            margin-bottom: 25px;
            color: #030E0C;
            font-size: 26px;
            border-bottom: 3px solid #30D5A8;
            padding-bottom: 15px;
        }
        p {
            margin-top: 25px;
            color: #030E0C;
            font-size: 16px;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 25px 0;
        }
        .menu-item {
            display: block;
            padding: 12px;
            margin: 12px 0;
            background-color: #30D5A8;
            color: #F4FDFA;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .menu-item:hover {
            background-color: #B18AE7;
        }
        footer {
            margin-top: 30px;
            font-size: 14px;
            color: #030E0C;
        }
    </style>
</head>
<body>
    <div class="menu">
        <h1>Menu Principal</h1>
        <p>Vous êtes connecté en tant que <?php echo htmlspecialchars($_SESSION['login']); ?>.</p>
        <ul>
            <li><a class="menu-item" href="form-ajout-client.php">Ajout d'un client</a></li>
            <li><a class="menu-item" href="liste_clients.php">Liste des clients</a></li>
            <li><a class="menu-item" href="deconnexion.php">Déconnexion</a></li>
        </ul>
        <footer>&copy; 2024 Ibouchdken Mohamad, Taha Adam</footer>
    </div>
</body>
</html>
