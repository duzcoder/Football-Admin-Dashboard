<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=dsi22g1;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if (isset($_POST['codeeq']) && is_array($_POST['codeeq'])) {
    $codeeqArray = $_POST['codeeq'];
    $placeholders = implode(',', array_fill(0, count($codeeqArray), '?'));

    $requete = $bdd->prepare("DELETE FROM equipe WHERE codeeq IN ($placeholders)");
    $requete->execute($codeeqArray);

    // Redirection vers la page initiale
    header('Location: index.php');
    exit();
} else {
    header('Location: index.php?message=Aucune equipe selectionnee');
    exit();
}
?>
