<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Positions Registration</title>
    <!-- Inclure le lien vers votre fichier CSS si nécessaire -->
</head>
<body>
    <h1>Positions Registration</h1>

    <?php
    include('connect.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $position = $_POST['position'];

        $sql = "INSERT INTO postes  VALUES (:position)";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':position', $position, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "Position enregistrée avec succès.";
        } else {
            echo "Erreur : Position non enregistrée.";
        }
    }
    ?>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="position">Position :</label>
        <input type="text" name="position" id="position" required><br>

        <input type="submit" value="Enregistrer">
    </form>
</body>
</html>
