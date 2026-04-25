</header>
<main>
    <section class="nadpisSec">
        <h1 class="nadpis"><strong class="nadpisStrong">Komentáře: </strong><?= htmlspecialchars($clanek->nadpis) ?></h1>
        <a class="zpet" href="/clanek/<?= htmlspecialchars($clanek->id) ?>">
            <h3><- Zpět na článek</h3>
        </a>
    </section>
    <section class="novyKomentarSec">
        <?php
        if (isset($prihlasenyUzivatel)) {
        ?>
            <div class="ucet">
                <a href="/ucet/<?= htmlspecialchars($prihlasenyUzivatel->id) ?>">
                    <img class="profilePhoto" src="<?= $autor->profilovka != '' ? $autor->profilovka : '/assets/img/default.jpg'; ?>" alt="profilovka">
                    <h3><?= htmlspecialchars($prihlasenyUzivatel->jmeno) ?></h3>
                </a>
            </div>
            <form class="novyKomentar" method="post">
                <textarea class="novyKomentarText" name="obsah" placeholder="Napište nový komentář"></textarea>
                <button class="novyKomentarOdeslat" name="novyKomentar" type="submit">Odeslat</button>
            </form>
            <?php if (!empty($message)) { ?>
                <p style="color: red;"><?php echo $message; ?></p>
            <?php } ?>
        <?php
        } else {
        ?>
            <div class="ucet">
                <h3 class="needLogin">Pro psaní komentářů se musíte <a href="/login">přihlásit</a></h3>
            </div>
            <form class="novyKomentar" method="post">
                <textarea disabled class="novyKomentarText disabled" name="obsah" placeholder="Napište nový komentář"></textarea>
                <button disabled class="novyKomentarOdeslat disabled" name="novyKomentar" type="submit">Odeslat</button>
            </form>

        <?php
        }
        ?>

    </section>
    <section class="komentare">

        <?php
        if (isset($komentare)) {
            $mapaKomentaru = [];

            foreach ($komentare as $komentar) {
                $id = $komentar->id;
                $idNadKomentar = $komentar->idNadKomentar;

                if ($idNadKomentar === null) {
                    if (isset($mapaKomentaru[$id])) {
                        $mapaKomentaru[$id]['komentar'] = $komentar;
                    } else {
                        $mapaKomentaru[$id] = [
                            'komentar' => $komentar,
                            'podkomentare' => []
                        ];
                    }
                } else {
                    if (isset($mapaKomentaru[$idNadKomentar])) {
                        $mapaKomentaru[$idNadKomentar]['podkomentare'][] = $komentar;
                    } else {
                        $mapaKomentaru[$idNadKomentar] = [
                            'komentar' => null,
                            'podkomentare' => [$komentar]
                        ];
                    }
                }
            }

            foreach ($mapaKomentaru as $idKomentar => $data) {
        ?>
                <div class="komentarGroup">
                    <article class="komentar">
                        <div class="infoKom">
                            <a href="/ucet/<?= htmlspecialchars($data['komentar']->idUzivatel) ?>">
                                <?php
                                foreach ($uzivatele as $uzivatel) {
                                    if ($uzivatel->id == $data['komentar']->idUzivatel) {
                                ?>
                                        <h3><?= htmlspecialchars($uzivatel->jmeno) ?></h3>
                                <?php
                                        break;
                                    }
                                }
                                ?>
                            </a>
                            <h6 class="cas">
                                <?php
                                date_default_timezone_set("Europe/Prague");
                                $aktualniDatum = new DateTime();
                                $casString = $data['komentar']->createdAt->format("Y-m-d H:i:s");
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

                        </div>
                        <p><?= preg_replace("/(?<=\s)\b([\w]{1,2})\b\s/", "$1&nbsp;", htmlspecialchars($data['komentar']->obsah))  ?></p>
                        <div class="reakce">
                            <div class="reakceBut">

                                <?php
                                if (isset($_SESSION["uzivatel_id"])) {
                                ?>
                                    <a class="odpovedetTlac">Odpovědět</a>
                                <?php
                                } else {
                                ?>
                                    <div class="tooltip">
                                        <a class="odpovedetTlacZakaz zakazano">Odpovědět</a>
                                        <span class="tooltiptext">K této funkci se musíte přihlásit</span>
                                    </div>
                                <?php
                                }
                                ?>

                                <?php
                                if (isset($_SESSION["uzivatel_id"])) {

                                    $likeFound = false;
                                    foreach ($hodnoceniKomentare as $hodnoceni) {
                                        if ($hodnoceni->idKomentar == $data['komentar']->id) {
                                            $likeFound = true;
                                            if ($hodnoceni->hodnoceni == 1) { //má liknuto
                                ?>
                                                <form method="post">
                                                    <input type="hidden" name="idKomentar" value="<?= htmlspecialchars($data['komentar']->id) ?>">
                                                    <button name="likeKomentar" class="like">
                                                        <div class="likeText liked">Líbí se</div> &nbsp; <span class="material-symbols-outlined liked">favorite</span>
                                                    </button>
                                                </form>
                                            <?php
                                            } else { //odebrany like
                                            ?>
                                                <form method="post">
                                                    <input type="hidden" name="idKomentar" value="<?= htmlspecialchars($data['komentar']->id) ?>">
                                                    <button name="likeKomentar" class="like">
                                                        <div class="likeText">Líbí se</div> &nbsp; <span class="material-symbols-outlined">favorite</span>
                                                    </button>
                                                </form>
                                        <?php
                                            }
                                        }
                                    }
                                    if (!$likeFound) { // pokud v db neni na dany komentar nic
                                        ?>
                                        <form method="post">
                                            <input type="hidden" name="idKomentar" value="<?= htmlspecialchars($data['komentar']->id) ?>">
                                            <button name="likeKomentar" class="like">
                                                <div class="likeText">Líbí se</div> &nbsp; <span class="material-symbols-outlined">favorite</span>
                                            </button>
                                        </form>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <div class="tooltip">
                                        <button class="like zakazano">
                                            Líbí se &nbsp; <span class="material-symbols-outlined">favorite</span>
                                        </button>
                                        <span class="tooltiptext">K této funkci se musíte přihlásit</span>
                                    </div>
                                <?php
                                }
                                ?>

                            </div>
                            <form class="reakceForm" method="post">
                                <input type="hidden" name="idNadKomentar" value="<?= htmlspecialchars($data['komentar']->id) ?>">
                                <div class="formText">
                                    <textarea name="obsah"></textarea>
                                </div>
                                <div class="formBut">
                                    <button name="novaOdpoved" type="submit">Odeslat</button>
                                </div>
                            </form>
                        </div>
                    </article>

                    <?php foreach ($data['podkomentare'] as $podKomentar) { ?>
                        <article class="komentar podKomentar">
                            <div class="infoKom">
                                <a href="/ucet/<?= htmlspecialchars($podKomentar->idUzivatel) ?>">
                                    <?php
                                    foreach ($uzivatele as $uzivatel) {
                                        if ($uzivatel->id == $podKomentar->idUzivatel) {
                                    ?>
                                            <h3><?= htmlspecialchars($uzivatel->jmeno) ?></h3>
                                    <?php
                                            break;
                                        }
                                    }
                                    ?>
                                </a>
                                <h6 class="cas">
                                <?php
                                date_default_timezone_set("Europe/Prague");
                                $aktualniDatum = new DateTime();
                                $casString = $data['komentar']->createdAt->format("Y-m-d H:i:s");
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
                            </div>
                            <p><?= preg_replace("/(?<=\s)\b([\w]{1,2})\b\s/", "$1&nbsp;", htmlspecialchars($podKomentar->obsah))  ?></p>
                            <div class="reakce">
                                <div class="reakceBut">

                                    <?php
                                    if (isset($_SESSION["uzivatel_id"])) {

                                        $likeFound = false;
                                        foreach ($hodnoceniKomentare as $hodnoceni) {
                                            if ($hodnoceni->idKomentar == $podKomentar->id) {
                                                $likeFound = true;
                                                if ($hodnoceni->hodnoceni == 1) { //má liknuto
                                    ?>
                                                    <form method="post">
                                                        <input type="hidden" name="idKomentar" value="<?= htmlspecialchars($podKomentar->id) ?>">
                                                        <button name="likeKomentar" class="like">
                                                            <div class="likeText liked">Líbí se</div> &nbsp; <span class="material-symbols-outlined liked">favorite</span>
                                                        </button>
                                                    </form>
                                                <?php
                                                } else { //odebrany like
                                                ?>
                                                    <form method="post">
                                                        <input type="hidden" name="idKomentar" value="<?= htmlspecialchars($podKomentar->id) ?>">
                                                        <button name="likeKomentar" class="like">
                                                            <div class="likeText">Líbí se</div> &nbsp; <span class="material-symbols-outlined">favorite</span>
                                                        </button>
                                                    </form>
                                            <?php
                                                }
                                            }
                                        }
                                        if (!$likeFound) { //pokud v db neni na dany komentar nic
                                            ?>
                                            <form method="post">
                                                <input type="hidden" name="idKomentar" value="<?= htmlspecialchars($podKomentar->id) ?>">
                                                <button name="likeKomentar" class="like">
                                                    <div class="likeText">Líbí se</div> &nbsp; <span class="material-symbols-outlined">favorite</span>
                                                </button>
                                            </form>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="tooltip">
                                            <button class="like zakazano">
                                                Líbí se &nbsp; <span class="material-symbols-outlined">favorite</span>
                                            </button>
                                            <span class="tooltiptext">K této funkci se musíte přihlásit</span>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                </div>
                                <form class="reakceForm" method="post">
                                    <input type="hidden" name="idNadKomentar" value="<?= htmlspecialchars($podKomentar->idNadKomentar) ?>">
                                    <div class="formText">
                                        <textarea name="obsah"></textarea>
                                    </div>
                                    <div class="formBut">
                                        <button name="novaOdpoved" type="submit">Odeslat</button>
                                    </div>
                                </form>
                            </div>
                        </article>
                    <?php } ?>
                </div>
            <?php }
        } else {
            ?>
            <h3>Článek zatím neobsahuje žádné komentáře</h3>
        <?php
        }
        ?>
    </section>


</main>