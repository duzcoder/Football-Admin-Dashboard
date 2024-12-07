<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=dsi22g1;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if (isset($_POST['ids']) && is_array($_POST['ids'])) {
    $ids = $_POST['ids'];
    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    // Supprimer les joueurs sélectionnés
    $requete = $bdd->prepare("DELETE FROM joueur WHERE idj IN ($placeholders)");
    $requete->execute($ids);

    // Redirection après suppression
    header('Location: tp6affichage.php');
    exit();
} else {
    header('Location: tp6affichage.php?message=Aucun joueur selectionne');
    exit();
}
?>
