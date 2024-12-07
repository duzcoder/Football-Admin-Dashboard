<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=dsi22g1;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mise à jour des données
    if (isset($_POST['codeeq'], $_POST['nomeq'])) {
        $codeEq = $_POST['codeeq'];
        $nomEqp = $_POST['nomeq'];
        
        $requete = $bdd->prepare('UPDATE equipe SET nomeq = ? WHERE codeeq = ?');
        $requete->execute(array($nomEqp, $codeEq)); 

        header('Location: index.php');
        exit();
    } else {
        echo "Tous les champs doivent être remplis.";
    }
} else if (isset($_GET['codeeq'])) {
    $codeEq = $_GET['codeeq'];

    // Vérification si l'id est présent dans l'URL
    if (empty($codeEq)) {
        echo "Aucun ID d'équipe specifie dans l'URL.";
    } else {
        $requete = $bdd->prepare('SELECT * FROM equipe WHERE codeeq = ?');
        $requete->execute(array($codeEq));
        $equipe = $requete->fetch();

        if ($equipe) {
?>             <!-- Modification form with Bootstrap styling -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <div class="container mt-5">
            <h2 class="mb-4 text-white bg-dark p-3 rounded">Modifier l'équipe</h2>
            <form action="modifier_eq.php" method="post" class="bg-light p-4 rounded shadow-sm">
            <label class="form-label">Code d'equipe :</label>
                <input type="text" name="codeeq" value="<?php echo $equipe['codeeq']; ?>" class="form-control" readonly>
                <label class="form-label">Nom d'equipe :</label>
                <input type="text" name="nomeq" value="<?php echo $equipe['nomeq']; ?>" class="form-control"><br>
    
                <button type="submit" class="btn btn-success">Enregistrer les modifications</button>
            </form>
        </div>

    <!-- Adding Bootstrap scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<?php
        } else {
            echo "Aucune équipe trouvée avec cet ID.";
        }
    }
} else {
    echo "ID de l'équipe non specifie.";
}
?>
