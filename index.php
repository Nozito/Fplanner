<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forum Planner</title>
  <link href="style.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="icon" type="logo" href="img/logo.png">
</head>

<?php
session_start();
require_once('config.php');

// Récupérer les informations de l'utilisateur connecté
$username = $_SESSION['username'] ?? '';
$profileImage = $_SESSION['profile_image'] ?? '';

// Requête pour obtenir les 3 événements les plus récents
$sql = "SELECT title, picture, description, location
        FROM Forum 
        ORDER BY Id ASC 
        LIMIT 6";

$stmt = $pdo->query($sql);
$recentEvents = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Établir la connexion à la base de données
$conn = new mysqli('localhost', 'root', 'root', 'fplanner');


// Vérifier si l'utilisateur a choisi une photo de profil
if (!isset($_SESSION['profile_image'])) {
    // Récupérer la photo de profil depuis la base de données
    $stmt = $conn->prepare("SELECT pfp FROM user WHERE name = ?");
    $stmt->bind_param("s", $_SESSION['username']);
    $stmt->execute();
    $stmt->bind_result($profileImage);
    $stmt->fetch();
    $_SESSION['profile_image'] = $profileImage ?? 'pfp/default.png';
    $stmt->close();
}
?>
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
<style>
  header {
  background-image: linear-gradient(rgba(24, 34, 77, 0.7), rgba(0, 116, 248, 0.7)), url('img/texture.jpg');
  background-size: cover;
  background-position: center;
  color: white;
  padding: 10px;
  text-align: left;
  position: relative;
}
</style>

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

          <!-- Header Section -->
          <header class="header text-center text-white d-flex flex-column justify-content-center align-items-center"
            style="background-image: url('img/texture.jpg') linear-gradient(rgba(24, 34, 77, 0.7), rgba(0, 116, 248, 0.7)); height: 1000px;">
            <div class="row">
              <div class="col-lg" style="margin-left: 755px; color: azure;">
                <img src="img/logo.png" alt="Logo Forum Planner" class="mb-4" style="max-height: 350px; margin-top: -150px; margin-right: 800px;">
                <center style="margin-right: 775px;">
                  <h1 style="font-size: large; font-weight: 900; font-size: 80px;">FORUM PLANNER</h1>
                  <br />
                  <p>L’application fait pour organiser, réserver vos meilleurs événements de manière sécurisée et simplifiée.</p>
                  <br />
                  <a href="new-event.php" class="btn btn-light">Créez le votre dès maintenant !</a>
                </center>
              </div>
            </div>
          </header>

          <!-- Section des Nouveautés -->
<section class="recent-events py-5">
    <div class="container">
        <h2 class="text-center mb-5" style="font-weight: bold;">Les Nouveautés</h2>
        <div id="recentEventsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row">
                        <?php foreach ($recentEvents as $event): ?>
                            <div class="col-md-4">
                                <div class="card shadow-sm">
                                    <div class="event-image bg-light" 
                                         style="background-image: url('<?= htmlspecialchars($event['picture']); ?>'); height: 200px; background-size: cover;"></div>
                                    <div class="card-body text-center">
                                        <h5 class="card-title" style="font-weight: bold;"><?= htmlspecialchars($event['title']); ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($event['description']); ?></p>
                                        <p class="card-text"><small class="text-muted">Lieu: <?= htmlspecialchars($event['location']); ?></small></p>
                                        <a href="#" class="btn btn-primary">S'inscrire</a>
                                        <a href="#" class="btn btn-primary">Consulter l'évènement</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

        <!-- Section des Avis -->
        <section class="recent-events py-5">
          <div class="container">
              <h2 class="text-center mb-5" style="font-weight: bold;">Les Avis</h2>
              <div id="recentEventsCarousel" class="carousel slide" data-bs-ride="carousel">
                  <div class="carousel-inner">
                      <!-- Slide 1 -->
                      <div class="carousel-item active">
                          <div class="row">
                              <div class="col-md-4">
                                  <div class="card shadow-sm">
                                      <div class="card-body text-center">
                                          <h5 class="card-title">TESLA</h5>
                                          <p class="card-text">J'ai adoré, l'application est simple et facile à utiliser. Mais je crois qu'ils ne sont pas fan de l'éléctrique...</p>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="card shadow-sm">
                                      <div class="card-body text-center">
                                          <h5 class="card-title">APPLE</h5>
                                          <p class="card-text">Great, like us</p>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="card shadow-sm">
                                      <div class="card-body text-center">
                                          <h5 class="card-title">MICROSOFT</h5>
                                          <p class="card-text">Super application, tout fonctionne correctement et nous avons pu réaliser un très beau forum</p>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <!-- Slide 2 -->
                      <div class="carousel-item">
                          <div class="row">
                              <div class="col-md-4">
                                  <div class="card shadow-sm">
                                      <div class="card-body text-center">
                                          <h5 class="card-title">INSTAGRAM</h5>
                                          <p class="card-text">Super application, tout fonctionne correctement et nous avons pu réaliser un très beau forum</p>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="card shadow-sm">
                                      <div class="card-body text-center">
                                          <h5 class="card-title">SNAPCHAT</h5>
                                          <p class="card-text">Super application, tout fonctionne correctement et nous avons pu réaliser un très beau forum</p>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="card shadow-sm">
                                      <div class="card-body text-center">
                                          <h5 class="card-title">X</h5>
                                          <p class="card-text">Super application, tout fonctionne correctement et nous avons pu réaliser un très beau forum</p>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </section>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
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
                    <li><a href="loading.html" style="font-weight: normal;">Qui sommes-nous ?</a></li>
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
</html>