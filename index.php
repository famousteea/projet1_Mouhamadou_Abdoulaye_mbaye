<?php
// Inclure le fichier de configuration de la base de données et d'autres fichiers nécessaires
include('config.php');

// Commencer la session (pour vérifier si l'utilisateur est connecté, etc.)
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Votre Plateforme E-commerce</title>
    <!-- Vous pouvez inclure ici des liens vers des fichiers CSS, des scripts, etc. -->
</head>
<body>

    <header>
        <h1>Plateforme E-commerce</h1>
        <!-- Ajouter d'autres éléments d'en-tête si nécessaire -->
    </header>

    <nav>
        <!-- Ajouter la navigation, liens vers d'autres pages, etc. -->
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="browse_products.php">Parcourir les Produits</a></li>
            <li><a href="cart.php">Panier</a></li>
            <?php
            // Afficher des liens différents pour les utilisateurs connectés et les administrateurs
            if (isset($_SESSION['id'])) {
                echo '<li><a href="profile.php">Mon Profil</a></li>';
                echo '<li><a href="logout.php">Déconnexion</a></li>';
            } else {
                echo '<li><a href="login.php">Connexion</a></li>';
                echo '<li><a href="register.php">Inscription</a></li>';
            }

            // Afficher des liens d'administration pour les administrateurs
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                echo '<li><a href="admin/">Administration</a></li>';
            }
            ?>
        </ul>
    </nav>

    <main>
        <h2>Nouveaux Produits</h2>
        <!-- Ajouter ici la logique pour afficher les nouveaux produits -->
        <!-- Vous pouvez utiliser des boucles pour afficher plusieurs produits -->
    </main>

    <footer>
        <!-- Ajouter le pied de page si nécessaire -->
    </footer>

</body>
</html>