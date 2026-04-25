<div class="slideshow">
    <div class="slides">
        <?php
        for ($i = 0; $i < 3; $i++) {
            $vybraneObrazky = array_filter($obrazky, function ($obrazek) use ($nejClanky, $i) {
                return $obrazek->idClanek === $nejClanky[$i]->id;
            });
            $vybranyObrazek = reset($vybraneObrazky);
            $obrazekSrc = $vybranyObrazek ? $vybranyObrazek->cesta : '/assets/img/default.jpg';
        ?>
            <div class="slide">
                <img src="<?= $obrazekSrc ?>" alt="<?= $obrazekSrc ? $vybranyObrazek->alt : "" ?>">
            </div>
        <?php
        }
        ?>
    </div>
</div>

<div id="overImg">
    <?php
    for ($i = 0; $i < 3; $i++) {
        $titles[] = $nejClanky[$i]->nadpis;
        $cesty[] = "/clanek/{$nejClanky[$i]->id}";
    }
    ?>
    <script>
        let titles = <?= json_encode($titles) ?>;
        const cesty = <?= json_encode($cesty) ?>;
    </script>
    <div id="nadpisTxtObrDiv">
        <h2 id="nadpisTxtObr"></h2>
        <div>
            <a id="viceTlacTxtObr" class="viceTlac" href="">Více</a>
        </div>
    </div>

    <div>
        <div id="carky">
            <div class="cr">
                <div class="cara"></div>
                <div class="cara-dolni"></div>
                <div class="cara-horni cara-horni-prvni"></div>
            </div>
            <div class="cr">
                <div class="cara"></div>
                <div class="cara-dolni"></div>
                <div class="cara-horni"></div>
            </div>
            <div class="cr">
                <div class="cara"></div>
                <div class="cara-dolni"></div>
                <div class="cara-horni"></div>
            </div>
        </div>
        <div id="sipky">
            <div class="sipkaDoleva"></div>
            <div class="sipkaDoprava"></div>
        </div>
    </div>
