<section id="komentareAutora">
    <?php if (!empty($message)) echo "<p>$message</p>"; ?>
    <table>
        <thead>
            <tr>
                <th>Obsah</th>
                <th>Článek</th>
                <th>Datum vytvoření</th>
                <th>Stav</th>
            </tr>
        </thead>
        <tbody>
            <?php

            foreach ($komentare as $komentar) {
                $vybranyClanek = array_filter($clanky, function ($clanek) use ($komentar) {
                    return $clanek->id === $komentar->idClanek;
                });
                $vybranyClanek = reset($vybranyClanek);
            ?>
                <tr>
                    <td data-label="Obsah"><?= htmlspecialchars($komentar->obsah) ?></td>
                    <td data-label="Článek"><?= htmlspecialchars($vybranyClanek->nadpis) ?></td>
                    <td class="datum" data-label="Datum vytvoření"><?= $komentar->createdAt->format('d-m-Y') ?></td>
                    <td data-label="Stav">
                        <form method="POST" action="/dashboard/komentare">
                            <input type="hidden" name="idKomentare" value="<?= $komentar->id ?>">
                            <select name="stav" onchange="this.form.submit()">
                                <option value="1" <?= $komentar->stav ? 'selected' : '' ?>>Viditelný</option>
                                <option value="0" <?= !$komentar->stav ? 'selected' : '' ?>>Skrytý</option>
                            </select>
                        </form>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</section>
