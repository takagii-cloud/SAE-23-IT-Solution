<?php
include_once 'fonctions.php';
demarrerSession();
redirectionSiNonConnecte($_SERVER['REQUEST_URI']);

$conn = ConnexionBD();
$id_site = $_SESSION['id_site'];

$requete = "SELECT id_site AS \"Site\", nom_client AS \"Nom du client\", id_client AS \"ID client\", adresse_reseau AS \"Adresse Réseau(/28)\", route_distinguisher AS \"Route distinguisher\", email_client AS \"Email client\", login AS \"Nom d'utilisateur\", mdp AS \"Mot de Passe\" FROM Clients WHERE id_site = :id_site ORDER BY id_client ASC";
$stmt = ExecuteBD($conn, $requete, [':id_site' => $id_site]);
$resultats = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des clients</title>
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
            position: absolute;
            top: 0px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 100px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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
        a {
            display: inline-block;
            margin-top: 10px;
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
        <h1>Liste des clients</h1>
        <?php
        if (count($resultats) > 0) {
            echo "<table>";
            echo "<tr>";
            foreach ($resultats[0] as $key => $value) {
                echo "<th>" . htmlspecialchars($key) . "</th>";
            }
            echo "<th>Actions</th>";
            echo "</tr>";
            foreach ($resultats as $row) {
                echo "<tr>";
                foreach ($row as $key => $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
                if (isset($row['ID client'])) {
                    echo "<td><a href='suppression_client.php?id_client=" . $row['ID client'] . "' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce client ?\");'>Supprimer</a></td>";
                } else {
                    echo "<td>Erreur: ID Client non défini</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Aucun résultat trouvé.</p>";
        }
        ?>
        <a href="menu.php">Retour au menu principal</a>
    </div>
</body>
</html>
