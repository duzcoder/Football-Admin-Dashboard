<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=dsi22g1;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mise à jour des données
    if (isset($_POST['idm'], $_POST['idj'], $_POST['nbr_but'])) {
        $idm = $_POST['idm'];
        $idj = $_POST['idj'];
        $nbr_but = $_POST['nbr_but'];

        $requete = $bdd->prepare('UPDATE marquer_but SET nbr_but = ? WHERE idm = ? AND idj = ?');
        $requete->execute(array($nbr_but,$idm,$idj));

        header('Location: index.php');
        exit();
    } else {
        echo "Tous les champs doivent etre remplis.";
    }}
    else if (isset($_GET['idm'], $_GET['idj'])) {
    $idm = $_GET['idm'];
    $idj = $_GET['idj'];

    if (empty($idm)) {
        echo "Aucun ID de marque but specifie dans l'URL.";
    } else {
        $requete = $bdd->prepare('SELECT * FROM marquer_but WHERE idm = ? AND idj = ?');
        $requete->execute(array($idm,$idj));
        $marquer_but = $requete->fetch();

        if ($marquer_but) {
            ?>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <!-- Formulaire -->
            <div class="container mt-5">
                <h2 class="mb-4 text-white bg-dark p-3 rounded">Modifier le marquage de but</h2>
                <form action="modifier_but.php" method="post" class="bg-light p-4 rounded shadow-sm">

                    <div class="mb-3">
                        <label for="idj" class="form-label">ID du joueur :</label>
                        <input type="text" class="form-control" name="idj" value="<?php echo $marquer_but['idj']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="idm" class="form-label">ID du match :</label>
                        <input type="text" class="form-control" name="idm" value="<?php echo $marquer_but['idm']; ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="nbr_but" class="form-label">Nombre de buts :</label>
                        <input type="number" class="form-control" name="nbr_but" value="<?php echo $marquer_but['nbr_but']; ?>" required>
                    </div>

                    <button type="submit" class="btn btn-success">Enregistrer les modifications</button>
                </form>
            </div>
            <!-- Adding Bootstrap scripts -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

<?php
        
        }
    } 
}

?>
