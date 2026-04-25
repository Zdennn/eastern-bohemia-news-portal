<div class="novyClanek">
  <h1>Edit článku</h1>
  <form method="post" enctype="multipart/form-data">

    <div class="radek">
      <div class="podSebou">
        <button type="submit" name="editClanek">Uložit</button>

        <select name="idKategorie" required>
          <option value="" disabled>Kategorie</option>
          <?php
          foreach ($kategorie as $kategorie1) {
          ?>
            <option <?= $kategorie1->id == $clanek->idKategorie ? "selected" : "" ?> value="<?= $kategorie1->id ?>"><?= htmlspecialchars($kategorie1->nazev) ?></option>
          <?php
          }
          ?>
        </select>
      </div>
      <div class="wrapper">
        <h2>Tagy</h2>
        <p>Oddělujte tagy čárkou nebo stiskněte Enter pro potvrzení</p>
        <ul id="tagList">
          <?php
          $tagNames = [];
          foreach ($tagy as $tag) {
            foreach ($clanekTag as $ck) {
              if ($tag->id == $ck->idTagu) {
                $tagNames[] = $tag->nazev;
              }
            }
          }
          ?>
          <input type="text" spellcheck="false" placeholder="Zadejte tagy" data-tags="<?= htmlspecialchars(json_encode($tagNames)) ?>">
        </ul>
      </div>
    </div>

    <div class="radek">
      <select class="stav" name="idStav">
        <?php
        foreach ($stavy as $stav) {
          if ($_SESSION['uzivatel_role'] == 2) {
            if ($stav->id >= 3) {
        ?>
              <option disabled value="<?= $stav->id ?>" <?php if ($clanek->idStav == $stav->id) echo 'selected' ?>><?= htmlspecialchars($stav->stav) ?></option>
            <?php
            } else {
            ?>
              <option value="<?= $stav->id ?>" <?php if ($clanek->idStav == $stav->id) echo 'selected' ?>><?= htmlspecialchars($stav->stav) ?></option>
            <?php
            }
          } else {
            ?>
            <option value="<?= $stav->id ?>" <?php if ($clanek->idStav == $stav->id) echo 'selected' ?>><?= htmlspecialchars($stav->stav) ?></option>
          <?php
          }
          ?>
        <?php
        }
        ?>
      </select>
      <input class="flex2" type="text" name="nadpis" placeholder="Nadpis článku" required value="<?= htmlspecialchars($clanek->nadpis) ?>">
      <button class="flex1" type="button" id="spravovatObrazky">Spravovat obrázky</button>
    </div>

    <div id="modalObrazky" class="modal">
      <div class="modal-content">
        <h2>Správa obrázků</h2>
        <div id="previewContainer">

          <?php
          foreach ($obrazky as $obrazek) {
          ?>
            <div class="obrazek-item obrazkyDb">
              <img src="<?= $obrazek->cesta ?>" alt="Náhled">
              <button id="<?= $obrazek->id ?>" class="obrazekDbBtn">✖</button>
            </div>
          <?php
          }
          ?>
        </div>
        <div class="modal-buttons">
          <button id="pridatObrazek">Vybrat obrázek</button>
          <button id="ulozit">Uložit</button>
        </div>
        <input type="file" id="fileInput" name="obrazky[]" accept="image/*" multiple style="display: none;">
      </div>
    </div>

    <div class="radek">
      <textarea name="upoutavka" placeholder="Upoutávka článku" required><?= htmlspecialchars($clanek->upoutavka) ?></textarea>
      <textarea name="uryvek" placeholder="Úryvek článku" required><?= htmlspecialchars($clanek->uryvek) ?></textarea>
    </div>

    <textarea id="obsah" class="obsah" name="obsah" placeholder="Obsah článku" required><?= $clanek->obsah ?></textarea>

    <input type="hidden" name="idClanek" value="<?= $clanek->id ?>">

  </form>

  <?php if (!empty($error)) echo "<p class='error-zprava'>$error</p>"; ?>
  <?php if (!empty($success)) echo "<p class='success-zprava'>$success</p>"; ?>
</div>