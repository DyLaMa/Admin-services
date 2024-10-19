<?php
// Informations de connexion à la base de données
$servername = "localhost";
$username = "root"; // Remplacer par ton nom d'utilisateur
$password = ""; // Remplacer par ton mot de passe
$dbname = "admin-services"; // Nom de la base de données

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
} else {
    //echo "Connexion réussie à la base de données !";
}
?>
