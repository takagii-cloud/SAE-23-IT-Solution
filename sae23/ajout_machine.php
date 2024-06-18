<?php
include_once 'fonctions.php';
demarrerSession();
redirectionSiNonConnecte($_SERVER['REQUEST_URI']);

$message = '';
$lien_de_retour = 'menu_client.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom_machine = $_POST['nom_machine'] ?? null;
    $piece = $_POST['piece'] ?? null;
    $id_client = $_SESSION['id_client'];  // Utiliser l'identifiant du client stocké dans la session

    if ($nom_machine && $piece) {
        $conn = ConnexionBD();

        // Vérifier le nombre de machines existantes pour le client
        $requete_compte = "SELECT COUNT(*) as machine_count FROM Machines WHERE id_client = :id_client";
        $stmt_count = $conn->prepare($requete_compte);
        $stmt_count->execute([':id_client' => $id_client]);
        $resultat = $stmt_count->fetch(PDO::FETCH_ASSOC);

        if ($resultat['machine_count'] >= 14) {
            $message = "Le nombre maximum d'adresse IP pour votre réseau a été atteint, si vous avez besoin d'adresses IP supplémentaires pour vos machines, merci de revenir vers nous.";
        } else {
            // Récupérer les informations du client
            $requete_client = "SELECT adresse_reseau FROM Clients WHERE id_client = :id_client";
            $stmt_client = $conn->prepare($requete_client);
            $stmt_client->execute([':id_client' => $id_client]);
            $client = $stmt_client->fetch(PDO::FETCH_ASSOC);

            // Vérifiez si le client existe
            if (!$client) {
                $message = "Client non trouvé.";
            } else {
                // Calculer la première adresse IP disponible
                $base_ip = substr($client['adresse_reseau'], 0, strrpos($client['adresse_reseau'], '.') + 1);
                $premiere_ip = (int)substr($client['adresse_reseau'], strrpos($client['adresse_reseau'], '.') + 1);
                $ip_trouvée = false;

                for ($i = $premiere_ip + 1; $i < $premiere_ip + 15; $i++) {
                    $verif_ip = $base_ip . $i;
                    $requete_verif_ip = "SELECT COUNT(*) as ip_count FROM Machines WHERE adresse_ip = :adresse_ip";
                    $stmt_verif_ip = $conn->prepare($requete_verif_ip);
                    $stmt_verif_ip->execute([':adresse_ip' => $verif_ip]);
                    $resultat_ip = $stmt_verif_ip->fetch(PDO::FETCH_ASSOC);

                    if ($resultat_ip['ip_count'] == 0) {
                        $adresse_ip = $verif_ip;
                        $ip_trouvée = true;
                        break;
                    }
                }

                if (!$ip_trouvée) {
                    $message = "Aucune adresse IP disponible pour ce client.";
                } else {
                    // Insertion de la nouvelle machine
                    $requete_machine = "INSERT INTO Machines (id_client, nom_machine, adresse_ip, piece) VALUES (:id_client, :nom_machine, :adresse_ip, :piece)";
                    $stmt_machine = $conn->prepare($requete_machine);
                    $stmt_machine->execute([
                        ':id_client' => $id_client,
                        ':nom_machine' => $nom_machine,
                        ':adresse_ip' => $adresse_ip,
                        ':piece' => $piece
                    ]);

                    $message = "Nouvelle machine ajoutée avec succès.";
                    $lien_de_retour = 'menu_client.php';
                }
            }
        }
    } else {
        $message = "Les informations fournies sont invalides ou incomplètes.";
    }
} else {
    header('Location: menu_client.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat de l'ajout de machine</title>
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
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #30D5A8;
            color: #F4FDFA;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
        }
        a:hover {
            background-color: #B18AE7;
            transform: translateY(-2px);
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
        <h1>Résultat de l'ajout de machine</h1>
        <p><?php echo htmlspecialchars($message); ?></p>
        <a href="<?php echo htmlspecialchars($lien_de_retour); ?>">Retour</a>
        <footer>&copy; 2024 Ibouchdken Mohamad, Taha Adam</footer>
    </div>
</body>
</html>
