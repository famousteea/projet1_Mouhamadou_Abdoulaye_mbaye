<?php
// Inclure le fichier de connexion à la base de données
include('config.php');

// Vérifier si l'utilisateur est connecté
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php'); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

// Récupérer les informations du profil de l'utilisateur depuis la base de données
$sql = 'SELECT id, username, email, nom, prenom, adresse FROM users WHERE id = ?';

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, 'i', $param_id);
    $param_id = $_SESSION['id'];

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $id, $username, $email, $nom, $prenom, $adresse);
            mysqli_stmt_fetch($stmt);
        } else {
            echo 'Erreur! Veuillez réessayer plus tard.';
            exit();
        }
    } else {
        echo 'Erreur! Veuillez réessayer plus tard.';
        exit();
    }

    mysqli_stmt_close($stmt);
}

// Si le formulaire de mise à jour est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_nom = $_POST['new_nom'];
    $new_prenom = $_POST['new_prenom'];
    $new_adresse = $_POST['new_adresse'];

    // Mettre à jour les informations du profil dans la base de données
    $update_sql = 'UPDATE users SET nom = ?, prenom = ?, adresse = ? WHERE id = ?';

    if ($update_stmt = mysqli_prepare($conn, $update_sql)) {
        mysqli_stmt_bind_param($update_stmt, 'sssi', $new_nom, $new_prenom, $new_adresse, $param_id);

        if (mysqli_stmt_execute($update_stmt)) {
            // Rediriger vers la page de profil après la mise à jour réussie
            header('Location: profile.php');
        } else {
            echo 'Erreur lors de la mise à jour du profil. Veuillez réessayer.';
        }

        mysqli_stmt_close($update_stmt);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <!-- Ajoutez ici les liens vers les feuilles de style et les scripts nécessaires -->
</head>

<body>
    <h2>Profil de <?php echo $username; ?></h2>
    <p>Nom d'utilisateur: <?php echo $username; ?></p>
    <p>Email: <?php echo $email; ?></p>

    <h3>Informations du profil</h3>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <label>Nom:</label>
        <input type="text" name="new_nom" value="<?php echo $nom; ?>">

        <label>Prénom:</label>
        <input type="text" name="new_prenom" value="<?php echo $prenom; ?>">

        <label>Adresse:</label>
        <input type="text" name="new_adresse" value="<?php echo $adresse; ?>">

        <input type="submit" value="Mettre à jour le profil">
    </form>

    <p><a href="logout.php">Se déconnecter</a></p>
</body>

</html>