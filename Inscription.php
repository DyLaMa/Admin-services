<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Admin-Services</title>
    <link rel="stylesheet" href="Style_inscription.css">
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
                <li><a href="Connexion.html">Connexion</a></li>
            </ul>
        </nav>
    </header>

    <section class="form-section">
        <h2>Inscription</h2>
        <form action="../Admin-services/Auth/inscription.php" method="POST">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>

            <label for="dob">Date de naissance :</label>
            <input type="date" id="dob" name="dob" required>

            <label for="phone">Numéro de téléphone :</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="email">Adresse mail :</label>
            <input type="email" id="email" name="email" required>

            <label for="cni">Numéro CNI ou Passeport :</label>
            <input type="text" id="cni" name="cni" required>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>

            <div class="checkbox-container">
                <input type="checkbox" id="show-password">
                <label for="show-password">Afficher le mot de passe</label>
            </div>

            <button type="submit">S'inscrire</button>
        </form>
        <p>Vous avez déjà un compte ? <a href="connexion.html">Connectez-vous</a></p>
    </section>


    <script>
        // Script pour afficher/masquer le mot de passe
        const showPasswordCheckbox = document.getElementById('show-password');
        const passwordInput = document.getElementById('password');
        
        showPasswordCheckbox.addEventListener('change', function() {
            if (this.checked) {
                passwordInput.type = 'text';  // Afficher le mot de passe
            } else {
                passwordInput.type = 'password';  // Masquer le mot de passe
            }
        });
        </script>

    <?php
    session_start(); // Démarrer la session pour accéder à $_SESSION

    // Afficher le message de succès s'il existe
    if (isset($_SESSION['success_message'])) {
        echo "<p style='color: green;'>" . $_SESSION['success_message'] . "</p>";
        // Supprimer le message de la session après l'affichage
        unset($_SESSION['success_message']);
    }
    ?>


    <footer>
        <p>Contact : +221 77 XX9 9X 00</p>
        <p>Email : admin-service@gmail.com</p>
        <p>&copy; 2024 Admin-Services. Tous droits réservés.</p>
    </footer>
</body>
</html>
