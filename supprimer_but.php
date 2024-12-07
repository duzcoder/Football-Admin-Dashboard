<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=dsi22g1;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if (isset($_POST['idm']) && is_array($_POST['idm'])) {
    $idmArray = $_POST['idm'];
    $placeholders = implode(',', array_fill(0, count($idmArray), '?'));

    // Préparer et exécuter la requête pour supprimer les buts
    $requete = $bdd->prepare("DELETE FROM marquer_but WHERE idm IN ($placeholders)");
    $requete->execute($idmArray);

    // Redirection après la suppression
    header('Location: tp6affichage.php');
    exit();
} else {
    header('Location: tp6affichage.php?message=Aucun but selectionne');
    exit();
}
?>
