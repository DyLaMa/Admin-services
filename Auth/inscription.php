<?php
session_start(); // Démarrer la session pour utiliser $_SESSION

// Inclure le fichier de connexion à la base de données
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Récupérer les données soumises par le formulaire
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
    $date_naissance = mysqli_real_escape_string($conn, $_POST['dob']);
    $telephone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $cni_passport = mysqli_real_escape_string($conn, $_POST['cni']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // 2. Générer l'ID basé sur le nom et la date de naissance
    $nom_part = substr($nom, 0, 3);  // Prendre les 3 premières lettres du nom
    $date_naissance_format = date('Ymd', strtotime($date_naissance));  // Formater la date en YYYYMMDD
    $user_id = strtoupper($nom_part) . $date_naissance_format;  // Combiner nom et date formatée

    // 3. Vérifier si l'utilisateur existe déjà par email ou numéro de CNI
    $check_user_query = "SELECT * FROM users WHERE email='$email' OR cni_passport='$cni_passport'";
    $result = $conn->query($check_user_query);

    if ($result->num_rows > 0) {
        echo "Cet email ou numéro de CNI/Passeport est déjà utilisé.";
    } else {
        // 4. Hacher le mot de passe avant de l'enregistrer
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // 5. Insérer les données avec l'ID généré
        $insert_query = "INSERT INTO users (id, nom, prenom, date_naissance, telephone, email, cni_passport, password) 
                         VALUES ('$user_id', '$nom', '$prenom', '$date_naissance', '$telephone', '$email', '$cni_passport', '$hashed_password')";

        if ($conn->query($insert_query) === TRUE) {
            // Stocker un message de succès dans la session
            $_SESSION['success_message'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";

            // Redirection vers la page de connexion
            header("Location: ../Connexion.html");
            exit(); // Arrêter l'exécution du script après la redirection
        } else {
            echo "Erreur lors de l'inscription : " . $conn->error;
        }
    }
}

$conn->close();
?>
