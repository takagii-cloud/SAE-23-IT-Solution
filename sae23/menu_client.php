<?php
include_once 'fonctions.php';
demarrerSession();
redirectionSiNonConnecte($_SERVER['REQUEST_URI']);

$conn = ConnexionBD();
$id_client = $_SESSION['id_client'];  // Utiliser l'identifiant du client stocké dans la session

// Récupérer les informations sur le VLAN et l'adresse réseau du client
$requete_info = "SELECT C.adresse_reseau, V.nom_vlan FROM Clients C
                 JOIN VLANs V ON C.ID_Client = V.ID_Client 
                 WHERE C.ID_Client = :id_client";
$stmt_info = ExecuteBD($conn, $requete_info, [':id_client' => $id_client]);
$info_client = $stmt_info->fetch(PDO::FETCH_ASSOC);

// Gérer le cas où les informations du VLAN ou de l'adresse réseau ne sont pas trouvées
$nom_vlan = isset($info_client['nom_vlan']) ? $info_client['nom_vlan'] : 'Non spécifié';
$adresse_reseau = isset($info_client['adresse_reseau']) ? $info_client['adresse_reseau'] : 'Non spécifié';

$requete = "SELECT * FROM Machines WHERE id_client = :id_client";
$stmt = ExecuteBD($conn, $requete, [':id_client' => $id_client]);
$resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord client</title>
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
            width: 80%;
            max-width: 1000px;
            text-align: center;
            position: relative;
            animation: fadeIn 1s ease-in-out;
            overflow-y: auto;
            max-height: 80vh;
        }
        .logo {
            margin-top: -35px;
            margin-left: 450px;
            width: 100px;
            height: 100px;
            background: url('asset/img/logo2.png') no-repeat center center;
            background-size: cover;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #030E0C;
            font-size: 24px;
            border-bottom: 2px solid #30D5A8;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .table-container {
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #30D5A8;
            text-align: left;
        }
        th {
            background-color: #30D5A8;
            color: #F4FDFA;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        form label {
            font-weight: bold;
            color: #030E0C;
            margin-top: 10px;
            margin-bottom: 5px;
            align-self: flex-start;
        }
        form input[type="text"],
        form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #30D5A8;
            border-radius: 5px;
            box-sizing: border-box;
        }
        form input[type="submit"] {
            background-color: #30D5A8;
            color: #F4FDFA;
            cursor: pointer;
            font-weight: bold;
            margin-top: 20px;
            transition: background-color 0.3s, transform 0.3s;
        }
        form input[type="submit"]:hover {
            background-color: #B18AE7;
            transform: translateY(-2px);
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
    </style>
</head>
<body>
    <div class="container">
        <div class="logo"></div>
        <h1>Tableau de bord client</h1>
        <p>Vous êtes dans le <?= htmlspecialchars($nom_vlan) ?>, l'adresse réseau est <?= htmlspecialchars($adresse_reseau) ?></p>
        <h2>Liste des machines</h2>
        <div class="table-container">
            <?php
            if (count($resultat) > 0) {
                echo "<table>";
                echo "<tr><th>Nom de la machine</th><th>Adresse IP</th><th>Pièce</th><th>Actions</th></tr>";
                foreach ($resultat as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['nom_machine']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['adresse_ip']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['piece']) . "</td>";
                    echo "<td><a href='suppression_machine.php?id_machine=" . $row['id_machine'] . "' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette machine ?\");'>Supprimer</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Aucune machine trouvée.</p>";
            }
            ?>
        </div>
        <h2>Ajouter une nouvelle machine</h2>
        <form action="ajout_machine.php" method="post">
            <label for="nom_machine">Nom de la machine :</label>
            <input type="text" id="nom_machine" name="nom_machine" required>
            <label for="piece">Pièce :</label>
            <input type="text" id="piece" name="piece" required>
            <input type="submit" value="Ajouter la machine">
        </form>
        <a href="deconnexion.php">Déconnexion</a>
    </div>
</body>
</html>
