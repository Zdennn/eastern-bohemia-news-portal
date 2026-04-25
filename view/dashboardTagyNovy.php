<div class="formDiv">

<h1>Nový tag</h1>
<form class="form" method="post" action="/dashboard/tagy">
    <input type="text" name="nazev" placeholder="Název tagu" required>
    <button name="novyTag" type="submit">Uložit</button>
</form>

<?php if (!empty($message)) echo "<p>$message</p>"; ?>
</div>
