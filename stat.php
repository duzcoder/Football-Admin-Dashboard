<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Football</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
$reponse = $bdd->query("SELECT j.idj, (SELECT COUNT(DISTINCT m.idm) FROM matchs m, marquer_but b WHERE b.idj = j.idj AND m.idm = b.idm) AS Match_joues, (SELECT SUM(b.nbr_but) FROM marquer_but b WHERE b.idj = j.idj) AS nbr_but FROM joueur j");
?>

<div class="container mt-5">
<h3 class="mb-3">Statistique joueurs</h3>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID Joueur</th>
                <th>Nombre Matchs Joués</th>
                <th>Buts Match</th>
                <th>Age Moyen</th>
                <th>Meilleur Joueur</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $ageMoyStmt = $bdd->query("SELECT AVG(age) AS Age FROM joueur");
            $ageMoy = $ageMoyStmt->fetch()['Age'];
            $joueurMAX = $bdd->query("SELECT j.nom AS nom FROM joueur j, marquer_but b WHERE j.idj = b.idj AND b.nbr_but = (SELECT MAX(b2.nbr_but) AS max_but FROM marquer_but b2)");
            $joueur = $joueurMAX->fetch()['nom'];
            while ($donnees = $reponse->fetch()) {
            ?>
                <tr>
                    <td><?php echo $donnees['idj']; ?></td>
                    <td><?php echo $donnees['Match_joues']; ?></td>
                    <td><?php echo $donnees['nbr_but']; ?></td>
                    <td><?php echo $ageMoy ?></td>
                    <td><?php echo $joueur ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Add Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>