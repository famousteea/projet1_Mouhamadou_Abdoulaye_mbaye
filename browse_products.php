<?php
// Inclure le fichier de configuration de la base de données
include('config.php');

// Récupérer la liste des produits depuis la base de données
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parcourir les Produits</title>
</head>
<body>
    <h2>Parcourir les Produits</h2>
    <table border="1">
        <tr>
            <th>ID du Produit</th>
            <th>Nom du Produit</th>
            <th>Prix du Produit</th>
        </tr>
        <?php
        // Afficher la liste des produits
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['product_id']}</td>";
            echo "<td>{$row['product_name']}</td>";
            echo "<td>{$row['product_price']}</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>