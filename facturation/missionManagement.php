<!DOCTYPE html>
<html>
<head>
    <title>Missions Management</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Mission Management</h1>

    <h2>Add some mission</h2>
    <form action="ajouter_mission.php" method="post">
        <label for="employe">Employee :</label>
        <select name="employe" id="employe" required>
            <?php
            include('connect.php');

            $sql = "SELECT * FROM employees";
            $result = $connexion->query($sql);

            if ($result->rowCount() > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $row["IdEmployee"] . "'>" . $row["firstname"] . " " . $row["lastname"] . "</option>";
                }
            }
            ?>
        </select><br>
        <label for="date">Mission date :</label>
        <input type="date" name="date" id="date" required><br>
        <label for="objet">Mission objective:</label>
        <input type="text" name="objet" id="objet" required><br>
        <label for="jours">Nombre de Jours :</label>
        <input type="number" name="jours" id="jours" required><br>
        <label for="heures">Heures de Travail par Jour :</label>
        <input type="number" name="heures" id="heures" required><br>
        <input type="submit" value="Ajouter Mission">
    </form>

    <h2>Missions List</h2>
    <?php
    $sql = "SELECT missions.*, employees.firstname, employees.lastname FROM missions INNER JOIN employees ON missions.IdEmployee = employees.IdEmployee";
    $result = $connexion->query($sql);

    if ($result->rowCount() > 0) {
        echo "<table>";
        echo "<tr><th>Employé</th><th>Date</th><th>Objet</th><th>Nombre de Jours</th><th>Heures de Travail par Jour</th><th>Actions</th></tr>";
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row["firstname"] . " " . $row["lastname"] . "</td>";
            echo "<td>" . $row["MissionDate"] . "</td>";
            echo "<td>" . $row["Objective"] . "</td>";
            echo "<td>" . $row["DaysWorked"] . "</td>";
            echo "<td>" . $row["HoursPerDay"] . "</td>";
            echo "<td><a href='modifier_mission.php?id=" . $row["IdMission"] . "'>Modifier</a> | <a href='supprimer_mission.php?id=" . $row["IdMission"] . "'>Supprimer</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Aucune mission trouvée.";
    }
    ?>
</body>
</html>
