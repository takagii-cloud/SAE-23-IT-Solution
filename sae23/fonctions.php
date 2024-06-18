<?php

function ConnexionBD() {
    $hote = 'localhost';
    $nom_bdd = 'postgres';
    $utilisateur = 'postgres';
    $mdp = 'takagii';

    try {
        $conn = new PDO("pgsql:host=$hote;dbname=$nom_bdd", $utilisateur, $mdp);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die('Erreur de connexion: ' . $e->getMessage());
    }
}

function ExecuteBD($conn, $query, $params = array()) {
    try {
        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        die('Erreur d\'exécution : ' . $e->getMessage());
    }
}

function AfficheResultat($stmt) {
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($resultats) > 0) {
        echo "<table border='1'>";
        echo "<tr>";
        foreach ($resultats[0] as $key => $value) {
            echo "<th>" . htmlspecialchars($key) . "</th>";
        }
        echo "</tr>";
        foreach ($resultats as $row) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Aucun résultat trouvé.";
    }
}

function demarrerSession() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

function redirectionSiNonConnecte($uri) {
    demarrerSession();
    if (!isset($_SESSION['login']) && !strpos($uri, 'connexion.php')) {
        header('Location: form-connexion.php');
        exit;
    }
}

function verifierDroitsAcces($id_site_utilisateur, $id_site_cible) {
    return $id_site_utilisateur == $id_site_cible;
}

?>
