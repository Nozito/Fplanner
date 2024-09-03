<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="logo" href="img/logo.png">
    <title>Page de connexion</title>
    <?php
    require 'config.php'; // Assurez-vous que ce fichier contient bien la définition de $pdo

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = isset($_POST['action']) ? $_POST['action'] : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
    
        if ($action === 'register') {
            // Inscription
            $name = trim($_POST['nom']);
            $password = $_POST['password'];
    
            // Vérifier si l'email existe déjà dans la base de données
            $query = $pdo->prepare('SELECT id FROM user WHERE email = :email');
            $query->execute(['email' => $email]);
            $user = $query->fetch();
    
            if ($user) {
            } else {
                // Hash du mot de passe pour la sécurité
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
                // Insertion du nouvel utilisateur
                $stmt = $pdo->prepare('INSERT INTO user (name, email, password, roles, owned_groups_id) VALUES (:name, :email, :password, :roles, :owned_groups_id)');
                $stmt->execute([
                    'name' => $name,
                    'email' => $email,
                    'password' => $hashedPassword,
                    'roles' => json_encode(['Visiteur']), // Rôle par défaut
                    'owned_groups_id' => json_encode([]), // Aucune propriété de groupe par défaut
                ]);
    
                header("Location: index.php");
                exit;
            }
        } elseif ($action === 'login') {
            // Traitement de la connexion
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            // Vérification des identifiants
            $query = $pdo->prepare('SELECT * FROM user WHERE email = ?');
            $query->execute([$email]);
            $user = $query->fetch();
    
            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $user['name']; // Utilisation du champ "name"
                header("Location: index.php");
                exit;
            } else {
                echo "Email ou mot de passe incorrect.";
            }
        }
    }
?>
</head>
<style>
nav {
    background: #000000;
    width: 100%;
    padding: 10px 10%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    z-index: 1000;

}

/* Style pour le conteneur principal */
.container {
    display: flex;
    flex-direction: column; /* Assurez-vous que les éléments enfants sont empilés verticalement */
    justify-content: center;
    align-items: center;
    margin-top: 60px; /* Assurez-vous que le contenu n'est pas caché sous la navbar */
    margin-bottom: 150px; /* Augmentez cet espace pour que le contenu soit plus haut par rapport au footer */
    padding-top: 10px; /* Ajustez selon vos besoins */
    padding-bottom: 10px; /* Espace pour que le contenu ne touche pas le footer */
}

.footer {
  position: static;
  bottom: 0;
  left: 0;
  width: 100%;
  background: #000000;
  border-radius: 0;
  z-index: 1000; /* S'assurer qu'il reste au-dessus du contenu */
  padding: 20px; /* Ajuste le padding pour réduire la hauteur */
}
</style>
<body>

<nav style="height: 60px">
        <img src="img/logo.png" alt="logo" style="max-height: 40px;" href="index.html">
        <ul style="max-height: 30px;">
            <li><a href="index.php" style="font-weight: lighter; text-decoration: none;">Accueil</a></li>
            <li><a href="events.php" style="font-weight: lighter; text-decoration: none;">Évènements</a></li>
            <li><a href="groups.php" style="font-weight: lighter; text-decoration: none;">Groupes</a></li>
        </ul>
        <img src="<?php echo htmlspecialchars($profileImage); ?>" alt="user-pic" id="profileImage"
            style="max-height: 40px; cursor: pointer;">


        <div class="sub-menu-wrap" id="subMenu">
            <div class="sub-menu">
                <div class="user-info">
                    <img src="<?php echo htmlspecialchars($profileImage); ?>" alt="user-pic"
                        style="max-height: 60px; margin-right: 10px;">
                    <h3 style="font-weight: normal; font-size:larger;"><?php echo htmlspecialchars($username); ?></h3>
                </div>
                <a href="profile.php" class="sub-menu-link" style="font-weight:normal; text-decoration: none;">
                    <img src="img/profile.png" alt=""">
                <p style=" height: 10px;">Profil</p>
                    <span>></span>
                </a>
                <a href=" #" class="sub-menu-link" style="font-weight:normal; text-decoration: none;">
                    <img src="img/setting.png" alt=""">
                <p style=" height: 10px;">Paramètres & Sécurité</p>
                    <span>></span>
                </a>
                <a href=" #" class="sub-menu-link" style="font-weight: normal; text-decoration: none;">
                    <img src="img/help.png" alt=""">
                <p style=" height: 10px;">Aide & Support</p>
                    <span>></span>
                </a>
                <a href="logout.php" class="sub-menu-link" style="font-weight: normal; text-decoration: none;">
                    <img src="img/logout.png" alt=""">
                <p style=" height: 10px;">Déconnexion</p>
                    <span>></span>
                </a>
            </div>
        </div>
    </nav> 

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="login.php" method="POST">
                <h1>Créer un compte</h1>
                <br><br>
                <input type="text" name="nom" placeholder="Nom" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Mot de passe" required>
                <input type="hidden" name="action" value="register">
                <button type="submit">S'inscrire</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="login.php" method="POST">
                <h1>Se connecter</h1>
                <br><br>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Mot de passe" required>
                <input type="hidden" name="action" value="login">
                <div class="remember-me-container">
                    <input type="checkbox" id="remember-me">
                    <label for="remember-me">Se souvenir de moi ?</label>
                </div>

                <a href="404.html">Mot de passe oublié ?</a>
                <button>Se connecter</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Enfin de retour !</h1>
                    <p>Connectez vous à votre compte dès maintenant</p>
                    <button id="login">Se connecter</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Bienvenue !</h1>
                    <p>Inscrit toi pour pouvoir créer ou rejoindre un groupe ou un évènement</p>
                    <button id="register">S'inscrire</button>
                </div>
            </div>
        </div>
    </div>

    <section class=" footer">
        <div class="footer-row">
            <div class="footer-col">
                <img src="img/logo.png" alt="logo" style="max-height: 85px;">
                <h4>Forum Planner</h4>
                <p>
                    Subscribe to our newsletter for a weekly dose
                    of news, updates, helpful tips, and
                    exclusive offers.
                </p>
            </div>
            <div class="footer-col">
                <h4>A propos</h4>
                <ul class="links" style="margin-left: -34px;">
                    <li><a href="404.html" style="font-weight: normal;">Concept</a></li>
                    <li><a href="#" style="font-weight: normal;">Qui sommes-nous ?</a></li>
                    <li><a href="#" style="font-weight: normal;">FAQ</a></li>
                    <li><a href="#" style="font-weight: normal;">RGPD</a></li>
                    <li><a href="#" style="font-weight: normal;">CGI</a></li>
                    <li><a href="#" style="font-weight: normal;">Mentions Légales</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Nous recontrer</h4>
                <ul class="links" style="margin-left: -32px;">
                    <li><a href="404.html" style="font-weight: normal;">Presse</a></li>
                    <li><a href="contact.php" style="font-weight: normal;">Nous Contacter</a></li>
                    <li><a href="404.html" style="font-weight: normal;">Recruteurs</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>La Newsletter toujours dans les temps</h4>
                <p>
                    Subscribe to our newsletter for a weekly dose
                    of news, updates, helpful tips, and
                    exclusive offers.
                </p>
                <form action="#">
                    <input type="text" placeholder="Your email" required>
                    <button type="submit">SUBSCRIBE</button>
                </form>
                <div class="icons">
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-twitter"></i>
                    <i class="fa-brands fa-linkedin"></i>
                    <i class="fa-brands fa-github"></i>
                </div>
            </div>
        </div>
    </section>
    
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>
</html>