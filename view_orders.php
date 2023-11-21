<?php
// Inclure le fichier de configuration de la base de données
include('config.php');

// Vérifier si l'utilisateur est connecté en tant qu'administrateur
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Récupérer la liste des commandes depuis la base de données
$sql = "SELECT * FROM orders";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualiser les Commandes</title>
</head>
<body>
    <h2>Visualiser les Commandes</h2>
    <table border="1">
        <tr>
            <th>ID de la Commande</th>
            <th>ID du Client</th>
            <th>Date de Commande</th>
            <th>Total</th>
        </tr>
        <?php
        // Afficher les commandes dans un tableau
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['order_id']}</td>";
            echo "<td>{$row['customer_id']}</td>";
            echo "<td>{$row['order_date']}</td>";
            echo "<td>{$row['total']}</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>