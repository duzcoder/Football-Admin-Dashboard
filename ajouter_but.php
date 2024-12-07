<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Establish the database connection
    $bdd = new PDO('mysql:host=localhost;dbname=dsi22g1;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('<div class="alert alert-danger">Database connection failed: ' . $e->getMessage() . '</div>');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    // Collect form data
    $idm = $_POST['idm']; 
    $idj = $_POST['idj'];
    $nbr_but = $_POST['nbr_but'];

    // Insert data into the database
    try {
        $query = $bdd->prepare('INSERT INTO marquer_but (idm, idj, nbr_but) VALUES (?, ?, ?)');
        $query->execute(array($idm, $idj, $nbr_but));

        // Redirect to another page after insertion
        header("Location: index.php"); 
        exit;
    } catch (Exception $e) {
        die('<div class="alert alert-danger">Error during insertion: ' . $e->getMessage() . '</div>');
    }
}

// Fetch available matches and players from the database
try {
    $matches = $bdd->query('SELECT idm FROM matchs')->fetchAll(PDO::FETCH_ASSOC);
    $joueurs = $bdd->query('SELECT idj, nom FROM joueur')->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die('<div class="alert alert-danger">Error fetching data: ' . $e->getMessage() . '</div>');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un But</title>

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
            <h1>Ajouter un But</h1>
            <form action="ajouter_but.php" method="post">
                <!-- Match Selection -->
                <div class="mb-3">
                    <label for="idm" class="form-label">Choisir le Match:</label>
                    <select id="idm" name="idm" class="form-select" required>
                        <option value="">-- Sélectionnez un match --</option>
                        <?php foreach ($matches as $match) { ?>
                            <option value="<?php echo $match['idm']; ?>">
                             <?php echo $match['idm']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Player Selection -->
                <div class="mb-3">
                    <label for="idj" class="form-label">Choisir le Joueur:</label>
                    <select id="idj" name="idj" class="form-select" required>
                        <option value="">-- Sélectionnez un joueur --</option>
                        <?php foreach ($joueurs as $joueur) { ?>
                            <option value="<?php echo $joueur['idj']; ?>">
                                <?php echo $joueur['nom']; ?> (ID: <?php echo $joueur['idj']; ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Goals Number -->
                <div class="mb-3">
                    <label for="nbr_but" class="form-label">Nombre de Buts:</label>
                    <input type="number" id="nbr_but" name="nbr_but" class="form-control" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100">Ajouter</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
