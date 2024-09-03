<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Forum</title>
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

    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        // Rediriger vers la page de connexion si non connecté
        header("Location: login.php");
        exit;
    }

    // Récupérer les informations de l'utilisateur connecté
    $username = $_SESSION['username'] ?? '';
    $profileImage = $_SESSION['profile_image'] ?? '';
    $user_id = $_SESSION['id'] ?? ''; // Assurez-vous que user_id est stocké dans la session
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $forum_name = $_POST['forum_name'];
        $location = $_POST['location'];
        $description = $_POST['description'];
        $event_date = $_POST['event_date'];
        $created_by = $username;

        // Handle the image as a BLOB
        $imageBlob = null;
        if (isset($_FILES['forum_image']) && $_FILES['forum_image']['error'] == 0) {
            $imageBlob = file_get_contents($_FILES['forum_image']['tmp_name']);
        }

        try {
            // Store the image as a BLOB in the database
            $stmt = $pdo->prepare("INSERT INTO Forum (title, picture, description, location, event_date, user_id, created_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$forum_name, $imageBlob, $description, $location, $event_date, $user_id, $username]);

              // Ajouter le rôle "Organisateur d'Événements" à l'utilisateur
            $stmt = $pdo->prepare("SELECT roles FROM User WHERE id = ?");
            $stmt->execute([$user_id]);
            $currentRolesJson = $stmt->fetchColumn();

            $currentRolesArray = json_decode($currentRolesJson, true) ?: [];
            $newRole = "Organisateur d'Événements";

            if (!in_array($newRole, $currentRolesArray)) {
                $currentRolesArray[] = $newRole;
                $newRolesJson = json_encode($currentRolesArray);
                $stmt = $pdo->prepare("UPDATE User SET roles = ? WHERE id = ?");
                $stmt->execute([$newRolesJson, $user_id]);
            }

            // Redirection après l'insertion
            header("Location: events.php");
            exit;
        } catch (PDOException $e) {
            echo "Erreur SQL: " . $e->getMessage();
        }

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
                    <h3 style="font-weight: normal; font-size: larger;"><?php echo htmlspecialchars($username); ?></h3>
                </div>
                <a href="profile.php" class="sub-menu-link" style="font-weight:normal; text-decoration: none;">
                    <img src="img/profile.png" alt="">
                    <p style="height: 10px;">Profil</p>
                    <span>></span>
                </a>
                <a href="#" class="sub-menu-link" style="font-weight:normal; text-decoration: none;">
                    <img src="img/setting.png" alt="">
                    <p style="height: 10px;">Paramètres & Sécurité</p>
                    <span>></span>
                </a>
                <a href="#" class="sub-menu-link" style="font-weight: normal; text-decoration: none;">
                    <img src="img/help.png" alt="">
                    <p style="height: 10px;">Aide & Support</p>
                    <span>></span>
                </a>
                <a href="logout.php" class="sub-menu-link" style="font-weight: normal; text-decoration: none;">
                    <img src="img/logout.png" alt="">
                    <p style="height: 10px;">Déconnexion</p>
                    <span>></span>
                </a>
            </div>
        </div>
    </nav>

    <div class="container centered-card">
        <div class="card card-custom" style="max-width: 600px; width: 100%; margin-top: -150px;">
            <div class="card-body">
                <center>
                    <h3 class="card-title">Créer un Forum</h3>
                </center>
                <br />
                <form id="forum-form" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="forum-name" class="form-label">Nom du Forum</label>
                        <input type="text" class="form-control" id="forum-name" name="forum_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Lieu</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                    <div class="mb-3">
                        <label for="event-date" class="form-label">Date de l'Événement</label>
                        <input type="date" class="form-control" id="event-date" name="event_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="forum-image" class="form-label">Télécharger une Image</label>
                        <input type="file" class="form-control" id="forum-image" name="forum_image" accept="image/*">
                        <img id="image-preview" class="preview-image mt-3 d-none" alt="Aperçu de l'image"
                            style="max-height:150px">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-disabled" id="next-button"
                        disabled>Suivant</button>
                </form>
            </div>
            <div class="card-footer">
                <div class="progress">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 0%;" aria-valuenow="0"
                        aria-valuemin="0" aria-valuemax="100"></div>
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
    <!-- Bootstrap JS and dependencies via CDN (version 5.3) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>

    <!-- Custom Script -->
    <script>
        // Mise à jour de la barre de progression
        function updateProgressBar() {
            const forumName = document.getElementById('forum-name').value.trim();
            const location = document.getElementById('location').value.trim();
            const description = document.getElementById('description').value.trim();
            const eventDate = document.getElementById('event-date').value.trim();
            const progressBar = document.querySelector('.progress-bar');
            const progress = calculateProgress(forumName, location, description, eventDate);
            progressBar.style.width = `${progress}%`;
            progressBar.setAttribute('aria-valuenow', progress);
        }

        function calculateProgress(forumName, location, description, eventDate) {
            let progress = 0;
            if (forumName) progress += 25;
            if (location) progress += 25;
            if (description) progress += 25;
            if (eventDate) progress += 25;
            return progress;
        }

        document.getElementById('forum-form').addEventListener('input', () => {
            const forumName = document.getElementById('forum-name').value.trim();
            const location = document.getElementById('location').value.trim();
            const description = document.getElementById('description').value.trim();
            const eventDate = document.getElementById('event-date').value.trim();
            const nextButton = document.getElementById('next-button');

            if (forumName && location && description && eventDate) {
                nextButton.classList.remove('btn-disabled');
                nextButton.classList.add('btn-enabled');
                nextButton.disabled = false;
            } else {
                nextButton.classList.remove('btn-enabled');
                nextButton.classList.add('btn-disabled');
                nextButton.disabled = true;
            }
            updateProgressBar();
        });

        // Gestion de l'aperçu de l'image
        document.getElementById('forum-image').addEventListener('change', function () {
            const preview = document.getElementById('image-preview');
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    preview.classList.add('d-block');
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.classList.remove('d-block');
                preview.classList.add('d-none');
            }
        });

        // Soumission AJAX
        document.getElementById('forum-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Le forum a été créé avec succès !');
                        window.location.href = 'events.php'; // Redirection ici
                    } else {
                        alert('Une erreur est survenue lors de la création du forum : ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue lors de la soumission du formulaire.');
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

</body>

</html>