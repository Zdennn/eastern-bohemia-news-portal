<div class="formDiv">
<h1>Editace kategorie</h1>
<form class="form" method="post" action="/dashboard/kategorie">
    <input type="text" hidden name="idKategorie" value="<?= htmlspecialchars($kategorie->id) ?>">
    <input type="text" name="nazev" placeholder="Název kategorie" value="<?= htmlspecialchars($kategorie->nazev) ?>" required>
    <button name="editKategorie" type="submit">Uložit změny</button>
</form>

<?php if (!empty($message)) echo "<p>$message</p>"; ?>
</div>