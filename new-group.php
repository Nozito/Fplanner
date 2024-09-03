<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Groupe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="logo" href="img/logo.png">

    <style>
        .centered-card {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .card-custom {
            background-color: #ffffff;
            /* Gris clair */
            border: 1px solid #ffffff;
            /* Bordure gris moyen */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            /* Ombre noire */
        }

        .btn-disabled {
            background-color: #6c757d;
            /* Gris pour le bouton désactivé */
            border-color: #6c757d;
        }

        .btn-enabled {
            background-color: #0d6efd;
            /* Bleu pour le bouton actif */
            border-color: #0d6efd;
            color: white;
        }

        body {
            background-color: #c9d6ff;
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
        }
    </style>
</head>
<body>
<?php
session_start();
require_once('config.php');

// Récupérer les groupes ou l'utilisateur connecté est du forum
$sql = "SELECT * FROM groupe ORDER BY id ASC";
$stmt = $pdo->query($sql);
$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les informations de l'utilisateur connecté
$username = $_SESSION['username'] ?? '';
$profileImage = $_SESSION['profile_image'] ?? '';

// Vérifier si l'utilisateur a choisi une photo de profil
if (!isset($_SESSION['profile_image'])) {
    // Utiliser la photo de profil par défaut
    $_SESSION['profile_image'] = 'pfp/default.png';
}
?>

<nav style="height: 60px;">
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

    <div class="container centered-card">
        <div class="card card-custom" style="max-width: 600px; width: 100%; margin-top: -150px;">
            <div class="card-body">
                <h2 class="card-title">Créer un Groupe</h2>
                <form method="post" action="create_group.php">
            <div class="mb-3">
                <label for="group-name" class="form-label">Nom du Groupe</label>
                <input type="text" class="form-control" id="group-name" name="group_name" required>
            </div>
            <div class="mb-3">
                <label for="members" class="form-label">Membres (séparés par des virgules)</label>
                <input type="text" class="form-control" id="members" name="members">
            </div>
            <button type="submit" class="btn btn-primary">Créer le Groupe</button>
        </form>
            </div>
    </div>

    <script>
        //Menu user-info
        document.addEventListener("DOMContentLoaded", function () {
                   let subMenu = document.getElementById('subMenu');
       
                   function toggleMenu() {
                       subMenu.classList.toggle("open-menu");
                   }
       
                   // Attacher l'événement de clic à l'image en utilisant l'ID
                   document.getElementById('profileImage').addEventListener('click', toggleMenu);
               });
       </script>
       </body>
       <section class=" footer" style="margin-top: 100px">
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
           <!-- Inclusion du script Bootstrap -->
           <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
               integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
               crossorigin="anonymous"></script>
           <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
               integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
               crossorigin="anonymous"></script>
</body>
</html>