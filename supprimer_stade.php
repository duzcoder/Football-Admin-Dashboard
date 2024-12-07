<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=dsi22g1;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if (isset($_POST['codest']) && is_array($_POST['codest'])) {
    $codestArray = $_POST['codest'];
    $placeholders = implode(',', array_fill(0, count($codestArray), '?'));

    // Préparation et exécution de la requête
    $requete = $bdd->prepare("DELETE FROM stade WHERE codest IN ($placeholders)");
    $requete->execute($codestArray);

    // Redirection après suppression
    header('Location:index.php');
    exit();
} else {
    header('Location: index.php?message=Aucun stade selectionne');
    exit();
}
?>
