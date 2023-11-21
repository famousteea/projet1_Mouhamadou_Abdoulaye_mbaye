<?php
// Inclure le fichier de configuration de la base de données
include('config.php');

// Vérifier si l'utilisateur est connecté
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

// Récupérer les informations de la commande à partir de la session ou de la base de données
// Ajouter la logique pour récupérer les détails de la commande
$orderId = $_SESSION['order_id']; // Supposons que vous stockiez l'ID de commande dans la session

// Traitement du formulaire de confirmation de commande
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ajouter la logique pour confirmer la commande, mettre à jour la base de données, etc.
    $confirmation = $_POST['confirmation']; // Supposons que vous ayez un champ de confirmation dans le formulaire

    if ($confirmation === 'confirm') {
        // Mettre à jour le statut de la commande dans la base de données
        // Rediriger l'utilisateur vers une page de confirmation
        header('Location: order_confirmation.php');
        exit();
    } else {
        // Gérer l'annulation de la confirmation
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Commande</title>
</head>
<body>
    <h2>Récapitulatif de la Commande</h2>
    <!-- Afficher ici les détails de la commande (produits, quantités, prix, etc.) -->

    <!-- Formulaire de confirmation de commande -->
    <form method="post" action="confirm_order.php">
        <!-- Ajouter des champs pour les informations de livraison, paiement, etc. -->

        <!-- Champs de confirmation -->
        <label for="confirmation">Confirmer la commande :</label>
        <input type="radio" name="confirmation" value="confirm" required> Oui
        <input type="radio" name="confirmation" value="cancel" required> Annuler

        <!-- Bouton de confirmation de commande -->
        <button type="submit">Confirmer la Commande</button>
    </form>
</body>
</html>