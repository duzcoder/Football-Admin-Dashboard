<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=dsi22g1;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if (isset($_POST['idm']) && is_array($_POST['idm'])) {
    $idmArray = $_POST['idm'];
    $placeholders = implode(',', array_fill(0, count($idmArray), '?'));

    // Préparation et exécution de la requête
    $requete = $bdd->prepare("DELETE FROM matchs WHERE idm IN ($placeholders)");
    $requete->execute($idmArray);

    // Redirection après suppression
    header('Location: tp6affichage.php');
    exit();
} else {
    header('Location: tp6affichage.php?message=Aucun match selectionne');
    exit();
}
?>
