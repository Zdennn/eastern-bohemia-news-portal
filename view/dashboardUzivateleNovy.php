<main>
    <div class="register">
        <h1>Přidání uživatele</h1>
        <p>Vyplňte údaje nového uživatele.</p>

        <?php if (!empty($message)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

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
                    placeholder="Heslo Znovu"
                    required>
                <span class="error-zprava">Heslo musí mít alespoň 8 znaků, obsahovat malé a velké písmeno a číslici</span>
            </div>
            <div class="input-wrapper">
                <select name="idRole" required>
                    <?php foreach ($role as $jednaRole) { ?>
                        <option value="<?= $jednaRole->id ?>">
                            <?= htmlspecialchars($jednaRole->nazev) ?>
                        </option>
                    <?php } ?>
                </select>
                <span class="error-zprava">Vyberte platnou roli</span>
            </div>

            <button type="submit" name="pridatUzivatele">Přidat uživatele</button>
        </form>
    </div>
</main>