<?php
// Informations de connexion à la base de données
$dsn = 'mysql:host=localhost;dbname=fplanner;charset=utf8';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Échec de la connexion : ' . $e->getMessage());
}
?>