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

    <script src="/node_modules/tinymce/tinymce.min.js"></script>

    <link rel="stylesheet" href="/assets/styly/main.css">
    <link rel="stylesheet" href="/assets/styly/dashboard.css">

    <?= $this->controller->styl(); ?>

</head>

<body>

    <header class="header">
        <div class="nadpisHl">
            <h2 class="activeH">Kompas východních čech</h2>
            <h2 class="activeHH">Dashboard</h2>
        </div>
        <div class="odkazy">
            <?php
            $role = $_SESSION["uzivatel_role"];
            $adresa = $_SERVER['REQUEST_URI'];
            switch ($adresa) {
                case str_contains($adresa, "clanky"):
                    if ($role >= 2) { //Autor, Redaktor, Admin
                        if (str_contains($adresa, "novy")) {
                            echo "<a class='novy pc' href='/dashboard/clanky'>Zpět</a>";
                        } else {
                            echo "<a class='novy pc' href='/dashboard/clanky/novy'>Nový</a>";
                        }
                    }
                    break;
                case str_contains($adresa, "uzivatele"):
                    if ($role >= 4) { //Admin
                        if (str_contains($adresa, "novy")) {
                            echo "<a class='novy pc' href='/dashboard/uzivatele'>Zpět</a>";
                        } else {
                            echo "<a class='novy pc' href='/dashboard/uzivatele/novy'>Nový</a>";
                        }
                    }
                    break;
                case str_contains($adresa, "kategorie"):
                    if ($role >= 3) { //Redaktor, Admin
                        if (str_contains($adresa, "novy")) {
                            echo "<a class='novy pc' href='/dashboard/kategorie'>Zpět</a>";
                        } else {
                            echo "<a class='novy pc' href='/dashboard/kategorie/novy'>Nový</a>";
                        }
                    }
                    break;
                case str_contains($adresa, "tagy"):
                    if ($role >= 2) { //Autor, Redaktor, Admin
                        if (str_contains($adresa, "novy")) {
                            echo "<a class='novy pc' href='/dashboard/tagy'>Zpět</a>";
                        } else {
                            echo "<a class='novy pc' href='/dashboard/tagy/novy'>Nový</a>";
                        }
                    }
                    break;
            }
            ?>

            <a class="zpet pc" href="/index">Domů</a>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </header>
    <div class="mobile-menu">
        <nav class="menu">
            <ul>
                <li><a href="/dashboard/clanky">Články</a></li>
                <?php if ($role >= 4) { ?>
                    <li><a href="/dashboard/uzivatele">Uživatelé</a></li>
                <?php } ?>
                <?php if ($role >= 3) { ?>
                    <li><a href="/dashboard/kategorie">Kategorie</a></li>
                <?php } ?>
                <?php if ($role >= 2) { ?>
                    <li><a href="/dashboard/tagy">Tagy</a></li>
                <?php } ?>
                <?php if ($role >= 4) { ?>
                    <li><a href="/dashboard/komentare">Komentáře</a></li>
                <?php } ?>
                <li><a href="/dashboard/ucet">Účet</a></li>


                <?php
                $role = $_SESSION["uzivatel_role"];
                $adresa = $_SERVER['REQUEST_URI'];
                switch ($adresa) {
                    case str_contains($adresa, "clanky"):
                        if ($role >= 2) { //Autor, Redaktor, Admin
                            if (str_contains($adresa, "novy")) {
                                echo "<li><a class='novy pc2' href='/dashboard/clanky'>Zpět</a></li>";
                            } else {
                                echo "<li><a class='novy pc2' href='/dashboard/clanky/novy'>Nový</a></li>";
                            }
                        }
                        break;
                    case str_contains($adresa, "uzivatele"):
                        if ($role >= 4) { //Admin
                            if (str_contains($adresa, "novy")) {
                                echo "<li><a class='novy pc2' href='/dashboard/uzivatele'>Zpět</a></li>";
                            } else {
                                echo "<li><a class='novy pc2' href='/dashboard/uzivatele/novy'>Nový</a></li>";
                            }
                        }
                        break;
                    case str_contains($adresa, "kategorie"):
                        if ($role >= 3) { //Redaktor, Admin
                            if (str_contains($adresa, "novy")) {
                                echo "<li><a class='novy pc2' href='/dashboard/kategorie'>Zpět</a></li>";
                            } else {
                                echo "<li><a class='novy pc2' href='/dashboard/kategorie/novy'>Nový</a></li>";
                            }
                        }
                        break;
                    case str_contains($adresa, "tagy"):
                        if ($role >= 2) { //Autor, Redaktor, Admin
                            if (str_contains($adresa, "novy")) {
                                echo "<li><a class='novy pc2' href='/dashboard/tagy'>Zpět</a></li>";
                            } else {
                                echo "<li><a class='novy pc2' href='/dashboard/tagy/novy'>Nový</a></li>";
                            }
                        }
                        break;
                }
                ?>
                <li><a class="zpet pc2" href="/index">Domů</a></li>
            </ul>
        </nav>
    </div>
    <div class="container">
        <aside class="sidebar">
            <div>
                <div class="nadpis">
                    <h2>Dashboard</h2>
                </div>
                <nav class="menu">
                    <ul>
                        <li><a class="active" href="/dashboard/clanky">Články</a></li>

                        <?php if ($role >= 4) { // Jen Admin vidí uživatele 
                        ?>
                            <li><a href="/dashboard/uzivatele">Uživatelé</a></li>
                        <?php } ?>

                        <?php if ($role >= 3) { // Redaktor a Admin vidí kategorie 
                        ?>
                            <li><a href="/dashboard/kategorie">Kategorie</a></li>
                        <?php } ?>

                        <?php if ($role >= 2) { // Autor, Redaktor, Admin vidí tagy 
                        ?>
                            <li><a href="/dashboard/tagy">Tagy</a></li>
                        <?php } ?>
                        <?php if ($role >= 4) { // Jen Admin vidí komentáře 
                        ?>
                            <li><a href="/dashboard/komentare">Komentáře</a></li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
            <div class="ucet">
                <a href="/dashboard/ucet">
                    <img class="profilePhoto" src="<?= (Model\Uzivatel::ziskatPodleId($_SESSION["uzivatel_id"]))->profilovka != '' ? (Model\Uzivatel::ziskatPodleId($_SESSION["uzivatel_id"]))->profilovka : '/assets/img/default.jpg'; ?>" alt="profilovka">
                    <h3><?= $_SESSION["uzivatel_jmeno"] ?></h3>
                </a>
            </div>

        </aside>
        <main class="content">

            <?php $this->controller->zobraz(); ?>

        </main>
    </div>

</body>
<script src="/assets/js/dashboard.js"></script>
<?= $this->controller->script(); ?>

</html>