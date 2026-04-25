<div class="novyClanek">
  <h1>Nový článek</h1>
  <?php if (!empty($error)) echo "<p class='error-zprava'>$error</p>"; ?>
  <?php if (!empty($success)) echo "<p class='success-zprava'>$success</p>"; ?>
  <form method="post" enctype="multipart/form-data">

    <div class="radek">
      <div class="podSebou">
        <button type="submit" name="novyClanek">Uložit</button>

        <select name="idKategorie" required>
          <option value="" disabled selected>Kategorie</option>
          <?php foreach ($kategorie as $kategorie1) { ?>
            <option value="<?= $kategorie1->id ?>"><?= htmlspecialchars($kategorie1->nazev) ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="wrapper">
        <h2>Tagy</h2>
        <p>Oddělujte tagy čárkou nebo stiskněte Enter pro potvrzení</p>
        <ul id="tagList">
          <input type="text" spellcheck="false" placeholder="Zadejte tagy">
        </ul>
      </div>
    </div>

    <div class="radek">
      <input class="flex2" type="text" name="nadpis" placeholder="Nadpis článku" required>
      <button class="flex1" type="button" id="spravovatObrazky">Spravovat obrázky</button>
    </div>

    <div id="modalObrazky" class="modal">
      <div class="modal-content">
        <h2>Správa obrázků</h2>
        <div id="previewContainer"></div>
        <div class="modal-buttons">
          <button id="pridatObrazek">Vybrat obrázek</button>
          <button id="ulozit">Uložit</button>
        </div>
        <input type="file" id="fileInput" name="obra[]" accept="image/*" multiple style="display: none;">
      </div>
    </div>

    <div class="radek">
      <textarea name="upoutavka" placeholder="Upoutávka článku" required></textarea>
      <textarea name="uryvek" placeholder="Úryvek článku" required></textarea>
    </div>

    <textarea id="obsah" class="obsah" name="obsah" placeholder="Obsah článku" required></textarea>

  </form>

</div>