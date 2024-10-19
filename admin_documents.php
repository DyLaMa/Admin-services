<?php
session_start();
include '../Admin-services/Auth/db.php'; // Connexion à la base de données

// Vérifier si l'utilisateur est administrateur
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {

    // Mise à jour de l'état du document et du rôle utilisateur
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['document_id']) && isset($_POST['etat_document'])) {
            $document_id = mysqli_real_escape_string($conn, $_POST['document_id']);
            $etat_document = mysqli_real_escape_string($conn, $_POST['etat_document']);
            $update_query = "UPDATE documents SET etat_document = '$etat_document' WHERE id = '$document_id'";
            $conn->query($update_query);
        }

        if (isset($_POST['user_id']) && isset($_POST['role'])) {
            $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
            $role = mysqli_real_escape_string($conn, $_POST['role']);
            $update_role_query = "UPDATE users SET role = '$role' WHERE id = '$user_id'";
            $conn->query($update_role_query);
        }
    }

    $documents = $conn->query("SELECT * FROM documents");
    $users = $conn->query("SELECT * FROM users");
    ?>

    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestion des Documents et Utilisateurs</title>
        <link rel="stylesheet" href="Style_admin.css">
    </head>
    <body>

    <header>
        <nav>
            <div class="logo">
                <a href="../index.html">
                    <img src="Media/ADMIN-SERVICES.svg" alt="Logo Admin-Services">
                </a>
            </div>
            <ul>
                <li><a href="../index.html">Accueil</a></li>
                <li><a href="#">Demander un document</a></li>
                <li><a href="../Admin-services/Auth/logout.php">Déconnexion</a></li>
            </ul>
        </nav>
        <h1>Gestion des Documents et Utilisateurs</h1>
    </header>

    <div class="container">
        <h2>Documents</h2>
        <table>
            <tr>
                <th>Nom du Document</th>
                <th>Type</th>
                <th>État</th>
                <th>Changer l'état</th>
            </tr>
            <?php while ($row = $documents->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['file_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['document_type']); ?></td>
                    <td><?php echo htmlspecialchars($row['etat_document']); ?></td>
                    <td>
                        <form method="POST" action="">
                            <select name="etat_document">
                                <option value="Authentifié" <?php if ($row['etat_document'] === 'Authentifié') echo 'selected'; ?>>Authentifié</option>
                                <option value="En cours d'authentification" <?php if ($row['etat_document'] === 'En cours d\'authentification') echo 'selected'; ?>>En cours d'authentification</option>
                                <option value="Non validé" <?php if ($row['etat_document'] === 'Non validé') echo 'selected'; ?>>Non validé</option>
                            </select>
                            <input type="hidden" name="document_id" value="<?php echo $row['id']; ?>">
                            <button type="submit">Mettre à jour</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <h2>Utilisateurs</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Changer le rôle</th>
            </tr>
            <?php while ($user_row = $users->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($user_row['id']); ?></td>
                    <td><?php echo htmlspecialchars($user_row['nom']); ?></td>
                    <td><?php echo htmlspecialchars($user_row['email']); ?></td>
                    <td><?php echo htmlspecialchars($user_row['role']); ?></td>
                    <td>
                        <form method="POST" action="">
                            <select name="role">
                                <option value="admin" <?php if ($user_row['role'] === 'admin') echo 'selected'; ?>>Admin</option>
                                <option value="utilisateur" <?php if ($user_row['role'] === 'utilisateur') echo 'selected'; ?>>Utilisateur</option>
                            </select>
                            <input type="hidden" name="user_id" value="<?php echo $user_row['id']; ?>">
                            <button type="submit">Mettre à jour</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    </body>
    </html>

    <?php
} else {
    echo "<p>Accès refusé. Vous n'êtes pas administrateur.</p>";
}

$conn->close();
?>
