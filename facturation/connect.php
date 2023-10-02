<?php
$localhost = "localhost";
$username = "root";
$password = "";
$dbname = "facturations";

try {
    $connexion = new PDO("mysql:host=$localhost;dbname=$dbname", $username, $password);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>
