<?php
// Inclure le fichier de configuration de la base de données
include('config.php');

// Vérifier si l'utilisateur est connecté en tant qu'administrateur
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Récupérer la liste des utilisateurs depuis la base de données
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Utilisateurs</title>
</head>
<body>
    <h2>Gérer les Utilisateurs</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom d'Utilisateur</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Action</th>
        </tr>
        <?php
        // Afficher les utilisateurs dans un tableau
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['username']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['role']}</td>";
            echo "<td><a href='delete_user.php?id={$row['id']}'>Supprimer</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>