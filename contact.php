<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nous contacter</title>
    <link href="contact.css" rel="stylesheet">
    <link rel="icon" type="logo" href="img/logo.png">
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<?php
session_start();
require_once('config.php');

// Récupérer les informations de l'utilisateur connecté
$username = $_SESSION['username'] ?? '';
$profileImage = $_SESSION['profile_image'] ?? '';

// Vérifier si l'utilisateur a choisi une photo de profil
if (!isset($_SESSION['profile_image'])) {
    // Utiliser la photo de profil par défaut
    $_SESSION['profile_image'] = 'pfp/default.png';
}
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

        <div class="contact_us_green">
        <div class="responsive-container-block big-container">
            <div class="responsive-container-block container">
                <div class="responsive-cell-block wk-tab-12 wk-mobile-12 wk-desk-7 wk-ipadp-10 line" id="i69b-2">
                    <form class="form-box">
                        <div class="container-block form-wrapper">
                            <div class="head-text-box">
                                <p class="text-blk contactus-head">
                                    Contactez-nous
                                </p>
                                <p class="text-blk contactus-subhead">
                                    Posez-nous vos questions et nous vous répondrons dans les plus brefs délais.
                                </p>
                            </div>
                            <div class="responsive-container-block">
                                <div class="responsive-cell-block wk-ipadp-6 wk-tab-12 wk-mobile-12 wk-desk-6"
                                    id="i10mt-6">
                                    <p class="text-blk input-title">
                                        Nom
                                    </p>
                                    <input class="input" id="ijowk-6" name="FirstName" placeholder="John" required>
                                </div>
                                <div class="responsive-cell-block wk-desk-6 wk-ipadp-6 wk-tab-12 wk-mobile-12">
                                    <p class="text-blk input-title">
                                        Prénom
                                    </p>
                                    <input class="input" id="indfi-4" name="Last Name" placeholder="Doe" required>
                                </div>
                                <div class="responsive-cell-block wk-desk-6 wk-ipadp-6 wk-tab-12 wk-mobile-12">
                                    <p class="text-blk input-title">
                                        Email
                                    </p>
                                    <input class="input" id="ipmgh-6" name="Email" placeholder="john@doe.fr" required>
                                </div>
                                <div class="responsive-cell-block wk-desk-6 wk-ipadp-6 wk-tab-12 wk-mobile-12">
                                    <p class="text-blk input-title">
                                        Statut
                                    </p>
                                    <input class="input" id="imgis-5" name="PhoneNumber" placeholder="06.00.00.00.00">
                                </div>
                                <div class="responsive-cell-block wk-tab-12 wk-mobile-12 wk-desk-12 wk-ipadp-12"
                                    id="i634i-6">
                                    <p class="text-blk input-title">
                                        Votre message
                                    </p>
                                    <textarea class="textinput" id="i5vyy-6"
                                        placeholder="Veuillez écrire votre message..." required></textarea>
                                </div>
                            </div>
                            <div class="btn-wrapper">
                                <button class="submit-btn">
                                    Envoyer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="responsive-cell-block wk-tab-12 wk-mobile-12 wk-desk-5 wk-ipadp-10" id="ifgi">
                    <div class="container-box">
                        <div class="text-content">
                            <p class="text-blk contactus-head">
                                Contactez-nous
                            </p>
                            <p class="text-blk contactus-subhead">
                                Posez-nous vos questions et nous vous répondrons dans les plus brefs délais.
                            </p>
                        </div>
                        <div class="workik-contact-bigbox">
                            <div class="workik-contact-box">
                                <div class="phone text-box">
                                    <img class="contact-svg"
                                        src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/ET21.jpg">
                                    <p class="contact-text">
                                        +33 7 74 18 92 93
                                    </p>
                                </div>
                                <div class="address text-box">
                                    <img class="contact-svg"
                                        src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/ET22.jpg">
                                    <p class="contact-text">
                                        hello@forumplanner.fr
                                    </p>
                                </div>
                                <div class="mail text-box">
                                    <img class="contact-svg"
                                        src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/ET23.jpg">
                                    <p class="contact-text">
                                        Avenue du Rhône, Annecy, 74000
                                    </p>
                                </div>
                            </div>
                            <div class="social-media-links">
                                <a href="">
                                    <img class="social-svg" id="is9ym"
                                        src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/gray-mail.svg">
                                </a>
                                <a href="">
                                    <img class="social-svg" id="i706n"
                                        src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/gray-twitter.svg">
                                </a>
                                <a href="">
                                    <img class="social-svg" id="ib9ve"
                                        src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/gray-insta.svg">
                                </a>
                                <a href="">
                                    <img class="social-svg" id="ie9fx"
                                        src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/gray-fb.svg">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</html>