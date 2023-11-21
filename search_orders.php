<?php
// Inclure le fichier de configuration de la base de données
include('config.php');

// Vérifier si l'utilisateur est connecté en tant qu'administrateur
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Initialiser la variable de référence de commande
$orderRef = '';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer la référence de commande depuis le formulaire
    $orderRef = $_POST['order_ref'];

    // Requête SQL pour rechercher la commande par référence
    $sql = "SELECT * FROM orders WHERE order_id = '$orderRef'";
    $result = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechercher des Commandes</title>
</head>
<body>
    <h2>Rechercher des Commandes</h2>
    <form action="search_orders.php" method="post">
        <label>Référence de Commande:</label>
        <input type="text" name="order_ref" value="<?php echo $orderRef; ?>">
        <input type="submit" value="Rechercher">
    </form>

    <?php
    // Afficher les résultats de la recherche
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($result && mysqli_num_rows($result) > 0) {
            echo "<h3>Résultats de la Recherche:</h3>";
            echo "<table border='1'>";
            echo "<tr><th>ID de la Commande</th><th>ID du Client</th><th>Date de Commande</th><th>Total</th></tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['order_id']}</td>";
                echo "<td>{$row['customer_id']}</td>";
                echo "<td>{$row['order_date']}</td>";
                echo "<td>{$row['total']}</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Aucune commande trouvée avec cette référence.</p>";
        }
    }
    ?>
</body>
</html>