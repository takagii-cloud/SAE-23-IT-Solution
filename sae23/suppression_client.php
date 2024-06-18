<?php
include_once 'fonctions.php';
demarrerSession();
redirectionSiNonConnecte($_SERVER['REQUEST_URI']);

$message = '';
$lien_de_retour = 'liste_clients.php';

$conn = ConnexionBD();
$id_client = $_GET['id_client'] ?? '';

if ($id_client) {
    // Vérifiez si le client existe
    $requete_verif_client = "SELECT * FROM Clients WHERE id_client = :id_client";
    $stmt_verif_client = $conn->prepare($requete_verif_client);
    $stmt_verif_client->execute([':id_client' => $id_client]);

    if ($stmt_verif_client->rowCount() > 0) {
        // Si le client existe, supprimer d'abord les enregistrements liés dans Machines
        $requete_suppression_machines = "DELETE FROM Machines WHERE id_client = :id_client";
        $stmt_suppression_machiness = $conn->prepare($requete_suppression_machines);
        $stmt_suppression_machiness->execute([':id_client' => $id_client]);

        // Supprimer les enregistrements liés dans VLANs
        $requete_suppression_vlans = "DELETE FROM VLANs WHERE id_client = :id_client";
        $stmt_suppression_vlans = $conn->prepare($requete_suppression_vlans);
        $stmt_suppression_vlans->execute([':id_client' => $id_client]);

        // Supprimer les enregistrements liés dans AdressesIP
        $requete_suppression_ip = "DELETE FROM AdressesIP WHERE id_client = :id_client";
        $stmt_suppression_ip = $conn->prepare($requete_suppression_ip);
        $stmt_suppression_ip->execute([':id_client' => $id_client]);

        // Supprimer les enregistrements liés dans util
        $requete_suppression_util = "DELETE FROM util WHERE login = (SELECT login FROM Clients WHERE id_client = :id_client)";
        $stmt_suppression_util = $conn->prepare($requete_suppression_util);
        $stmt_suppression_util->execute([':id_client' => $id_client]);

        // Puis supprimer le client
        $requete_suppression_client = "DELETE FROM Clients WHERE id_client = :id_client";
        $stmt_suppression_client = $conn->prepare($requete_suppression_client);
        $stmt_suppression_client->execute([':id_client' => $id_client]);

        $message = "Client supprimé avec succès.";
    } else {
        $message = "Erreur : Client introuvable.";
    }
} else {
    $message = "Aucun client spécifié.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat de la suppression de client</title>
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
        <h1>Résultat de la suppression de client</h1>
        <p><?php echo htmlspecialchars($message); ?></p>
        <a href="<?php echo htmlspecialchars($lien_de_retour); ?>">Retour</a>
        <footer>&copy; 2024 Ibouchdken Mohamad, Taha Adam</footer>
    </div>
</body>
</html>
