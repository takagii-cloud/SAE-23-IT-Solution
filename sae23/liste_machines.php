<?php
include 'fonctions.php';
demarrerSession();
redirectionSiNonConnecte($_SERVER['REQUEST_URI']);

$id_client = $_SESSION['id_util']; // ID du client connecté

$conn = ConnexionBD();
$requete = "SELECT * FROM Machines WHERE id_client = :id_client";
$stmt = ExecuteBD($conn, $requete, [':id_client' => $id_client]);

echo '<!DOCTYPE html>';
echo '<html lang="fr">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<title>Liste des machines</title>';
echo '</head>';
echo '<body>';
echo '<h1>Liste des machines</h1>';

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (count($results) > 0) {
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Adresse IP</th>";
    echo "<th>Pièce</th>";
    echo "</tr>";
    foreach ($results as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['adresse_ip']) . "</td>";
        echo "<td>" . htmlspecialchars($row['piece']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Aucune machine trouvée.";
}

echo '<a href="client_dashboard.php">Retour au tableau de bord</a>';
echo '</body>';
echo '</html>';
?>
