 <main>
 <div class="vyhledavani">
    <form method="post">
      <div class="radek">
        <div class="podSebou">
          <button name="vyhledat" type="submit">Vyhledat</button>
          <select name="idKategorie">
            <option value="0" <?= isset($_POST['idKategorie']) ? '' : 'selected'; ?>>Kategorie</option>
            <?php foreach ($kategorie as $kategorie1) { ?>
              <option <?= isset($_POST['idKategorie']) && $_POST['idKategorie'] == $kategorie1->id ? 'selected' : (isset($kategorieUrl) && $kategorieUrl == $kategorie1->id ? 'selected' : ''); ?> value="<?= $kategorie1->id ?>"><?= htmlspecialchars($kategorie1->nazev) ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="wrapper">
          <h2>Tagy</h2>
          <p>Oddělujte tagy čárkou nebo stiskněte Enter pro potvrzení</p>
          <ul id="tagList">
            <input type="text" spellcheck="false" placeholder="Zadejte tagy" data-tags="<?= htmlspecialchars(isset($_POST['tagy']) ? $_POST['tagy'] : (isset($tagUrl) ? $tagUrl : '')) ?>">
          </ul>
        </div>
      </div>
      <div class="radek">
        <input type="text" name="nazev" placeholder="Název" value="<?= isset($_POST['nazev']) ? htmlspecialchars($_POST['nazev']) : ''; ?>">
      </div>
    </form>
  </div>

  <section class="sKatDat">
    <div class="sKatDatClanky">
      <?php
      if ($clanky == null) {
        echo "<div class='errorDiv'><h2 class='error'>Žádné články nebyly nalezeny</h2></div>";
      } else {
        foreach ($clanky as $clanek) {
          if ($clanek->idStav == 4) {
            $vybranaKategorie = array_filter($kategorie, function ($kategorie1) use ($clanek) {
              return $kategorie1->id == $clanek->idKategorie;
            });
            $kategorieNazev = reset($vybranaKategorie)->nazev;
            $kategorieId = reset($vybranaKategorie)->id;

            $vybraneObrazky = array_filter($obrazky, function ($obrazek) use ($clanek) {
              return $obrazek->idClanek === $clanek->id;
            });
            $vybranyObrazek = reset($vybraneObrazky);
            $obrazekSrc = $vybranyObrazek ? $vybranyObrazek->cesta : '/assets/img/default.jpg';

      ?>
            <article>
              <a href="/clanek/<?= $clanek->id ?>"><img src="<?= $obrazekSrc ?>" alt=""></a>
              <div>
                <a href="/clanek/<?= $clanek->id ?>">
                  <h2><?= preg_replace("/(?<=\s)\b([\w]{1,2})\b\s/", "$1&nbsp;", htmlspecialchars($clanek->nadpis)) ?></h2>
                </a>
                <p><?= preg_replace("/(?<=\s)\b([\w]{1,2})\b\s/", "$1&nbsp;", htmlspecialchars($clanek->upoutavka))  ?></p>
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
                  <h6 class="kategorie"><a href="/filtr/kategorie/<?= $kategorieId ?>"><?= htmlspecialchars($kategorieNazev) ?></a></h6>
                </div>
              </div>
            </article>

      <?php
          }
        }
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