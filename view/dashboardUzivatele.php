<section id="tabulka">
<?php if (!empty($message)) echo "<p>$message</p>"; ?>
    <table>
        <thead>
            <tr>
                <th>Jméno</th>
                <th>Email</th>
                <th>Datum vytvoření</th>
                <th>Popis</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($uzivatele as $uzivatel) {
            ?>
                <tr>
                    <td data-label="Jméno"><?= htmlspecialchars($uzivatel->jmeno) ?></td>
                    <td data-label="Email"><?= htmlspecialchars($uzivatel->email) ?></td>
                    <td data-label="Datum vytvoření" class="datum"><?= $uzivatel->createdAt->format('d-m-Y') ?></td>
                    <td data-label="Popis" class="popis"><?= substr(htmlspecialchars($uzivatel->popis ?? 'N/A'), 0, 230)."..." ?></td>
                    <td data-label="Role">
                        <form method="POST" action="/dashboard/uzivatele">
                            <input type="hidden" name="idUzivatele" value="<?= $uzivatel->id ?>">
                            <select name="idRole" onchange="this.form.submit()">
                                <?php foreach ($role as $jednaRole) { ?>
                                    <option value="<?= $jednaRole->id ?>" <?= $jednaRole->id === $uzivatel->idRole ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($jednaRole->nazev) ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input type="hidden" name="zmenaRole" value="1">
                        </form>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</section>
