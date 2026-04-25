</header>
<main>

    <section class="info">
        <a href="/filtr/kategorie/<?= $kategorie->id ?>">
            <p class="kategorie"><?= htmlspecialchars($kategorie->nazev) ?></p>
        </a>
        <h1><?= preg_replace("/(?<=\s)\b([\w]{1,2})\b\s/", "$1&nbsp;", htmlspecialchars($clanek->nadpis)) ?></h1>
        <div class="autorCas">
            <div class="ucet">
                <a href="/ucet/<?= htmlspecialchars($autor->id) ?>">
                    <img class="profilePhoto" src="<?= $autor->profilovka != '' ? $autor->profilovka : '/assets/img/default.jpg'; ?>" alt="profilovka">
                    <h3><?= htmlspecialchars($autor->jmeno) ?></h3>
                </a>
            </div>
            <div class="casDiv">
                <h6 class="cas">
                    <?php
                    echo "<br>" . $clanek->createdAt->format('j. n. Y H:i');
                    ?>
                </h6>
            </div>
        </div>

    </section>
    <section class="obsahSec">
        <h4><?= isset($clanek->upoutavka) ? preg_replace("/(?<=\s)\b([\w]{1,2})\b\s/", "$1&nbsp;", htmlspecialchars($clanek->upoutavka)) : ""  ?></h4>
        <?php
        if (isset($obrazky[0])) {
        ?>
            <div class="mainImgDiv">
                <div id="imgContainer" class="imgContainer">
                    <img onclick="openLightbox(0)" id="mainImg" class="mainImg" src="<?= isset($obrazky[0]) ? $obrazky[0]->cesta : "/assets/img/default.jpg"; ?>" alt="<?= isset($obrazky[0]->alt) ? htmlspecialchars($obrazky[0]->alt) : ""; ?>">
                    <span class="overImg">Galerie <?= isset($obrazky) ? count($obrazky) : "" ?></span>
                </div>
                <h6 class="imgAlt"><?= isset($obrazky[0]) ? htmlspecialchars($obrazky[0]->nazev) : "" ?></h6>
            </div>
        <?php
        }
        ?>
        <div id="lightbox" class="lightbox">
            <span class="close">&times;</span>
            <img id="lightbox-img" class="lightbox-content">
            <h6 id="lightbox-title" class="imgAlt"></h6>

            <span class="prev">&#10094;</span>
            <span class="next">&#10095;</span>

            <div class="thumbnails">
                <?php foreach ($obrazky as $index => $obrazek) { ?>
                    <img class="thumbnail" src="<?= $obrazek->cesta; ?>" alt="<?= htmlspecialchars($obrazek->alt); ?>"
                        data-index="<?= $index; ?>" data-title="<?= htmlspecialchars($obrazek->nazev); ?>">
                <?php }; ?>
            </div>
        </div>



        <div class="obsah">
            <p><?= preg_replace("/(?<=\s)\b([\w]{1,2})\b\s/", "$1&nbsp;", $clanek->obsah) ?></p>
        </div>

    </section>
    <section>
        <div class="odkazy">
            <div class="odkazyVpravo">

                <?php
                if (isset($_SESSION["uzivatel_id"])) {

                    if (isset($hodnoceniClanku) && $hodnoceniClanku->hodnoceni == 1) { //má liknuto
                ?>
                        <form method="post">
                            <button name="like" class="like liked">
                                <div class="likeText"><span class="material-symbols-outlined">favorite</span>&nbsp;Líbí se&nbsp;<?= $pocetLiku ?></div>
                            </button>
                        </form>
                    <?php
                    } else { //odebrany like
                    ?>
                        <form method="post">
                            <button name="like" class="like">
                                <div class="likeText"><span class="material-symbols-outlined">favorite</span>&nbsp;Líbí se&nbsp;<?= $pocetLiku ?></div>
                            </button>
                        </form>
                    <?php
                    }
                } else {
                    ?>
                    <div class="tooltip">
                        <button class="like zakazano">

                            <div class="likeText"><span class="material-symbols-outlined">favorite</span>&nbsp;Líbí se&nbsp;<?= $pocetLiku ?></div>
                        </button>
                        <span class="tooltiptext">K této funkci se musíte přihlásit</span>
                    </div>
                <?php
                }
                ?>





                <a class="koment" href="/clanek/<?= htmlspecialchars($clanek->id) ?>/komentare">Komentáře: <?= is_array($komentare) ? count($komentare) : 0 ?></a>
            </div>
        </div>
        <div class="tagy">
            <?php



            foreach ($ClankyTagy as $clanekTag) {
                $vybranyTag = array_filter($tagy, function ($tag) use ($clanekTag) {
                    return $tag->id === $clanekTag->idTagu;
                });

                $tag = reset($vybranyTag);
            ?>
                <a class="tag" href="/filtr/tag/<?= htmlspecialchars($tag->id) ?>"><?= htmlspecialchars($tag->nazev) ?></a>
            <?php
            }
            ?>

        </div>

    </section>
</main>