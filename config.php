<?php
// Paramètres de connexion à la base de données
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'votre_nom_utilisateur');
define('DB_PASSWORD', 'votre_mot_de_passe');
define('DB_NAME', 'nom_de_votre_base_de_donnees');

// Connexion à la base de données
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Vérifier la connexion
if (!$conn) {
    die("Échec de la connexion à la base de données : " . mysqli_connect_error());
}
?>