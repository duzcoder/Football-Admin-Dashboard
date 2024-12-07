<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=dsi22g1;charset=utf8', 'root', '');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        die('<div class="alert alert-danger">Database connection failed: ' . $e->getMessage() . '</div>');
    }

    // Collect form data
    $idm = $_POST['idm'];
    $codeeqp1 = $_POST['code1'];  // Change to 'code1' as per the HTML input name
    $codeeqp2 = $_POST['code2'];  // Change to 'code2' as per the HTML input name
    $dateM = $_POST['datem'];
    $codest = $_POST['codest'];

    // Validate form data
    if ($codeeqp1 === $codeeqp2) {
        die('<div class="alert alert-danger">Erreur : Les deux équipes doivent être différentes.</div>');
    }

    // Insert data into database
    try {
        $query = $bdd->prepare('INSERT INTO matchs (idm, codeeq1, codeeq2, datem, codest) VALUES (?, ?, ?, ?, ?)');
        if (!$query->execute(array($idm, $codeeqp1, $codeeqp2, $dateM, $codest))) {
            print_r($query->errorInfo());
        } else {
            echo '<div class="alert alert-success">Insertion réussie.</div>';
            header("Location: index.php");
            exit;
        }
    } catch (Exception $e) {
        die('<div class="alert alert-danger">Error during insertion: ' . $e->getMessage() . '</div>');
    }
}

// Fetch teams and stadiums
try {
    $bdd = new PDO('mysql:host=localhost;dbname=dsi22g1;charset=utf8', 'root', '');
    $equipes = $bdd->query('SELECT codeeq, nomeq FROM equipe')->fetchAll(PDO::FETCH_ASSOC);
    $stades = $bdd->query('SELECT codest, lieu FROM stade')->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die('<div class="alert alert-danger">Error fetching data: ' . $e->getMessage() . '</div>');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Match</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            color: #212529;
        }
        .form-container {
            max-width: 600px;
            margin: 3rem auto;
            padding: 2rem;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container h1 {
            color: #198754;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        .btn-primary {
            background-color: #198754;
            border-color: #198754;
        }
        .btn-primary:hover {
            background-color: #145c40;
            border-color: #145c40;
        }
        .form-label {
            font-weight: 600;
            color: #495057;
        }
        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Ajouter un Match</h1>
            <form action="ajouter_match.php" method="post">
                <div class="mb-3">
                    <label for="idm" class="form-label">ID Match:</label>
                    <input type="text" id="idm" name="idm" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="codeeqp1" class="form-label">Équipe 1:</label>
                    <select id="codeeqp1" name="code1" class="form-select" required>
                        <option value="">-- Sélectionnez une équipe --</option>
                        <?php foreach ($equipes as $equipe) { ?>
                            <option value="<?php echo $equipe['codeeq']; ?>">
                                <?php echo $equipe['nomeq']; ?> (<?php echo $equipe['codeeq']; ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="codeeqp2" class="form-label">Équipe 2:</label>
                    <select id="codeeqp2" name="code2" class="form-select" required>
                        <option value="">-- Sélectionnez une équipe --</option>
                        <?php foreach ($equipes as $equipe) { ?>
                            <option value="<?php echo $equipe['codeeq']; ?>">
                                <?php echo $equipe['nomeq']; ?> (<?php echo $equipe['codeeq']; ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="datem" class="form-label">Date du match:</label>
                    <input type="date" id="datem" name="datem" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="codest" class="form-label">Lieu du Stade:</label>
                    <select id="codest" name="codest" class="form-select" required>
                        <option value="">-- Sélectionnez un lieu --</option>
                        <?php foreach ($stades as $stade) { ?>
                            <option value="<?php echo $stade['codest']; ?>">
                                <?php echo $stade['lieu']; ?> (<?php echo $stade['codest']; ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">Ajouter</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
