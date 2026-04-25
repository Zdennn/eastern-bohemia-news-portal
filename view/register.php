<main>
    <div class="register">
        <h1>Registrace</h1>
        <p>Již máte účet? <a href="/login">Přihlaste se zde</a></p>

        <?php if (!empty($error)) { ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php } ?>

        <form method="post">
            <div class="input-wrapper">
                <input
                    type="text"
                    name="jmeno"
                    placeholder="Jméno"
                    required
                    value="<?php echo isset($_POST['jmeno']) ? htmlspecialchars($_POST['jmeno']) : ''; ?>">
                <span class="error-zprava">Jméno není platné</span>
            </div>
            <div class="input-wrapper">
                <input
                    type="email"
                    name="email"
                    placeholder="Email"
                    required
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                <span class="error-zprava">Neplatný e-mail</span>
            </div>
            <div class="input-wrapper">
                <input
                    type="password"
                    name="heslo"
                    placeholder="Heslo"
                    required>
                <span class="error-zprava">Heslo musí mít alespoň 8 znaků, obsahovat malé a velké písmeno a číslici</span>
            </div>
            <div class="input-wrapper">
                <input
                    type="password"
                    name="hesloZnovu"
                    placeholder="Heslo znovu"
                    required>
                <span class="error-zprava">Heslo musí mít alespoň 8 znaků, obsahovat malé a velké písmeno a číslici</span>
            </div>

            <button type="submit">Registrovat se</button>
        </form>
    </div>
</main>