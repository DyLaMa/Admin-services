<?php
session_start(); // Démarrer la session

// Inclure la connexion à la base de données
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer l'ID de l'utilisateur connecté
    $user_id = $_SESSION['user_id']; // L'ID utilisateur est stocké dans la session

    // Récupérer le type de document sélectionné
    $document_type = mysqli_real_escape_string($conn, $_POST['document-type']);

    // Création du dossier de stockage en local (pour le système de fichiers)
    $storage_dir = "../Doc/$document_type/"; // Exemple: ../Doc/RIB/
    if (!is_dir($storage_dir)) {
        mkdir($storage_dir, 0777, true); // Créer le dossier s'il n'existe pas
    }

    // Gestion du fichier téléversé
    $file = $_FILES['document'];
    $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION); // Récupérer l'extension du fichier
    $file_name = $user_id . "_" . $document_type . "." . $file_ext; // Nom du fichier généré (ex: 123_RIB.pdf)

    // Chemin complet pour stocker localement
    $local_file_path = $storage_dir . $file_name; // Ex: ../Doc/RIB/123_RIB.pdf

    // Chemin complet à stocker dans la base de données (chemin public pour le web)
    $db_file_path = "/Admin-services/Doc/$document_type/" . $file_name; // Ex: /Admin-services/Doc/RIB/123_RIB.pdf

    // Vérifier si le fichier a été bien téléversé
    if (move_uploaded_file($file['tmp_name'], $local_file_path)) {
        // Insérer ou mettre à jour le document dans la base de données avec le chemin complet
        $insert_or_update_query = "INSERT INTO documents (user_id, document_type, file_name, file_path) 
                                   VALUES ('$user_id', '$document_type', '$file_name', '$db_file_path')
                                   ON DUPLICATE KEY UPDATE 
                                   file_name = '$file_name', file_path = '$db_file_path', created_at = NOW()";

        if ($conn->query($insert_or_update_query) === TRUE) {
            // Stocker un message de succès dans la session
            $_SESSION['success_message'] = "Document ajouté avec succès.";
            
            // Redirection après un téléversement réussi
            header("Location: ../User_space.php");
            exit(); // Arrêter le script après la redirection
        } else {
            echo "Erreur lors de l'enregistrement dans la base de données : " . $conn->error;
        }
    } else {
        echo "Erreur lors du téléversement du fichier.";
    }
}

$conn->close();
?>
