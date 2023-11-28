<?php
// Inclure le fichier de configuration de la base de données et d'autres fichiers nécessaires
include('config.php');

// Démarrer la session
session_start();

// Détruire toutes les variables de session
$_SESSION = array();

// Effacer le cookie de session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Détruire la session
session_destroy();

// Rediriger vers la page d'accueil (ou toute autre page appropriée)
header('location: index.php');
exit();
?>
