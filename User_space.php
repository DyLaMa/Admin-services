<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Utilisateur - Admin-Services</title>
    <link rel="stylesheet" href="Style_user.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <a href="index.html">
                    <img src="Media/ADMIN-SERVICES.svg" alt="Logo Admin-Services">
                </a>
            </div>
            <ul>
                <li><a href="index.html">Accueil</a></li>
                <li><a href="#">Demander un document</a></li>
                <li><a href="../Admin-services/index.html">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <section class="form-section">
        <h2>Ajouter un Document</h2>
        <form action="../Admin-services/Auth/loader.php" method="POST" enctype="multipart/form-data">
            <label for="document-type">Sélectionner un type de document :</label>
            <select id="document-type" name="document-type">
                <option value="cni">Carte d'identité nationale</option>
                <option value="passport">Passeport</option>
                <option value="permis">Permis de conduire</option>
                <option value="livret">Livret de famille</option>
                <option value="naissance">Acte de naissance</option>
                <option value="rib">RIB</option>
                <option value="diplome">Diplôme</option>
            </select>

            <label for="document">Téléverser votre document :</label>
            <input type="file" id="document" name="document" accept="application/pdf, image/*" required>

            <button type="submit">Envoyer</button>
        </form>
    </section>

    <!-- Section pour afficher les documents stockés -->
    <section class="document-list-section">
        <h2>Documents Stockés</h2>
        <div class="document-list">
        <?php
        session_start();
        include '../Admin-services/Auth/db.php'; // Assurez-vous que le chemin de db.php est correct

        // Affichage de l'alerte de succès
        if (isset($_SESSION['success_message'])) {
            echo "<script>alert('" . $_SESSION['success_message'] . "');</script>";
            // Supprimer le message de succès de la session après l'affichage
            unset($_SESSION['success_message']);
        }

        // Vérifier si l'utilisateur est connecté et récupérer son ID
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            // Requête pour récupérer les documents de l'utilisateur
            $query = "SELECT * FROM documents WHERE user_id = '$user_id'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                echo "<ul>";
                while ($row = $result->fetch_assoc()) {
                    // Le chemin complet pour le lien est directement issu de la base de données
                    $file_path = htmlspecialchars($row['file_path']);

                    // Affichage du lien avec le chemin complet
                    echo "<li>";
                    echo "<strong>" . htmlspecialchars($row['document_type']) . "</strong>: ";
                    echo "<a href='" . $file_path . "' target='_blank'>" . htmlspecialchars($row['file_name']) . "</a>";
                    echo "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Aucun document trouvé.</p>";
            }
        } else {
            echo "<p>Erreur : utilisateur non connecté.</p>";
        }

        $conn->close();
        ?>


        </div>
    </section>

    <footer>
        <p>Contact : +221 77 XX9 9X 00</p>
        <p>Email : admin-service@gmail.com</p>
        <p>&copy; 2024 Admin-Services. Tous droits réservés.</p>
    </footer>
</body>
</html>
