<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    // Debug the POST data
    var_dump($_POST); // This will show you what data is being passed

    try {
        $bdd = new PDO('mysql:host=localhost;dbname=dsi22g1;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    $idk = $_POST['idk']; 
    $nom = $_POST['nom'];
    $age = $_POST['age'];
    $codeEQ = $_POST['codeeq'];

    // Prepare the query
    $query = $bdd->prepare('INSERT INTO joueur (idj, nom, age, codeeq) VALUES (?, ?, ?, ?)');
    
    // Execute and check for errors
    if (!$query->execute(array($idk, $nom, $age, $codeEQ))) {
        print_r($query->errorInfo()); // Show any error that occurs
    } else {
        echo "Insertion réussie"; // Data inserted successfully
    }

    // Redirect after successful submission
    header("Location: tp6affichage.php");
    exit;
}

try {
    $bdd = new PDO('mysql:host=localhost;dbname=dsi22g1;charset=utf8', 'root', '');
    $equipes = $bdd->query('SELECT codeeq, nomeq FROM equipe')->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un joueur</title>
    
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
            <h1>Ajouter un joueur</h1>
            <form action="ajouter_joueur.php" method="post">
                <!-- ID joueur -->
                <div class="mb-3">
                    <label for="idk" class="form-label">ID joueur:</label>
                    <input type="text" id="idk" name="idk" class="form-control" required>
                </div>

                <!-- Nom du joueur -->
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom du joueur:</label>
                    <input type="text" id="nom" name="nom" class="form-control" required>
                </div>

                <!-- Âge -->
                <div class="mb-3">
                    <label for="age" class="form-label">Âge:</label>
                    <input type="number" id="age" name="age" class="form-control" required>
                </div>

                <!-- Sélection d'équipe -->
                <div class="mb-3">
                    <label for="codeeq" class="form-label">Équipe:</label>
                    <select id="codeeq" name="codeeq" class="form-select" required>
                        <option value="">-- Sélectionnez une équipe --</option>
                        <?php foreach ($equipes as $equipe) { ?>
                            <option value="<?php echo $equipe['codeeq']; ?>">
                                <?php echo $equipe['nomeq']; ?> (<?php echo $equipe['codeeq']; ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100">Ajouter</button>
            </form>
        </div>
    </div>

    <!-- Scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
