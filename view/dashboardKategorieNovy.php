<div class="formDiv">
<h1>Nová kategorie</h1>
<form class="form" method="post" action="/dashboard/kategorie">
    <input type="text" name="nazev" placeholder="Název kategorie" required>
    <button name="novaKategorie" type="submit">Uložit</button>
</form>

<?php if (!empty($message)) echo "<p>$message</p>"; ?>
</div>
