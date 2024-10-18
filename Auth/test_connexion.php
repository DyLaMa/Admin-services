<?php
// Informations de connexion à la base de données
$servername = "localhost"; // Nom du serveur (généralement localhost pour une base locale)
$username = "nom_utilisateur"; // Ton nom d'utilisateur MySQL
$password = "mot_de_passe"; // Ton mot de passe MySQL
$dbname = "admin_services"; // Nom de la base de données

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
} else {
    echo "Connexion réussie à la base de données !";
}

$conn->close();
?>
