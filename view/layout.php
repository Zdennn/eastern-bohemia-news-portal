<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Spectral:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

    <title>Kompas Východních Čech</title>

    <link rel="icon" type="image/x-icon" href="/assets/img/logo.png">

    <link rel="stylesheet" href="/assets/styly/main.css">
    <link rel="stylesheet" href="/assets/styly/header.css">
    <link rel="stylesheet" href="/assets/styly/footer.css">

    <?= $this->controller->styl(); ?>

</head>

<body>
    <header>
        <div id="bar" class="barBila">
            <a href="/index"><img id="logo" src="/assets/img/logo_cele.png" alt="logo"></a>

            <div class="navMenu">
                <input type="checkbox" id="hamburger-menu">
                <label for="hamburger-menu" class="hamburger-icon">
                    <div></div>
                    <div></div>
                    <div></div>
                </label>
                <nav class="mainNav">
                    <?php
                    if (isset($_SESSION['uzivatel_role'])) {
                        if ($_SESSION['uzivatel_role'] == 4 || $_SESSION['uzivatel_role'] == 3 || $_SESSION['uzivatel_role'] == 2) {
                            echo "<a href='/dashboard/clanky'>Dashboard</a>";
                        }
                    }
                    ?>
                    <a href="/index">Domů</a>
                    <a href="/filtr">Přehled</a>
                    <div class="account">
                        <a href="/ucet">
                            <span class="material-symbols-outlined">person</span>

                        </a>
                        <a href="/ucet"><?php

                                        if (isset($_SESSION['uzivatel_id'])) {
                                            echo htmlspecialchars($_SESSION['uzivatel_jmeno']);
                                        }
                                        ?></a>
                    </div>

                </nav>
            </div>
        </div>


        <?php $this->controller->zobraz(); ?>

        <footer>
            <div class="footer">
                <div>
                    <a href="/index"><img id="logoFooter" src="/assets/img/logo_cele_bile.png" alt="logo"></a>
                </div>

                <div class="soc">
                    <h4>Sledujte nás</h4>
                    <div class="social-icons">
                        <a href=""><i class="fa-brands fa-square-facebook"></i></a>
                        <a href=""><i class="fa-brands fa-square-instagram"></i></a>
                        <a href=""><i class="fa-brands fa-square-x-twitter"></i></a>
                        <a href=""><i class="fa-brands fa-square-youtube"></i></a>
                    </div>
                </div>
                <div class="kontakty">
                    <h4>Kontakty:</h4>
                    <p>123 456 789</p>
                    <p>zpravodajVC@email.cz</p>
                    <p>Karla IV. 13, 530 02 Pardubice I</p>
                </div>
            </div>

            <div>
                <div class="footer-bottom">
                    <p>&copy; Zdeněk Michalec 2024</p>
                </div>
            </div>
        </footer>

</body>
<?= $this->controller->script(); ?>
<script src="https://kit.fontawesome.com/b9398ff69e.js" crossorigin="anonymous"></script>

</html>