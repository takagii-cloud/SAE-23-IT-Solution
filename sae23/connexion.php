<?php
include_once 'fonctions.php';
redirectionSiNonConnecte($_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Outil de Gestion des Adresses IP</title>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
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
            animation: fadeIn 1s ease-in-out;
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
        p {
            margin-top: 20px;
            color: #030E0C;
            font-size: 16px;
        }
        a {
            color: #30D5A8;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            color: #B18AE7;
            text-decoration: underline;
        }
        footer {
            margin-top: 20px;
            font-size: 12px;
            color: #030E0C;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo"></div>
        <h1>Outil de Gestion des Adresses IP</h1>
        <?php
        include_once 'fonctions.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';

            $conn = ConnexionBD();

            $requete = "SELECT * FROM util WHERE login = :login AND mdp = :password";
            $stmt = $conn->prepare($requete);
            $stmt->bindParam(':login', $login);
            $stmt->bindParam(':password', $password);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                demarrerSession();
                $_SESSION['id_util'] = $user['id_util'];
                $_SESSION['nom_util'] = $user['nom_util'];
                $_SESSION['login'] = $login;
                $_SESSION['categorie'] = $user['categorie'];
                $_SESSION['id_site'] = $user['id_site'];

                // Si l'utilisateur est un client, récupérez l'identifiant du client correspondant
                if ($user['categorie'] === 'Client') {
                    $requete_client = "SELECT id_client FROM Clients WHERE login = :login";
                    $stmt_client = $conn->prepare($requete_client);
                    $stmt_client->execute([':login' => $login]);
                    $client = $stmt_client->fetch(PDO::FETCH_ASSOC);
                    if ($client) {
                        $_SESSION['id_client'] = $client['id_client'];
                    } else {
                        echo "<p>Client non trouvé.</p>";
                        exit;
                    }
                }

                if ($user['categorie'] === 'Administrateur') {
                    echo "<p>Bonjour, vous êtes connecté en tant que " . htmlspecialchars($_SESSION['nom_util']) . ", vous avez la possibilité d'ajouter des clients et de consulter la liste des clients sur votre site.</p>";
                    echo "<p><a href='menu.php'>Accéder au menu de gestion</a></p>";
                } elseif ($user['categorie'] === 'Client') {
                    echo "<p>Bonjour, vous êtes connecté en tant que " . htmlspecialchars($_SESSION['nom_util']) . ", vous avez la possibilité d'ajouter des clients et d'adresser jusqu'à 14 machines au sein de votre VLAN.</p>";
                    echo "<p><a href='menu_client.php'>Accéder à votre tableau de bord</a></p>";
                }
            } else {
                echo "<p>Login ou mot de passe incorrect.</p>";
                echo "<p><a href='form-connexion.php'>Retourner au formulaire de connexion</a></p>";
            }
        } else {
            header('Location: form-connexion.php');
            exit;
        }
        ?>
        <footer>&copy; 2024 Mohamad Ibouchdken, Taha Adam</footer>
    </div>
</body>
</html>
