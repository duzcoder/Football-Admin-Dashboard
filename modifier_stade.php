<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=dsi22g1;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mise à jour des données
    if (isset($_POST['codest'], $_POST['lieu'])) {
        $codest = $_POST['codest'];
        $lieu = $_POST['lieu'];
        
        // Correction dans l'ordre des paramètres
        $requete = $bdd->prepare('UPDATE stade SET lieu = ? WHERE codest= ?');
        $requete->execute(array($lieu, $codest));

        header('Location: tp6affichage.php');
        exit();
    } else {
        echo "Tous les champs doivent être remplis.";
    }
} else if (isset($_GET['codest'])) {
    $codest = $_GET['codest'];

    if (empty($codest)) {
        echo "Aucun ID de stade spécifié dans l'URL.";
    } else {
        $requete = $bdd->prepare('SELECT * FROM stade WHERE codest = ?');
        $requete->execute(array($codest));
        $stade = $requete->fetch();

        if ($stade) {
?>
<!-- Modification form with Bootstrap styling -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">            
<h2 class="mb-4 text-white bg-dark p-3 rounded">Modifier le stade</h2>
            <form action="modifier_stade.php" method="post" class="bg-light p-4 rounded shadow-sm">
                <label class="form-label">Code Stade :</label>
                <input type="text" name="codest" value="<?php echo $stade['codest']; ?>" class="form-control" redaonly>
                <label class="form-label">lieu :</label>
                <input type="text" name="lieu" value="<?php echo $stade['lieu']; ?>" class="form-control"><br>

                <button type="submit" class="btn btn-success">Enregistrer les modifications</button>
            </form>
        </div>
<?php
        } else {
            echo "Aucun stade trouvé avec cet ID.";
        }
    }
} else {
    echo "Le code de stade n'a pas ete specifie.";
}
?>
