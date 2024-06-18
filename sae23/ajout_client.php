<?php
include_once 'fonctions.php';
demarrerSession();
redirectionSiNonConnecte($_SERVER['REQUEST_URI']);

$message = '';
$lien_de_retour = 'form-ajout-client.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom_client = $_POST['nom_client'] ?? null;
    $login = $_POST['login'] ?? null;
    $mdp = $_POST['mdp'] ?? null;
    $email_client = $_POST['email_client'] ?? null;
    $id_site = $_SESSION['id_site'];

    if ($nom_client && $login && $mdp && $email_client && $id_site) {
        $conn = ConnexionBD();

        // Vérifier si le login existe déjà
        $requete_verif_login = "SELECT COUNT(*) as user_count FROM util WHERE login = :login";
        $stmt_verif_login = $conn->prepare($requete_verif_login);
        $stmt_verif_login->execute([':login' => $login]);
        $resultat = $stmt_verif_login->fetch(PDO::FETCH_ASSOC);

        if ($resultat['user_count'] > 0) {
            $message = "Erreur : Un utilisateur avec ce login existe déjà.";
        } else {
            // Récupérer les ID clients existants pour le site donné
            $requete_id_existants = "SELECT id_client FROM Clients WHERE id_site = :id_site";
            $stmt_id_existants = $conn->prepare($requete_id_existants);
            $stmt_id_existants->execute([':id_site' => $id_site]);
            $id_existants = $stmt_id_existants->fetchAll(PDO::FETCH_COLUMN);

            // Base IP et VLAN par groupe
            $base_ip = [
                1 => '164.166.1.',
                2 => '164.166.2.',
                3 => '164.166.3.'
            ];

            $base_vlan = [
                1 => 10,
                2 => 30,
                3 => 50
            ];

            // Limite supérieure de la plage d'adresses pour chaque site
            $limite_ip = [
                1 => 240,
                2 => 240,
                3 => 240
            ];

            // Calcul de l'identifiant client, de l'adresse réseau et du VLAN ID pour le nouveau client
            $client_num = 1;
            while (in_array($base_vlan[$id_site] + $client_num - 1, $id_existants)) {
                $client_num++;
            }
            $id_client = $base_vlan[$id_site] + $client_num - 1;
            $vlan_id = $id_client;
            $adresse_reseau = $base_ip[$id_site] . (($client_num - 1) * 16);

            // Vérification de la limite supérieure de la plage d'adresses
            if ((($client_num - 1) * 16) > $limite_ip[$id_site]) {
                $message = "La plage d'adresses pour ce site a été atteinte. Impossible d'ajouter un nouveau client.";
            } else {
                // Calcul du Route Distinguisher
                $route_distinguisher = "65556:" . $vlan_id;

                // Insertion du client dans la base de données
                $requete_client = "INSERT INTO Clients (id_site, nom_client, id_client, adresse_reseau, route_distinguisher, email_client, login, mdp) 
                                 VALUES (:id_site, :nom_client, :id_client, :adresse_reseau, :route_distinguisher, :email_client, :login, :mdp)";
                $stmt_client = $conn->prepare($requete_client);
                $stmt_client->execute([
                    ':id_site' => $id_site,
                    ':nom_client' => $nom_client,
                    ':id_client' => $id_client,
                    ':adresse_reseau' => $adresse_reseau,
                    ':route_distinguisher' => $route_distinguisher,
                    ':email_client' => $email_client,
                    ':login' => $login,
                    ':mdp' => $mdp
                ]);

                // Insertion du VLAN dans la base de données
                $requete_vlan = "INSERT INTO VLANs (id_client, nom_vlan) VALUES (:id_client, :nom_vlan)";
                $stmt_vlan = $conn->prepare($requete_vlan);
                $stmt_vlan->execute([
                    ':id_client' => $id_client,
                    ':nom_vlan' => 'VLAN' . $vlan_id
                ]);

                // Insertion des informations de connexion du client dans la table util
                $requete_util = "INSERT INTO util (nom_util, prenom_util, login, mdp, categorie, id_site) VALUES (:nom_client, :prenom_client, :login, :mdp, 'Client', :id_site)";
                $stmt_util = $conn->prepare($requete_util);
                $stmt_util->execute([
                    ':nom_client' => $nom_client,
                    ':prenom_client' => '',  // Ajoutez un champ pour le prénom si nécessaire
                    ':login' => $login,
                    ':mdp' => $mdp,
                    ':id_site' => $id_site
                ]);

                $message = "Nouveau client ajouté avec succès.";
                $lien_de_retour = 'menu.php';
            }
        }
    } else {
        $message = "Les informations fournies sont invalides ou incomplètes.";
    }
} else {
    header('Location: form-ajout-client.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat de l'ajout de client</title>
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
        <h1>Résultat de l'ajout de client</h1>
        <p><?php echo htmlspecialchars($message); ?></p>
        <a href="<?php echo htmlspecialchars($lien_de_retour); ?>">Retour</a>
        <footer>&copy; 2024 Ibouchdken Mohamad, Taha Adam</footer>
    </div>
</body>
</html>