</div>
</header>
<main>

    <section class="sHlavni">

        <?php
        $vybraneObrazky = array_filter($obrazky, function ($obrazek) use ($nejClanky) {
            return $obrazek->idClanek === $nejClanky[4]->id;
        });
        $vybranyObrazek = reset($vybraneObrazky);
        $obrazekSrc = $vybranyObrazek ? $vybranyObrazek->cesta : '/assets/img/default.jpg';
        ?>
        <article>
            <a href="/clanek/<?= $nejClanky[4]->id ?>"><img src="<?= $obrazekSrc ?>" alt="<?= $obrazekSrc ? htmlspecialchars($vybranyObrazek->alt) : "" ?>"></a>
            <div>
                <a href="/clanek/<?= $nejClanky[4]->id ?>">
                    <h2><?= htmlspecialchars($nejClanky[4]->nadpis) ?></h2>
                </a>
                <p><?= preg_replace("/(?<=\s)\b([\w]{1,2})\b\s/", "$1&nbsp;", htmlspecialchars($nejClanky[4]->uryvek))?></p>
                <div>
                    <h6 class="cas">
                        <?php
                        date_default_timezone_set("Europe/Prague");
                        $aktualniDatum = new DateTime();
                        $casString = $nejClanky[4]->createdAt->format("Y-m-d H:i:s");
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

                    <h6 class="kategorie"><a href=""><?= htmlspecialchars($kategorie[$nejClanky[4]->idKategorie - 1]->nazev) ?></a></h6>
                </div>
            </div>
        </article>
    </section>

    <div class="s5Div">

        <section class="s5"><!--petka-->
            <div>
                <?php
                for ($i = 5; $i < 8; $i++) {
                    $vybraneObrazky = array_filter($obrazky, function ($obrazek) use ($nejClanky, $i) {
                        return $obrazek->idClanek === $nejClanky[$i]->id;
                    });
                    $vybranyObrazek = reset($vybraneObrazky);
                    $obrazekSrc = $vybranyObrazek ? $vybranyObrazek->cesta : '/assets/img/default.jpg';
                ?>
                    <article><!-- 5 -->
                        <a href="/clanek/<?= $nejClanky[$i]->id ?>"><img src="<?= $obrazekSrc ?>" alt="<?= $obrazekSrc ? htmlspecialchars($vybranyObrazek->alt) : "" ?>"></a>
                        <div>
                            <a href="/clanek/<?= $nejClanky[$i]->id ?>">
                                <h2><?= htmlspecialchars($nejClanky[$i]->nadpis) ?></h2>
                            </a>
                            <p><?= preg_replace("/(?<=\s)\b([\w]{1,2})\b\s/", "$1&nbsp;", htmlspecialchars($nejClanky[$i]->uryvek)) ?></p>
                            <div>

                                <h6 class="cas">
                                    <?php
                                    date_default_timezone_set("Europe/Prague");
                                    $aktualniDatum = new DateTime();
                                    $casString = $nejClanky[$i]->createdAt->format("Y-m-d H:i:s");
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
                                <h6 class="kategorie"><a href="/filtr/kategorie/<?= htmlspecialchars($kategorie[$nejClanky[$i]->idKategorie - 1]->id) ?>"><?= htmlspecialchars($kategorie[$nejClanky[$i]->idKategorie - 1]->nazev) ?></a></h6>
                            </div>
                        </div>
                    </article>
                <?php
                }
                ?>
            </div>
            <div>
                <?php
                for ($i = 8; $i < 10; $i++) {
                    $vybraneObrazky = array_filter($obrazky, function ($obrazek) use ($nejClanky, $i) {
                        return $obrazek->idClanek === $nejClanky[$i]->id;
                    });
                    $vybranyObrazek = reset($vybraneObrazky);
                    $obrazekSrc = $vybranyObrazek ? $vybranyObrazek->cesta : '/assets/img/default.jpg';
                ?>
                    <article><!-- 5 -->
                        <a href="/clanek/<?= $nejClanky[$i]->id ?>"><img src="<?= $obrazekSrc ?>" alt="<?= $obrazekSrc ? htmlspecialchars($vybranyObrazek->alt) : "" ?>"></a>
                        <div>
                            <a href="/clanek/<?= $nejClanky[$i]->id ?>">
                                <h2><?= htmlspecialchars($nejClanky[$i]->nadpis) ?></h2>
                            </a>
                            <p><?= preg_replace("/(?<=\s)\b([\w]{1,2})\b\s/", "$1&nbsp;", htmlspecialchars($nejClanky[$i]->uryvek)) ?></p>
                            <div>
                                <h6 class="cas">
                                    <?php
                                    date_default_timezone_set("Europe/Prague");
                                    $aktualniDatum = new DateTime();
                                    $casString = $nejClanky[$i]->createdAt->format("Y-m-d H:i:s");
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
                                <h6 class="kategorie"><a href="/filtr/kategorie/<?= htmlspecialchars($kategorie[$nejClanky[$i]->idKategorie - 1]->id) ?>"><?= htmlspecialchars($kategorie[$nejClanky[$i]->idKategorie - 1]->nazev) ?></a></h6>
                            </div>
                        </div>
                    </article>
                <?php
                }
                ?>
            </div>
        </section>

    </div>
    <section class="sKatDat"><!--KatDat-->
        <div class="odkazy">
            <nav id="kategorie-nav">
                <a id="kultura" href="" class="odkaz active">Kultura</a>
                <a id="sport" href="" class="odkaz">Sport</a>
                <a id="ekonomika" href="" class="odkaz">Ekonomika</a>
                <a id="udalosti" href="" class="odkaz">Události</a>
                <a class="viceTlac" href="/filtr">Více</a>
            </nav>
        </div>
        <div id="kultura" class="sKatDatClanky visible">
            <?php
            foreach ($clankyKultura as $clanek) {
                $vybraneObrazky = array_filter($obrazky, function ($obrazek) use ($clanek) {
                    return $obrazek->idClanek === $clanek->id;
                });
                $vybranyObrazek = reset($vybraneObrazky);
                $obrazekSrc = $vybranyObrazek ? $vybranyObrazek->cesta : '/assets/img/default.jpg';
            ?>
                <article>
                    <a href="/clanek/<?= $clanek->id ?>"><img src="<?= $obrazekSrc ?>" alt="<?= $obrazekSrc ? htmlspecialchars($vybranyObrazek->alt) : "" ?>"></a>
                    <div>
                        <a href="/clanek/<?= $clanek->id ?>">
                            <h2><?= htmlspecialchars($clanek->nadpis) ?></h2>
                        </a>
                        <p><?= preg_replace("/(?<=\s)\b([\w]{1,2})\b\s/", "$1&nbsp;", htmlspecialchars($clanek->uryvek))?></p>
                        <div>
                            <h6 class="cas">
                                <?php
                                date_default_timezone_set("Europe/Prague");
                                $aktualniDatum = new DateTime();
                                $casString = $clanek->createdAt->format("Y-m-d H:i:s");
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
                            <h6 class="kategorie"><a href="/filtr/kategorie/<?= htmlspecialchars($kategorie[$clanek->idKategorie - 1]->id) ?>"><?= htmlspecialchars($kategorie[$clanek->idKategorie - 1]->nazev) ?></a></h6>
                        </div>
                    </div>
                </article>
            <?php
            }
            ?>
        </div>
        </div>
        <div id="sport" class="sKatDatClanky hidden">
            <?php
            foreach ($clankySport as $clanek) {
                $vybraneObrazky = array_filter($obrazky, function ($obrazek) use ($clanek) {
                    return $obrazek->idClanek === $clanek->id;
                });
                $vybranyObrazek = reset($vybraneObrazky);
                $obrazekSrc = $vybranyObrazek ? $vybranyObrazek->cesta : '/assets/img/default.jpg';
            ?>
                <article>
                    <a href="/clanek/<?= $clanek->id ?>"><img src="<?= $obrazekSrc ?>" alt="<?= $obrazekSrc ? htmlspecialchars($vybranyObrazek->alt) : "" ?>"></a>
                    <div>
                        <a href="/clanek/<?= htmlspecialchars($clanek->id) ?>">
                            <h2><?= htmlspecialchars($clanek->nadpis) ?></h2>
                        </a>
                        <p><?= preg_replace("/(?<=\s)\b([\w]{1,2})\b\s/", "$1&nbsp;", htmlspecialchars($clanek->uryvek)) ?></p>
                        <div>
                        <h6 class="cas">
                                <?php
                                date_default_timezone_set("Europe/Prague");
                                $aktualniDatum = new DateTime();
                                $casString = $clanek->createdAt->format("Y-m-d H:i:s");
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
                            <h6 class="kategorie"><a href="/filtr/kategorie/<?= htmlspecialchars($kategorie[$clanek->idKategorie - 1]->id) ?>"><?= htmlspecialchars($kategorie[$clanek->idKategorie - 1]->nazev) ?></a></h6>
                        </div>
                    </div>
                </article>
            <?php
            }
            ?>
        </div>
        <div id="ekonomika" class="sKatDatClanky hidden">
            <?php
            foreach ($clankyEkonomika as $clanek) {
                $vybraneObrazky = array_filter($obrazky, function ($obrazek) use ($clanek) {
                    return $obrazek->idClanek === $clanek->id;
                });
                $vybranyObrazek = reset($vybraneObrazky);
                $obrazekSrc = $vybranyObrazek ? $vybranyObrazek->cesta : '/assets/img/default.jpg';
            ?>
                <article>
                    <a href="/clanek/<?= $clanek->id ?>"><img src="<?= $obrazekSrc ?>" alt="<?= $obrazekSrc ? htmlspecialchars($vybranyObrazek->alt) : "" ?>"></a>
                    <div>
                        <a href="/clanek/<?= $clanek->id ?>">
                            <h2><?= htmlspecialchars($clanek->nadpis) ?></h2>
                        </a>
                        <p><?= preg_replace("/(?<=\s)\b([\w]{1,2})\b\s/", "$1&nbsp;", htmlspecialchars($clanek->uryvek)) ?></p>
                        <div>
                        <h6 class="cas">
                                <?php
                                date_default_timezone_set("Europe/Prague");
                                $aktualniDatum = new DateTime();
                                $casString = $clanek->createdAt->format("Y-m-d H:i:s");
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
                            <h6 class="kategorie"><a href="/filtr/kategorie/<?= htmlspecialchars($kategorie[$clanek->idKategorie - 1]->id) ?>"><?= htmlspecialchars($kategorie[$clanek->idKategorie - 1]->nazev) ?></a></h6>
                        </div>
                    </div>
                </article>
            <?php
            }
            ?>
        </div>
        <div id="udalosti" class="sKatDatClanky hidden">
            <?php
            foreach ($clankyUdalosti as $clanek) {
                $vybraneObrazky = array_filter($obrazky, function ($obrazek) use ($clanek) {
                    return $obrazek->idClanek === $clanek->id;
                });
                $vybranyObrazek = reset($vybraneObrazky);
                $obrazekSrc = $vybranyObrazek ? $vybranyObrazek->cesta : '/assets/img/default.jpg';
            ?>
                <article>
                    <a href="/clanek/<?= $clanek->id ?>"><img src="<?= $obrazekSrc ?>" alt="<?= $obrazekSrc ? htmlspecialchars($vybranyObrazek->alt) : "" ?>"></a>
                    <div>
                        <a href="/clanek/<?= $clanek->id ?>">
                            <h2><?= htmlspecialchars($clanek->nadpis) ?></h2>
                        </a>
                        <p><?= preg_replace("/(?<=\s)\b([\w]{1,2})\b\s/", "$1&nbsp;", htmlspecialchars($clanek->uryvek)) ?></p>
                        <div>
                        <h6 class="cas">
                                <?php
                                date_default_timezone_set("Europe/Prague");
                                $aktualniDatum = new DateTime();
                                $casString = $clanek->createdAt->format("Y-m-d H:i:s");
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
                            <h6 class="kategorie"><a href="/filtr/kategorie/<?= htmlspecialchars($kategorie[$clanek->idKategorie - 1]->id) ?>"><?= htmlspecialchars($kategorie[$clanek->idKategorie - 1]->nazev) ?></a></h6>
                        </div>
                    </div>
                </article>
            <?php
            }
            ?>
        </div>
    </section>

    <section class="sPruh"><!--Pruh-->
        <?php
        $vybraneObrazky = array_filter($obrazky, function ($obrazek) use ($nejClanky) {
            return $obrazek->idClanek === $nejClanky[10]->id;
        });
        $vybranyObrazek = reset($vybraneObrazky);
        $obrazekSrc = $vybranyObrazek ? $vybranyObrazek->cesta : '/assets/img/default.jpg';
        ?>
        <article>
            <a id="odkazObrazek" href="/clanek/<?= $nejClanky[10]->id ?>"><img src="<?= $obrazekSrc ?>" alt="<?= $obrazekSrc ? htmlspecialchars($vybranyObrazek->alt) : "" ?>"></a>
            <div>
                <a href="/clanek/<?= $nejClanky[10]->id ?>">
                    <h2><?= htmlspecialchars($nejClanky[10]->nadpis) ?></h2>
                </a>
                <p><?= preg_replace("/(?<=\s)\b([\w]{1,2})\b\s/", "$1&nbsp;", htmlspecialchars($nejClanky[10]->uryvek)) ?></p>
                <div>
                    <h6 class="cas">
                        <?php
                        date_default_timezone_set("Europe/Prague");
                        $aktualniDatum = new DateTime();
                        $casString = $nejClanky[10]->createdAt->format("Y-m-d H:i:s");
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
                    <h6 class="kategorie"><a href="/filtr/kategorie/<?= htmlspecialchars($kategorie[$nejClanky[10]->idKategorie - 1]->id) ?>"><?= htmlspecialchars($kategorie[$nejClanky[10]->idKategorie - 1]->nazev) ?></a></h6>
                </div>
            </div>
        </article>
    </section>

    <section class="s4ObrTxt"><!--4-obrazky-bckground-text-->
        <div>
            <?php
            for ($i = 11; $i < 13; $i++) {
                $vybraneObrazky = array_filter($obrazky, function ($obrazek) use ($nejClanky, $i) {
                    return $obrazek->idClanek === $nejClanky[$i]->id;
                });
                $vybranyObrazek = reset($vybraneObrazky);
                $obrazekSrc = $vybranyObrazek ? $vybranyObrazek->cesta : '/assets/img/default.jpg';
            ?>
                <article style="background-image: url(<?= $obrazekSrc ?>);">
                    <div>
                        <a href="/clanek/<?= $nejClanky[$i]->id ?>">
                            <h2><?= htmlspecialchars($nejClanky[$i]->nadpis) ?></h2>
                        </a>
                        <p><?= preg_replace("/(?<=\s)\b([\w]{1,2})\b\s/", "$1&nbsp;", htmlspecialchars($nejClanky[$i]->uryvek)) ?></p>
                        <div>
                            <a class="viceTlac" href="/clanek/<?= $nejClanky[$i]->id ?>">Více</a>
                        </div>
                    </div>
                </article>
            <?php
            }
            ?>
        </div>
        <div>
            <?php
            for ($i = 13; $i < 15; $i++) {
                $vybraneObrazky = array_filter($obrazky, function ($obrazek) use ($nejClanky, $i) {
                    return $obrazek->idClanek === $nejClanky[$i]->id;
                });
                $vybranyObrazek = reset($vybraneObrazky);
                $obrazekSrc = $vybranyObrazek ? $vybranyObrazek->cesta : '/assets/img/default.jpg';
            ?>
                <article style="background-image: url(<?= $obrazekSrc ?>);">
                    <div>
                        <a href="/clanek/<?= $nejClanky[$i]->id ?>">
                            <h2><?= htmlspecialchars($nejClanky[$i]->nadpis) ?></h2>
                        </a>
                        <p><?= preg_replace("/(?<=\s)\b([\w]{1,2})\b\s/", "$1&nbsp;", htmlspecialchars($nejClanky[$i]->uryvek)) ?></p>
                        <div>
                            <a class="viceTlac" href="/clanek/<?= $nejClanky[$i]->id ?>">Více</a>
                        </div>
                    </div>
                </article>
            <?php
            }
            ?>
        </div>
    </section>

</main>
