<?php
// Inclure le fichier de connexion à la base de données
include('config.php');

// Initialiser les variables
$username = $password = '';
$username_err = $password_err = $login_err = '';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Valider le nom d'utilisateur
    if (empty(trim($_POST['username']))) {
        $username_err = 'Veuillez entrer votre nom d\'utilisateur.';
    } else {
        $username = trim($_POST['username']);
    }

    // Valider le mot de passe
    if (empty(trim($_POST['password']))) {
        $password_err = 'Veuillez entrer votre mot de passe.';
    } else {
        $password = trim($_POST['password']);
    }

    // Vérifier s'il n'y a pas d'erreurs avant de tenter la connexion
    if (empty($username_err) && empty($password_err)) {
        // Préparer la requête de sélection
        $sql = 'SELECT id, username, password FROM users WHERE username = ?';

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 's', $param_username);
            $param_username = $username;

            // Exécuter la requête préparée
            if (mysqli_stmt_execute($stmt)) {
                // Stocker le résultat
                mysqli_stmt_store_result($stmt);

                // Vérifier si le nom d'utilisateur existe, puis vérifier le mot de passe
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Authentification réussie, démarrer une nouvelle session
                            session_start();

                            // Stocker les données dans les variables de session
                            $_SESSION['id'] = $id;
                            $_SESSION['username'] = $username;

                            // Rediriger vers la page d'accueil ou autre page après la connexion réussie
                            header('location: home.php');
                        } else {
                            $login_err = 'Nom d\'utilisateur ou mot de passe incorrect.';
                        }
                    }
                } else {
                    $login_err = 'Nom d\'utilisateur ou mot de passe incorrect.';
                }
            } else {
                echo 'Erreur! Veuillez réessayer plus tard.';
            }

            // Fermer la déclaration
            mysqli_stmt_close($stmt);
        }
    }

    // Fermer la connexion
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <!-- Ajouter ici les liens vers les feuilles de style et les scripts nécessaires -->
</head>

<body>
    <h2>Connexion</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <label>Nom d'utilisateur:</label>
        <input type="text" name="username" value="<?php echo $username; ?>">
        <span><?php echo $username_err; ?></span>

        <label>Mot de passe:</label>
        <input type="password" name="password" value="<?php echo $password; ?>">
        <span><?php echo $password_err; ?></span>

        <input type="submit" value="Se connecter">
        <p><?php echo $login_err; ?></p>
        <p>Vous n'avez pas de compte? <a href="register.php">Inscrivez-vous ici</a>.</p>
    </form>
</body>

</html>