<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width= initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" type="logo" href="img/logo.png">
    <title>Events</title>
</head>

<?php
session_start();
require_once('config.php');

// Récupérer tous les événements du forum
$sql = "SELECT * FROM Forum ORDER BY id ASC";
$stmt = $pdo->query($sql);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les informations de l'utilisateur connecté
$username = $_SESSION['username'] ?? '';
$profileImage = $_SESSION['profile_image'] ?? '';

?>

<body>

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

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Forums</h1>
            <?php if (isset($_SESSION['username'])): ?>
                <!-- Afficher le bouton seulement si l'utilisateur est connecté -->
                <a href="new-event.php" class="btn btn-success">Créer un forum</a>
            <?php endif; ?>
        </div>
        
        <div class="row">
            <?php foreach ($events as $event): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                    <img src="display_image.php?id=<?php echo $event['id']; ?>" class="card-img-top" alt="Image de l'événement">
                    <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($event['description']); ?></p>
                            <p class="card-text"><small class="text-muted">Lieu: <?php echo htmlspecialchars($event['location']); ?></small></p>
                        </div>
                        <div class="card-footer text-center">
                            <a href="event_details.php?id=<?php echo $event['id']; ?>" class="btn btn-primary">Voir Détails</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
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
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>