<?php
include 'fonctions.php';
demarrerSession();
redirectionSiNonConnecte($_SERVER['REQUEST_URI']);

echo '<!DOCTYPE html>';
echo '<html lang="fr">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<title>Ajouter une machine</title>';
echo '</head>';
echo '<body>';
echo '<h1>Ajouter une machine</h1>';
echo '<form action="ajout_machine.php" method="post">';
echo '<div>';
echo '<label for="adresse_ip">Adresse IP :</label>';
echo '<input type="text" id="adresse_ip" name="adresse_ip" required>';
echo '</div>';
echo '<div>';
echo '<label for="piece">Pièce :</label>';
echo '<input type="text" id="piece" name="piece" required>';
echo '</div>';
echo '<div>';
echo '<input type="submit" value="Ajouter la machine">';
echo '</div>';
echo '</form>';
echo '<a href="client_dashboard.php">Retour au tableau de bord</a>';
echo '</body>';
echo '</html>';
?>
