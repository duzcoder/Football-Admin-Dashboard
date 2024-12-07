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
$reponse = $bdd->query('SELECT * FROM joueur ORDER BY `age`');
?>
<div class="container mt-5">
    <h3 class="mb-3">Joueurs</h3>
    <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID du Joueur</th>
                    <th>Nom</th>
                    <th>Âge</th>
                    <th>Code équipe</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($donnees = $reponse->fetch()) {
                    $equipe = $bdd->query('SELECT nomeq FROM equipe WHERE codeeq = ' . $donnees['codeeq']);
                    $equipeData = $equipe->fetch(PDO::FETCH_ASSOC);
                ?>
                    <tr>
                        <td><?php echo $donnees['idj']; ?></td>
                        <td><?php echo $donnees['nom']; ?></td>
                        <td><?php echo $donnees['age']; ?></td>
                        <td><?php echo $equipeData['nomeq']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
</div>

<br>

<?php $reponse = $bdd->query("SELECT j.idj, j.nom, j.age, j.codeeq FROM joueur j, equipe e WHERE j.codeeq = e.codeeq AND nomeq = 'est';"); ?>
<div class="container mt-5">
    <h3 class="mb-3">Joueurs de l'quipe EST</h3>
    <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID du Joueur</th>
                    <th>Nom</th>
                    <th>Âge</th>
                    <th>Code équipe</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($donnees = $reponse->fetch()) {
                    $equipe = $bdd->query('SELECT nomeq FROM equipe WHERE codeeq = ' . $donnees['codeeq']);
                    $equipeData = $equipe->fetch(PDO::FETCH_ASSOC);
                ?>
                    <tr>
                        <td><?php echo $donnees['idj']; ?></td>
                        <td><?php echo $donnees['nom']; ?></td>
                        <td><?php echo $donnees['age']; ?></td>
                        <td><?php echo $equipeData['nomeq']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
</div>


<?php
$reponse = $bdd->query("SELECT * FROM matchs m, stade s WHERE m.codest = s.codest AND s.lieu = 'rades'");
?>
<div class="container mt-5">
<h3 class="mb-3">Matchs - Stade Rades</h3>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID du Match</th>
                <th>Équipe 1</th>
                <th>Équipe 2</th>
                <th>Date du Match</th>
                <th>Code du Stade</th>
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
                    <td><?php echo $donnees['idm']; ?></td>
                    <td><?php echo $equipe1Data['nomeq']; ?></td>
                    <td><?php echo $equipe2Data['nomeq']; ?></td>
                    <td><?php echo $donnees['datem']; ?></td>
                    <td><?php echo $donnees['codest']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php
$reponse = $bdd->query("SELECT m.idm, m.codeeq1, m.codeeq2, m.datem, m.codest, SUM(nbr_but) AS nbr_but FROM matchs m, marquer_but b WHERE m.idm = b.idm GROUP BY m.idm, m.codeeq1, m.codeeq2, m.datem, m.codest");
?>
<div class="container mt-5">
<h3 class="mb-3">Buts marqués</h3>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID du Match</th>
                <th>Équipe 1</th>
                <th>Équipe 2</th>
                <th>Date du Match</th>
                <th>Code du Stade</th>
                <th>Nombre des but</th>
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
                    <td><?php echo $donnees['idm']; ?></td>
                    <td><?php echo $equipe1Data['nomeq']; ?></td>
                    <td><?php echo $equipe2Data['nomeq']; ?></td>
                    <td><?php echo $donnees['datem']; ?></td>
                    <td><?php echo $donnees['codest']; ?></td>
                    <td><?php echo $donnees['nbr_but']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<?php
$reponse = $bdd->query("
SELECT j.idj, 
       (SELECT COUNT(DISTINCT m.idm) 
        FROM matchs m, marquer_but b 
        WHERE b.idj = j.idj AND m.idm = b.idm) AS Match_joues, 
       (SELECT SUM(b.nbr_but) 
        FROM marquer_but b 
        WHERE b.idj = j.idj) AS nbr_but
FROM joueur j
");

?>
<div class="container mt-5">
<h3 class="mb-3">Profil joueurs</h3>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID Joueur</th>
                <th>Nombre Matchs Joués</th>
                <th>Buts Marqués</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($donnees = $reponse->fetch()) {
            ?>
                <tr>
                    <td><?php echo $donnees['idj']; ?></td>
                    <td><?php echo $donnees['Match_joues']; ?></td>
                    <td><?php echo $donnees['nbr_but']; ?></td>
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