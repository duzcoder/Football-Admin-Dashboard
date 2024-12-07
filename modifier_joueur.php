<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=dsi22g1;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all necessary fields are provided
    if (isset($_POST['idk'], $_POST['nom'], $_POST['age'], $_POST['codeeq'])) {
        $formData = array(
            'idj' => $_POST['idk'],
            'nom' => $_POST['nom'],
            'age' => $_POST['age'],
            'codeeq' => $_POST['codeeq']
        );

        // Update the player record
        $requete = $bdd->prepare('UPDATE joueur SET nom = ?, age = ?, codeeq = ? WHERE idj = ?');
        $requete->execute(array($formData['nom'], $formData['age'], $formData['codeeq'], $formData['idj']));

        // Redirect back to player list after success
        header('Location: tp6affichage.php');
        exit();
    } else {
        echo "Tous les champs doivent être remplis.";
    }
} else if (isset($_GET['idj'])) {
    $idj = $_GET['idj'];  // Get the player ID from the URL

    // Fetch player data by ID
    $requete = $bdd->prepare('SELECT * FROM joueur WHERE idj = ?');
    $requete->execute(array($idj));
    $joueur = $requete->fetch();

    if ($joueur) {
        // Fetch available teams
        $equipes = $bdd->query('SELECT codeeq, nomeq FROM equipe')->fetchAll(PDO::FETCH_ASSOC);
?>
        <!-- Modification form with Bootstrap styling -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <div class="container mt-5">
            <h2 class="mb-4 text-white bg-dark p-3 rounded">Modifier le joueur</h2>
            
            <form action="modifier_joueur.php" method="post" class="bg-light p-4 rounded shadow-sm">
                <input type="hidden" name="idk" value="<?php echo $joueur['idj']; ?>">

                <div class="mb-3">
                    <label for="nom" class="form-label">Nom :</label>
                    <input type="text" class="form-control" name="nom" value="<?php echo $joueur['nom']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="age" class="form-label">Âge :</label>
                    <input type="number" class="form-control" name="age" value="<?php echo $joueur['age']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="codeeq" class="form-label">Équipe :</label>
                    <select id="codeeq" name="codeeq" class="form-select" required>
                        <option value="">-- Sélectionner une équipe --</option>
                        <?php foreach ($equipes as $equipe) { ?>
                            <option value="<?php echo $equipe['codeeq']; ?>" <?php echo ($joueur['codeeq'] == $equipe['codeeq']) ? 'selected' : ''; ?>>
                                <?php echo $equipe['nomeq']; ?> (<?php echo $equipe['codeeq']; ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Enregistrer les modifications</button>
            </form>
        </div>

        <!-- Adding Bootstrap scripts -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

<?php
    } else {
        echo "Aucun joueur trouvé avec cet ID.";
    }
} else {
    echo "ID du joueur non spécifié.";
}
?>
