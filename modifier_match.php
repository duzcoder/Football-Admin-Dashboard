<?php 
try {
    $bdd = new PDO('mysql:host=localhost;dbname=dsi22g1;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mise à jour des données
    if (isset($_POST['idm'], $_POST['codeeq1'], $_POST['codeeq2'], $_POST['datem'], $_POST['codest'])) {
        $idm = $_POST['idm'];
        $codeeqp1 = $_POST['codeeq1'];
        $codeeqp2 = $_POST['codeeq2'];
        $dateM = $_POST['datem'];
        $codest = $_POST['codest'];

        $requete = $bdd->prepare('UPDATE matchs SET codeeq1 = ?, codeeq2 = ?, datem = ?, codest = ? WHERE idm = ?');
        $requete->execute(array($codeeqp1, $codeeqp2, $dateM, $codest, $idm));

        header('Location: index.php');
        exit();
    } else {
        echo "Tous les champs doivent être remplis.";
    }
} elseif (isset($_GET['idm'])) {
    // Affichage du formulaire de modification
    $idm = $_GET['idm'];

    $requete = $bdd->prepare('SELECT * FROM matchs WHERE idm = ?');
    $requete->execute(array($idm));
    $match = $requete->fetch();

    if ($match) {
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5"> 
        <h2 class="mb-4 text-white bg-dark p-3 rounded">Modifier les coordonnées du match</h2>
        <form action="modifier_match.php" method="post" class="bg-light p-4 rounded shadow-sm">
            <label class="form-label">Code Match :</label>
            <input type="text" name="idm" value="<?php echo htmlspecialchars($match['idm']); ?>" readonly><br>
            <label class="form-label">Code de la 1ere equipe :</label>
            <input type="text" name="codeeq1" value="<?php echo htmlspecialchars($match['codeeq1']); ?>" class="form-control"><br>
            <label class="form-label">Code de la 2eme equipe :</label>
            <input type="text" name="codeeq2" value="<?php echo htmlspecialchars($match['codeeq2']); ?>" class="form-control"><br>
            <label class="form-label">Date du match :</label>
            <input type="date" name="datem" value="<?php echo htmlspecialchars($match['datem']); ?>" class="form-control"><br>
            <label class="form-label">Code du stade :</label>
            <input type="text" name="codest" value="<?php echo htmlspecialchars($match['codest']); ?>" class="form-control"><br>
            <button type="submit" class="btn btn-success">Enregistrer les modifications</button>
        </form>
    </div>
<?php
    } else {
        echo "Aucun match trouvé avec cet ID.";
    }
} else {
    echo "ID du match non spécifié.";
}
?>
