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
            <th>image</th>
        </tr>
        <?php
        // Afficher la liste des produits
        while ($row = mysqli_fetch_assoc($result)) {
            var_dump($row);
            ?>
            <tr>
                <td><?php echo $row['id']?></td>
                <td><?php echo $row['name']?></td>
                <td><?php echo $row['product_price']?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</body>
</html>