<?php
session_start(); // Démarrer une session

// Inclure le fichier de connexion à la base de données
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Récupérer les données du formulaire de connexion
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);                 

    // 2. Vérifier si l'utilisateur existe dans la base de données
    $check_user_query = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($check_user_query);

    if ($result->num_rows > 0) {
        // L'utilisateur existe, récupérer ses données
        $user = $result->fetch_assoc();

        // 3. Vérifier si le mot de passe est correct
        if (password_verify($password, $user['password'])) {
            // Mot de passe correct, démarrer une session utilisateur
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            echo "Connexion réussie !";

            // Rediriger vers la page user_space.html
            header("Location: ../User_space.php");
            exit(); // Arrêter l'exécution du script après la redirection
        } else {
            // Mot de passe incorrect, stocker le message d'erreur dans la session
            $_SESSION['error'] = "Mot de passe incorrect.";
            header("Location: ../Connexion.html"); // Rediriger vers la page de connexion
            exit();
        }
    } else {
        // Aucun compte trouvé avec cet email, stocker le message d'erreur dans la session
        $_SESSION['error'] = "Aucun compte trouvé avec cet email.";
        header("Location: ../Connexion.html"); // Rediriger vers la page de connexion
        exit();
    }
}

$conn->close();
?>
