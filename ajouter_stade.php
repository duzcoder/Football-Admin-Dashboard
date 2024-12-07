<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=dsi22g1;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    // Use $_POST to get the values from the form
    $codest = $_POST['codest']; 
    $lieu = $_POST['lieu'];

    // Check if the input fields are not empty
    if (!empty($codest) && !empty($lieu)) {
        // Prepare and execute the SQL query
        $query = $bdd->prepare('INSERT INTO stade (codest, lieu) VALUES (?, ?)');
        $query->execute(array($codest, $lieu));

        // Redirect after successful insertion
        header("Location: index.php");
        exit;
    } else {
        echo "Both fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Stade</title>

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
            <h1>Ajouter un Stade</h1>
            <form action="ajouter_stade.php" method="post">
                <!-- Code du stade -->
                <div class="mb-3">
                    <label for="codest" class="form-label">Code de stade:</label>
                    <input type="text" id="codest" name="codest" class="form-control" required>
                </div>

                <!-- Lieu -->
                <div class="mb-3">
                    <label for="lieu" class="form-label">Lieu:</label>
                    <input type="text" id="lieu" name="lieu" class="form-control" required>
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
