<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Football</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

    <!--navbar class-->
<nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #343a40;">

<div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="tp6affichage.php">Dashboard</a>
        <a class="nav-link" href="extraction.php">Extraction</a>
        <a class="nav-link" href="stat.php">Statistiques</a>
        <a class="nav-link" href="pdfpage.php">Statistiques en PDF</a>
      </div>
    </div>
  </div>

</nav>


<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=dsi22g1;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$reponse = $bdd->query('SELECT * FROM equipe');
?>

<div class="container mt-5">
    <!-- Début du tableau équipe -->
    <h3 class="mb-3">Équipes</h3>
    <form action="supprimer_eq.php" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer les équipes sélectionnées ?');">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Sélection</th>
                    <th>Code de l'équipe</th>
                    <th>Nom de l'équipe</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($donnees = $reponse->fetch()) { ?>
                    <tr>
                        <td><input type="checkbox" name="codeeq[]" value="<?php echo $donnees['codeeq']; ?>"></td>
                        <td><?php echo $donnees['codeeq']; ?></td>
                        <td><?php echo $donnees['nomeq']; ?></td>
                        <td>
                        <a href="modifier_eq.php?codeeq=<?php echo $donnees['codeeq']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- Bouton supprimer en dehors du tableau -->
        <button type="submit" class="btn btn-danger">Supprimer les équipes sélectionnées</button>
    </form>
    <form action="ajouter_eq.php" method="get" class="mt-3">
        <button type="submit" class="btn btn-success">Ajouter une équipe</button>
    </form>
</div>
<?php $reponse->closeCursor(); ?>

<!-- Début du tableau stade -->
<?php
$reponse = $bdd->query('SELECT * FROM stade');
?>
<div class="container mt-5">
<h3 class="mb-3">Stades</h3>
<form action="supprimer_stade.php" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer les stades sélectionnés ?');">
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Sélection</th>
                <th>Code du Stade</th>
                <th>Lieu</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($donnees = $reponse->fetch()) { ?>
                <tr>
                    <td><input type="checkbox" name="codest[]" value="<?php echo $donnees['codest']; ?>"></td>
                    <td><?php echo $donnees['codest']; ?></td>
                    <td><?php echo $donnees['lieu']; ?></td>
                    <td>
                    <a href="modifier_stade.php?codest=<?php echo $donnees['codest']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <!-- Bouton de suppression -->
    <button type="submit" class="btn btn-danger">Supprimer les stades sélectionnés</button>
</form>
<form action="ajouter_stade.php" method="get" class="mt-3">
    <button type="submit" class="btn btn-success">Ajouter un stade</button>
</form>
</div>
<?php $reponse->closeCursor(); ?>

                <!--Table matchs-->

<?php
$reponse = $bdd->query('SELECT * FROM matchs');
?>
<div class="container mt-5">
<h3 class="mb-3">Matchs</h3>
<form action="supprimer_match.php" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer les matchs sélectionnés ?');">
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Sélection</th>
                <th>ID du Match</th>
                <th>Équipe 1</th>
                <th>Équipe 2</th>
                <th>Date du Match</th>
                <th>Code du Stade</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($donnees = $reponse->fetch()) {
                // Récupérer les noms des équipes
                $equipe1 = $bdd->query('SELECT nomeq FROM equipe WHERE codeeq = ' . $donnees['codeeq1']);
                $equipe1Data = $equipe1->fetch(PDO::FETCH_ASSOC);

                $equipe2 = $bdd->query('SELECT nomeq FROM equipe WHERE codeeq = ' . $donnees['codeeq2']);
                $equipe2Data = $equipe2->fetch(PDO::FETCH_ASSOC);
            ?>
                <tr>
                    <td><input type="checkbox" name="idm[]" value="<?php echo $donnees['idm']; ?>"></td>
                    <td><?php echo $donnees['idm']; ?></td>
                    <td><?php echo $equipe1Data['nomeq']; ?></td>
                    <td><?php echo $equipe2Data['nomeq']; ?></td>
                    <td><?php echo $donnees['datem']; ?></td>
                    <td><?php echo $donnees['codest']; ?></td>
                    <td>
                    <a href="modifier_match.php?idm=<?php echo $donnees['idm']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <!-- Bouton de suppression -->
    <button type="submit" class="btn btn-danger">Supprimer les matchs sélectionnés</button>
</form>
<form action="ajouter_match.php" method="get" class="mt-3">
    <button type="submit" class="btn btn-success">Ajouter un match</button>
</form>
</div>
<?php $reponse->closeCursor(); ?>

                <!--Table marquer but-->

                <?php
$reponse = $bdd->query('SELECT * FROM marquer_but');
?>
<div class="container mt-5">
    <h3 class="mb-3">Marquer un But</h3>
    <form action="supprimer_but.php" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer les buts sélectionnés ?');">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Sélection</th>
                    <th>ID du Match</th>
                    <th>ID du Joueur</th>
                    <th>Nombre de But</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($donnees = $reponse->fetch()) { ?>
                    <tr>
                        <td><input type="checkbox" name="idm[]" value="<?php echo $donnees['idm']; ?>"></td>
                        <td><?php echo $donnees['idm']; ?></td>
                        <td><?php echo $donnees['idj']; ?></td>
                        <td><?php echo $donnees['nbr_but']; ?></td>
                        <td>
                        <a href="modifier_but.php?idj=<?php echo $donnees['idj']; ?>&idm=<?php echo $donnees['idm']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <!-- Button to delete selected goals -->
        <button type="submit" class="btn btn-danger">Supprimer les buts sélectionnés</button>
    </form>

    <!-- Button to add a new goal -->
    <form action="ajouter_but.php" method="get" class="mt-3">
        <button type="submit" class="btn btn-success">Ajouter un but</button>
    </form>
</div>



    <!--Table joueur-->

    <?php
$reponse = $bdd->query('SELECT * FROM joueur');
?>
<div class="container mt-5">
    <h3 class="mb-3">Joueurs</h3>
    
    <!-- Form for Deleting Players -->
    <form action="supprimer_joueur.php" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer les joueurs sélectionnés ?');">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Sélection</th>
                    <th>ID du Joueur</th>
                    <th>Nom</th>
                    <th>Âge</th>
                    <th>Code équipe</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($donnees = $reponse->fetch()) {
                    $equipe = $bdd->query('SELECT nomeq FROM equipe WHERE codeeq = ' . $donnees['codeeq']);
                    $equipeData = $equipe->fetch(PDO::FETCH_ASSOC);
                ?>
                    <tr>
                        <td><input type="checkbox" name="ids[]" value="<?php echo $donnees['idj']; ?>"></td>
                        <td><?php echo $donnees['idj']; ?></td>
                        <td><?php echo $donnees['nom']; ?></td>
                        <td><?php echo $donnees['age']; ?></td>
                        <td><?php echo $equipeData['nomeq']; ?></td>
                        <td>
                            <!-- Modifier Button in a separate form -->
                            <a href="modifier_joueur.php?idj=<?php echo $donnees['idj']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <!-- Button to delete selected players -->
        <button type="submit" class="btn btn-danger">Supprimer les joueurs sélectionnés</button>
    </form>

    <!-- Button to add a new player -->
    <form action="ajouter_joueur.php" method="get" class="mt-3">
        <button type="submit" class="btn btn-success">Ajouter un joueur</button>
    </form>
</div>
<?php $reponse->closeCursor(); ?>



    <!-- Add Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
