<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="profil.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="logo" href="img/logo.png">
    <style>
        /* Styles pour la modale */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            width: 50%;
            max-width: 600px;
            text-align: center;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .modal-content img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid transparent;
            margin: 10px;
            cursor: pointer;
            transition: border-color 0.3s;
        }

        .modal-content img.selected {
            border-color: #007bff;
        }

        .modal-content button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
        }

        .modal-content button:hover {
            background-color: #0056b3;
        }

        .close-btn {
            float: right;
            font-size: 1.5rem;
            color: #aaa;
            cursor: pointer;
        }

        .close-btn:hover {
            color: #000;
        }
    </style>
</head>

<?php
session_start();
require_once('config.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Établir la connexion à la base de données
$conn = new mysqli('localhost', 'root', 'root', 'fplanner');

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

// Récupérer l'ID utilisateur
$stmt = $conn->prepare("SELECT id FROM user WHERE name = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$stmt->bind_result($userId);
$stmt->fetch();
$stmt->close();

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

// Gestion de la mise à jour de la photo de profil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['selected_image'])) {
    $selectedImagePath = $_POST['selected_image'];

    // Mettre à jour la photo de profil dans la base de données
    $stmt = $conn->prepare("UPDATE user SET pfp = ? WHERE name = ?");
    $stmt->bind_param("ss", $selectedImagePath, $_SESSION['username']);

    if ($stmt->execute()) {
        $_SESSION['profile_image'] = $selectedImagePath;
    } else {
        echo "Erreur lors de la mise à jour de la photo de profil.";
    }

    $stmt->close();
}

// Récupérer les forums de l'utilisateur
$stmt = $conn->prepare("SELECT title, event_date, location FROM forum WHERE user = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Assurez-vous de libérer les résultats avant de préparer une nouvelle requête
if ($result) {
    $result->free();
}

// Récupérer les informations de l'utilisateur depuis la base de données
$stmt = $conn->prepare("SELECT name, email, password, pfp FROM user WHERE name = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$stmt->bind_result($username, $email, $password, $profileImage);
$stmt->fetch();
$stmt->close();

// Les informations de l'utilisateur sont déjà dans la session
// Vous pouvez choisir de les utiliser directement sans faire de nouvelles requêtes
$username = $_SESSION['username'];
$email = $_SESSION['email'] ?? '';
$password = $_SESSION['password'] ?? '';
$profileImage = $_SESSION['profile_image'] ?? 'pfp/default.png';

// Récupérer les rôles de l'utilisateur depuis la base de données
$rolesJson = null; // Initialisation de la variable
$stmt = $conn->prepare("SELECT roles FROM user WHERE name = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$stmt->bind_result($rolesJson);
$stmt->fetch();
$stmt->close();
$conn->close();

// Décoder le JSON en tableau PHP
$rolesArray = json_decode($rolesJson, true);

// Assurer que le décodage a réussi et que $rolesArray est un tableau
if (json_last_error() !== JSON_ERROR_NONE) {
    $rolesArray = []; // Utiliser un tableau vide en cas d'erreur de décodage
}

// Convertir le tableau en une chaîne de caractères pour affichage
$roles = implode(', ', $rolesArray);
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

    <header>
        <div class="welcome-banner" style="height: 200px;">
            <div style="margin-top: 100px; padding-left: 20px">
                <h1>Bienvenue</h1>
                <p><strong><?php echo htmlspecialchars($username); ?></strong></p>
                <p><?php echo htmlspecialchars($roles); ?></p>
            </div>
        </div>
    </header>

    <main class="container mt-4">
        <section class="orders">
            <h2>Mes Évènements et Forums</h2>
            <div class="row">
                <?php if (empty($forums)): ?>
                    <p>Aucun forum trouvé.</p>
                <?php else: ?>
                    <?php foreach ($forums as $forum): ?>
                        <div class="col-md-6">
                            <div class="order">
                                <div class="order-info">
                                    <!-- La date -->
                                    <p><strong><?php echo date('j F Y', strtotime($forum['event_date'])); ?></strong></p>
                                    <!-- Le nom -->
                                    <p><?php echo htmlspecialchars($forum['title']); ?></p>
                                    <!-- Le lieu -->
                                    <p><i><?php echo htmlspecialchars($forum['location']); ?></i></p>
                                </div>
                                <div class="suscriber">
                                    <p><?php echo number_format($forum['groupes']); ?> groupes</p>
                                    <a href="#">Voir le détail</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>


        <section class="profile">
            <h2>Mon Profil</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="profile-item">
                        <div class="container mt-4">
                            <div class="row align-items-center mb-4">
                                <div class="col-auto">
                                    <img src="img/profile.png" alt="profil" class="img-fluid"
                                        style="width: 30px; height: auto;">
                                </div>
                                <div class="col">
                                    <h3>Vos Informations Personnelles</h3>
                                </div>
                            </div>

                            <div class="profile-details">
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-4">
                                        <p><strong>Votre Photo de Profil :</strong></p>
                                    </div>
                                    <div class="col-md-4">
                                        <img id="current-profile" src="<?php echo htmlspecialchars($profileImage); ?>"
                                            alt="Current Profile" class="img-fluid"
                                            style="max-height: 150px; max-width: 150px;">
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <a onclick="openModal()"
                                            style="text-decoration: none ; color: #004526; font-weight: bold; cursor: pointer;">Changer
                                            de photo ?</a>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <p><strong>Nom:</strong> <?php echo htmlspecialchars($username); ?></p>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <p><strong>Mail:</strong> <?php echo htmlspecialchars($email); ?></p>
                                    </div>
                                </div>
                            </div>
                            <a href="#">Modifier</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-item">
                        <div class="container mt-4">
                            <div class="row align-items-center mb-4">
                                <div class="col-auto">
                                    <img src="img/setting.png" alt="profil" class="img-fluid"
                                        style="width: 30px; height: auto;">
                                </div>
                                <div class="col">
                                    <h3>Adresse Mail & Mot de passe</h3>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <p><strong>Adresse mail:</strong> <?php echo htmlspecialchars($email); ?></p>
                            </div>
                            <div class="row mb-2">
                                <p><strong>Mot de passe:</strong></p>
                            </div>
                        </div>
                        <a href="#">Modifier</a>
                    </div>
                </div>
            </div>
        </section>

        </div>

        <!-- Modale de sélection -->
        <div id="profileModal" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <h2 style="padding-left: 30px">Choisissez votre photo de profil</h2>
                <form id="profileForm" method="POST">
                    <div style="padding-left: 5px">
                        <img src="pfp/dino1.png" class="profile-option" alt="Dino 1" data-src="pfp/dino1.png"
                            style="max-height: 150px;">
                        <img src="pfp/dino2.png" class="profile-option" alt="Dino 2" data-src="pfp/dino2.png"
                            style="max-height: 150px;">
                        <img src="pfp/dino3.png" class="profile-option" alt="Dino 3" data-src="pfp/dino3.png"
                            style="max-height: 150px;">
                        <img src="pfp/dino4.png" class="profile-option" alt="Dino 4" data-src="pfp/dino4.png"
                            style="max-height: 150px;">
                        <img src="pfp/dino5.png" class="profile-option" alt="Dino 5" data-src="pfp/dino5.png"
                            style="max-height: 150px;">
                        <img src="pfp/dino6.png" class="profile-option" alt="Dino 6" data-src="pfp/dino6.png"
                            style="max-height: 150px;">
                        <img src="pfp/dino7.png" class="profile-option" alt="Dino 7" data-src="pfp/dino7.png"
                            style="max-height: 150px;">
                        <img src="pfp/dino8.png" class="profile-option" alt="Dino 8" data-src="pfp/dino8.png"
                            style="max-height: 150px;">
                        <img src="pfp/dino9.png" class="profile-option" alt="Dino 9" data-src="pfp/dino9.png"
                            style="max-height: 150px;">
                        <img src="pfp/dinoSP.png" class="profile-option" alt="Dino SP" data-src="pfp/dinoSP.png"
                            style="max-height: 150px;">
                        <img src="pfp/EB.png" class="profile-option" alt="EB" data-src="pfp/EB.png"
                            style="max-height: 150px;">
                        <img src="pfp/DT.png" class="profile-option" alt="Default" data-src="pfp/DT.png"
                            style="max-height: 150px;">
                        <img src="pfp/default.png" class="profile-option" alt="Default" data-src="pfp/default.png"
                            style="max-height: 150px;">
                    </div>
                    <input type="hidden" name="selected_image" id="selected_image">
                    <button type="submit">Valider</button>
                </form>
            </div>
    </main>

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
        // Ouvre la modale
        function openModal() {
            document.getElementById('profileModal').style.display = 'flex';
        }

        // Ferme la modale
        function closeModal() {
            document.getElementById('profileModal').style.display = 'none';
        }
        // N'ouvre pas la modale automatiquement lors du chargement de la page
        document.addEventListener("DOMContentLoaded", function () {
            const images = document.querySelectorAll('.profile-option');
            const hiddenInput = document.getElementById('selected_image');
            const profileModal = document.getElementById('profileModal');

            // Assurez-vous que la modale est cachée au chargement de la page
            profileModal.style.display = "none";


            // Gestion de la sélection de l'image
            images.forEach(img => {
                img.addEventListener('click', function () {
                    // Retirer la sélection actuelle
                    images.forEach(img => {
                        img.classList.remove('selected');
                    });

                    // Ajouter la classe 'selected' à l'image cliquée
                    this.classList.add('selected');

                    // Mettre à jour la valeur de l'image sélectionnée dans le formulaire
                    hiddenInput.value = this.getAttribute('data-src');
                });
            });

            // Gestion de la soumission du formulaire
            document.getElementById('profileForm').addEventListener('submit', function (event) {
                event.preventDefault(); // Empêche le rechargement de la page

                // Logique de validation et soumission du formulaire
                if (document.getElementById('selected_image').value) {
                    // Simuler une soumission du formulaire
                    console.log('Image sélectionnée:', document.getElementById('selected_image').value);

                    // Soumettre le formulaire en utilisant AJAX ou en le permettant normalement
                    this.submit(); // Cette ligne soumet le formulaire

                    // Fermer la modale après la soumission
                    closeModal();
                } else {
                    alert('Veuillez sélectionner une image de profil.');
                }
            });
        });

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
    <!-- Inclusion du script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>

</html>