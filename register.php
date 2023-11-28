<?php
// Inclure le fichier de connexion à la base de données
include('config.php');

// Initialiser les variables
$username = $password = $confirm_password = $email = '';
$username_err = $password_err = $confirm_password_err = $email_err = '';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Valider le nom d'utilisateur
    if (empty(trim($_POST['username']))) {
        $username_err = 'Veuillez entrer un nom d\'utilisateur.';
    } else {
        // Vérifier si le nom d'utilisateur existe déjà
        $sql = 'SELECT id FROM user WHERE user_name = ?';
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 's', $param_username);
            $param_username = trim($_POST['username']);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) > 0) {
                    $username_err = 'Ce nom d\'utilisateur est déjà pris.';
                } else {
                    $username = trim($_POST['username']);
                }
            } else {
                echo 'Erreur! Veuillez réessayer plus tard.';
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Valider le mot de passe
    if (empty(trim($_POST['password']))) {
        $password_err = 'Veuillez entrer un mot de passe.';
    } elseif (strlen(trim($_POST['password'])) < 6) {
        $password_err = 'Le mot de passe doit contenir au moins 6 caractères.';
    } else {
        $password = trim($_POST['password']);
    }

    // Valider la confirmation du mot de passe
    if (empty(trim($_POST['confirm_password']))) {
        $confirm_password_err = 'Veuillez confirmer le mot de passe.';
    } else {
        $confirm_password = trim($_POST['confirm_password']);
        if ($password != $confirm_password) {
            $confirm_password_err = 'Les mots de passe ne correspondent pas.';
        }
    }

    // Valider l'adresse e-mail
    if (empty(trim($_POST['email']))) {
        $email_err = 'Veuillez entrer une adresse e-mail.';
    } elseif (!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
        $email_err = 'Veuillez entrer une adresse e-mail valide.';
    } else {
        $email = trim($_POST['email']);
    }

    // Vérifier s'il n'y a pas d'erreurs avant d'insérer dans la base de données
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)) {
        // Préparer la requête d'insertion
        $sql = 'INSERT INTO user (user_name, pwd, email) VALUES ($username, $password, $email)';
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 'sss', $param_username, $param_password, $param_email);
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Hashage du mot de passe
            $param_email = $email;
            if (mysqli_stmt_execute($stmt)) {
                header(' login.php'); // Rediriger vers la page de connexion après l'inscription réussie
            } else {
                echo 'Erreur! Veuillez réessayer plus tard.';
            }
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
    <title>Inscription</title>
    <!-- Ajoutez ici vos liens vers les feuilles de style et scripts nécessaires -->
</head>

<body>
    <h2>Inscription</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <label>Nom d'utilisateur:</label>
        <input type="text" name="username" value="<?php echo $username; ?>">
        <span><?php echo $username_err; ?></span>

        <label>Mot de passe:</label>
        <input type="password" name="password" value="<?php echo $password; ?>">
        <span><?php echo $password_err; ?></span>

        <label>Confirmer le mot de passe:</label>
        <input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>">
        <span><?php echo $confirm_password_err; ?></span>

        <label>Adresse e-mail:</label>
        <input type="text" name="email" value="<?php echo $email; ?>">
        <span><?php echo $email_err; ?></span>

        <input type="submit" value="S'inscrire">
        <p>Vous avez déjà un compte? <a href="login.php">Connectez-vous ici</a>.</p>
    </form>
</body>

</html>