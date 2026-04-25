<main>
    <div class="login">
        <h1>Vítejte zpět!</h1>
        <p>Nemáte účet? <a href="/register">Zaregistrujte se nyní</a>, <br>zabere to méně než minutku.</p>

        <?php if (!empty($error)): ?>
            <p style="color: red;"><?= $error; ?></p>
        <?php endif; ?>

        <form method="post">
            <div class="input-wrapper">
                <input
                    type="email"
                    name="email"
                    placeholder="Email"
                    required
                    value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                    >
                <span class="error-zprava">Neplatný e-mail</span>
            </div>
            <div class="input-wrapper">
                <input
                    type="password"
                    name="heslo"
                    placeholder="Heslo"
                    required
                    >
                <span class="error-zprava">Heslo musí mít alespoň 8 znaků</span>
            </div>

            <button type="submit">Přihlást se</button>
        </form>
    </div>
</main>