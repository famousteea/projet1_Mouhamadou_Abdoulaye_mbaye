<?php
// Paramètres de connexion à la base de données
$DB_SERVER= 'localhost';
$DB_USERNAME= 'root';
$DB_PASSWORD= '';
$DB_NAME= 'ecom1_project';

// Connexion à la base de données
$conn = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// Vérifier la connexion
if (!$conn) {
    die("Échec de la connexion à la base de données : " . mysqli_connect_error());
}
?>