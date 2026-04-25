</header>
<main>
    <?php

    if (isset($_SESSION["uzivatel_id"]) && $uzivatel->id == $_SESSION["uzivatel_id"]) {
    ?>
        <a href="<?= '/ucet/' . $uzivatel->id . '/nastaveni' ?>"><span class="material-symbols-outlined nastaveni">settings</span></a>
        <a href="/logout"><span class="material-symbols-outlined logout">logout</span></a>
    <?php
    }

    ?>
    <section id="ucet">
        <div class="prvni">
            <div class="druhy">
                <div id="profilovka"><img src="<?= htmlspecialchars($uzivatel->profilovka ?? "") ?>" alt=""></div>
                <div class="treti">
                    <h1><?= htmlspecialchars($uzivatel->jmeno) ?></h1>
                    <h4><?= htmlspecialchars($uzivatel->email) ?></h4>
                    <p><?= preg_replace("/(?<=\s)\b([\w]{1,2})\b\s/", "$1&nbsp;", htmlspecialchars($uzivatel->popis ?? "")) ?></p>
                </div>
            </div>
        </div>
    </section>
    <section class="menu">
        <nav class="menuNav">
            <a class="active" href="<?= '/ucet/' . $uzivatel->id . '/clanky' ?>">Články uživatele</a>
            <a href="<?= '/ucet/' . $uzivatel->id . '/komentare' ?>">Komentáře uživatele</a>
            <a href="<?= '/ucet/' . $uzivatel->id . '/oblibene' ?>">Oblíbené články uživatele</a>
        </nav>
    </section>

    <section class="panel">
        <div class="subPanel">
            <?php
            foreach ($clankyUzivatele as $clanekUzivatele) {
                $vybraneObrazky = array_filter($obrazky, function ($obrazek) use ($clanekUzivatele) {
                    return $obrazek->idClanek === $clanekUzivatele->id;
                });
                $vybranyObrazek = reset($vybraneObrazky);
                $obrazekSrc = $vybranyObrazek ? $vybranyObrazek->cesta : '/assets/img/default.jpg';
            ?>

                <article class="article">
                    <div class="articleVedle flex1">
                        <a class="obrazek" href="/clanek/<?= $clanekUzivatele->id ?>"><img src="<?= $obrazekSrc ?>" alt="<?= $vybranyObrazek ? $vybranyObrazek->alt : 'no image avaible' ?>"></a>
                        <div class="textClanek flex2">
                            <div>

                                <div class="clanek">
                                    <a href="/clanek/<?= $clanekUzivatele->id ?>">
                                        <h2><?= preg_replace("/(?<=\s)\b([\w]{1,2})\b\s/", "$1&nbsp;", htmlspecialchars($clanekUzivatele->nadpis))  ?></h2>
                                    </a>
                                    <p class="upoutavka"><?= preg_replace("/(?<=\s)\b([\w]{1,2})\b\s/", "$1&nbsp;", htmlspecialchars($clanekUzivatele->upoutavka))  ?></p>
                                </div>
                                <div class="casKat">
                                    <h6 class="cas">
                                        <?php
                                        date_default_timezone_set("Europe/Prague");
                                        $aktualniDatum = new DateTime();
                                        $casString = $clanekUzivatele->createdAt->format("Y-m-d H:i:s");
                                        $d = new DateTime($casString);
                                        $rozdil = $aktualniDatum->diff($d);

                                        if ($rozdil->y > 0) {
                                            echo "Před {$rozdil->y} lety";
                                        } elseif ($rozdil->m > 0) {
                                            echo "Před {$rozdil->m} měsíci";
                                        } elseif ($rozdil->d > 0) {
                                            echo "Před {$rozdil->d} dny";
                                        } elseif ($rozdil->h > 0) {
                                            echo "Před {$rozdil->h} hodinami";
                                        } elseif ($rozdil->i > 0) {
                                            echo "Před {$rozdil->i} minutami";
                                        } else {
                                            echo "Před méně než minutou";
                                        }
                                        ?>
                                    </h6>
                                    <h6 class="kategorie"><a href="/filtr/kategorie/<?= $kategorie[$clanekUzivatele->idKategorie - 1]->id ?>"><?= htmlspecialchars($kategorie[$clanekUzivatele->idKategorie - 1]->nazev) ?></a></h6>
                                </div>
                            </div>
                            <?php
                            if (isset($_SESSION["uzivatel_id"]) && $uzivatel->id == $_SESSION["uzivatel_id"]) {

                                $vybraneHodnoceniClanku = array_filter($hodnoceniClanku, function ($hodnoceni) use ($clanekUzivatele) {
                                    return $hodnoceni->idClanek === $clanekUzivatele->id;
                                });
                                $vybraneHodnoceni = reset($vybraneHodnoceniClanku);

                                if ($vybraneHodnoceni == true && $vybraneHodnoceni->hodnoceni == 1) { //má liknuto
                            ?>
                                    <form method="post">
                                        <input type="hidden" name="idClanek" value="<?= $clanekUzivatele->id ?>">
                                        <button name="like" class="like">
                                            <div class="likeText">Líbí se</div> &nbsp; <span class="material-symbols-outlined liked">favorite</span>
                                        </button>
                                    </form>
                                <?php
                                } else { //odebrany like, nebo neexistuje
                                ?>
                                    <form method="post">
                                        <input type="hidden" name="idClanek" value="<?= $clanekUzivatele->id ?>">
                                        <button name="like" class="like">
                                            <div class="likeText">Líbí se</div> &nbsp; <span class="material-symbols-outlined">favorite</span>
                                        </button>
                                    </form>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>

                </article>
            <?php
            }
            ?>
        </div>
    </section>

</main>
<script>
    if (document.querySelector('main').clientHeight < window.innerHeight - 274.5) {
        function adjustBodyHeight() {

            document.querySelector('main').style.height = (window.innerHeight - 274.5) + 'px';
        }
        window.addEventListener('resize', adjustBodyHeight);
        window.addEventListener('load', adjustBodyHeight);
    }
</script>