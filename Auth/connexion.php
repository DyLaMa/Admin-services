<?php
session_start(); // Démarrer une session

// Inclure le fichier de connexion à la base de données
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Récupérer les données du formulaire de connexion
    $email_or_id = mysqli_real_escape_string($conn, $_POST['email']); // Champ 'email' peut être ID ou email
    $password = mysqli_real_escape_string($conn, $_POST['password']);                 

    // 2. Vérifier si l'utilisateur existe dans la base de données par email OU ID
    $check_user_query = "SELECT * FROM users WHERE email='$email_or_id' OR id='$email_or_id'";
    $result = $conn->query($check_user_query);

    if ($result->num_rows > 0) {
        // L'utilisateur existe, récupérer ses données
        $user = $result->fetch_assoc();

        // 3. Vérifier si le mot de passe est correct
        if (password_verify($password, $user['password'])) {
            // Mot de passe correct, démarrer une session utilisateur
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['role'] = $user['role']; // Stocker le rôle dans la session

            // Vérifier le rôle et rediriger en fonction
            if ($user['role'] === 'admin') {
                header("Location: ../admin_documents.php"); // Rediriger vers l'espace admin
            } else {
                header("Location: ../User_space.php"); // Rediriger vers l'espace utilisateur
            }
            exit(); // Arrêter l'exécution du script après la redirection
        } else {
            // Mot de passe incorrect, stocker le message d'erreur dans la session
            $_SESSION['error'] = "Mot de passe incorrect.";
            header("Location: ../Connexion.html"); // Rediriger vers la page de connexion
            exit();
        }
    } else {
        // Aucun compte trouvé avec cet email ou cet ID, stocker le message d'erreur dans la session
        $_SESSION['error'] = "Aucun compte trouvé avec cet email ou cet ID.";
        header("Location: ../Connexion.html"); // Rediriger vers la page de connexion
        exit();
    }
}

$conn->close();
?>
