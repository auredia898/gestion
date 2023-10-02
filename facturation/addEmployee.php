<?php
include('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $poste = $_POST['poste'];

    $sql = "INSERT INTO employees (firstname, lastname, idPosition) VALUES (:nom, :prenom, :poste)";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
    $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $stmt->bindParam(':poste', $poste, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: employeeManagement.php");
        exit();
    } else {
        echo "Error: Employee not added.";
    }
}
?>
