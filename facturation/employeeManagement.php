<!DOCTYPE html>
<html>
<head>
    <title>Employees Management</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Employees Management</h1>

    <h2>Add an employee</h2>
    <form action="addEmployee.php" method="post">
        <label for="nom">Firstame :</label>
        <input type="text" name="nom" id="nom" required><br>
        <label for="prenom">Lastname :</label>
        <input type="text" name="prenom" id="prenom" required><br>
        <label for="poste">Position :</label>
        <input type="text" name="poste" id="poste" required><br>
        <input type="submit" value="Ajouter Employé">
    </form>

    <h2>Employees list</h2>

    <?php
    include('connect.php');

    $sql = "SELECT * FROM employees";
    $result = $connexion->query($sql);

    if ($result->rowCount() > 0) {
        echo "<table>";
        echo "<tr><th>Nom</th><th>Prénom</th><th>Poste</th><th>Actions</th></tr>";
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row["firstname"] . "</td>";
            echo "<td>" . $row["lastname"] . "</td>";
            echo "<td>" . $row["idPosition"] . "</td>";
            echo "<td><a href='modifier_employe.php?id=" . $row["IdEmployee"] . "'>Modifier</a> | <a href='supprimer_employe.php?id=" . $row["IdEmployee"] . "'>Supprimer</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Aucun employé trouvé.";
    }
    ?>
</body>
</html>
