<?php
// Inclure le fichier de connexion à la base de données
include('config.php');

// Vérifier si l'utilisateur est un administrateur
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté en tant qu'administrateur
    exit();
}

// Définir les variables d'erreur et les valeurs par défaut
$name = $description = $price = $quantity = $category = '';
$name_err = $description_err = $price_err = $quantity_err = $category_err = '';

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Valider les champs
    if (empty(trim($_POST['name']))) {
        $name_err = 'Veuillez entrer le nom du produit.';
    } else {
        $name = trim($_POST['name']);
    }

    if (empty(trim($_POST['description']))) {
        $description_err = 'Veuillez entrer la description du produit.';
    } else {
        $description = trim($_POST['description']);
    }

    if (empty(trim($_POST['price']))) {
        $price_err = 'Veuillez entrer le prix du produit.';
    } else {
        $price = trim($_POST['price']);
    }

    if (empty(trim($_POST['quantity']))) {
        $quantity_err = 'Veuillez entrer la quantité en stock du produit.';
    } else {
        $quantity = trim($_POST['quantity']);
    }

    if (empty(trim($_POST['category']))) {
        $category_err = 'Veuillez entrer la catégorie du produit.';
    } else {
        $category = trim($_POST['category']);
    }

    // Vérifier s'il n'y a pas d'erreurs avant d'ajouter le produit à la base de données
    if (empty($name_err) && empty($description_err) && empty($price_err) && empty($quantity_err) && empty($category_err)) {
        // Préparer la requête d'insertion
        $sql = 'INSERT INTO products (name, description, price, quantity, category) VALUES (?, ?, ?, ?, ?)';

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 'ssdis', $name, $description, $price, $quantity, $category);

            // Exécuter la requête préparée
            if (mysqli_stmt_execute($stmt)) {
                // Rediriger vers une page de confirmation ou une autre page après l'ajout réussi
                header('Location: product_list.php');
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
    <title>Ajouter un Produit</title>
    <!-- Ajoutez ici les liens vers les feuilles de style et les scripts nécessaires -->
</head>

<body>
    <h2>Ajouter un Produit</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <label>Nom du Produit:</label>
        <input type="text" name="name" value="<?php echo $name; ?>">
        <span><?php echo $name_err; ?></span>

        <label>Description du Produit:</label>
        <textarea name="description"><?php echo $description; ?></textarea>
        <span><?php echo $description_err; ?></span>

        <label>Prix du Produit:</label>
        <input type="text" name="price" value="<?php echo $price; ?>">
        <span><?php echo $price_err; ?></span>

        <label>Quantité en Stock:</label>
        <input type="number" name="quantity" value="<?php echo $quantity; ?>">
        <span><?php echo $quantity_err; ?></span>

        <label>Catégorie du Produit:</label>
        <input type="text" name="category" value="<?php echo $category; ?>">
        <span><?php echo $category_err; ?></span>

        <input type="submit" value="Ajouter le Produit">
    </form>

    <p><a href="product_list.php">Retour à la Liste des Produits</a></p>
</body>

</html>