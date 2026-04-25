<div class="formDiv">
<h1>Editace tagu</h1>
<form class="form" method="post" action="/dashboard/tagy">
    <input type="text" hidden name="idTag" value="<?= htmlspecialchars($tag->id) ?>">
    <input type="text" name="nazev" placeholder="Název tagu" value="<?= htmlspecialchars($tag->nazev) ?>" required>
    <button name="editTag" type="submit">Uložit změny</button>
</form>

<?php if (!empty($message)) echo "<p>$message</p>"; ?>
</div>