</header>
<main>
    <?php
    $url = $_SERVER['REQUEST_URI'];
    $url = explode("/", $url);
    ?>
    <a class="zpet" href="<?= '/' . $url[0] . $url[1] . '/' . $url[2] ?>"><span class="material-symbols-outlined">arrow_back</span></a>

    <section class="hlavni">

        <h1>Změna hesla</h1>
        <form method="post">
            <?php if (!empty($errorZmenaHesla)) { ?>
                <p style="color: red;"><?php echo $errorZmenaHesla; ?></p>
            <?php } ?>
            <?php if (!empty($successZmenaHesla)) echo "<p>$successZmenaHesla</p>"; ?>
            <input type="password" name="heslo" placeholder="Heslo" required>
            <span class="error-zprava"></span>
            <input type="password" name="noveHeslo" placeholder="Nové heslo" required>
            <span class="error-zprava"></span>
            <input type="password" name="noveHesloZnovu" placeholder="Nové heslo znovu" required>
            <span class="error-zprava"></span>
            <button type="submit" name="zmenaHesla">Změnit heslo</button>
        </form>

        <h1>Změna jména</h1>
        <form method="post">
            <?php if (!empty($errorZmenaJmena)) { ?>
                <p style="color: red;"><?php echo $errorZmenaJmena; ?></p>
            <?php } ?>
            <?php if (!empty($successZmenaJmena)) echo "<p>$successZmenaJmena</p>"; ?>
            <input type="text" name="noveJmeno" placeholder="Nové jméno" required>
            <span class="error-zprava"></span>
            <button type="submit" name="zmenaJmena">Změnit jméno</button>
        </form>

        <h1>Změna emailu</h1>
        <form method="post">
            <?php if (!empty($errorZmenaEmailu)) { ?>
                <p style="color: red;"><?php echo $errorZmenaEmailu; ?></p>
            <?php } ?>
            <?php if (!empty($successZmenaEmailu)) echo "<p>$successZmenaEmailu</p>"; ?>
            <input type="email" name="novyEmail" placeholder="Nový email" required>
            <span class="error-zprava"></span>
            <button type="submit" name="zmenaEmailu">Změnit email</button>
        </form>

        <h1>Změna popisu</h1>
        <form method="post">
            <?php if (!empty($errorZmenaPopisu)) { ?>
                <p style="color: red;"><?php echo $errorZmenaPopisu; ?></p>
            <?php } ?>
            <?php if (!empty($successZmenaPopisu)) echo "<p>$successZmenaPopisu</p>"; ?>
            <textarea name="novyPopis" placeholder="Nový Popis" required></textarea>
            <span class="error-zprava"></span>
            <button type="submit" name="zmenaPopisu">Změnit popis</button>
        </form>

        <h1>Změna profilového obrázku</h1>
        <form method="post" enctype="multipart/form-data">
            <?php if (!empty($errorZmenaProfilovky)) { ?>
                <p style="color: red;"><?php echo $errorZmenaProfilovky; ?></p>
            <?php } ?>
            <?php if (!empty($successZmenaProfilovky)) echo "<p>$successZmenaProfilovky</p>"; ?>
            <input type="file" accept="image/*" name="novaProfilovka" required>
            <button type="submit" name="zmenaProfilovky">Změnit profilový obrázek</button>
        </form>
    </section>
</main>