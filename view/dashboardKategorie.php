<section id="tabulka">
    <table>
        <thead>
            <tr>
                <th>Název</th>
                <th>Akce</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($kategorie as $kategorieItem) {
            ?>
                <tr>
                    <td data-label="Název"><?= htmlspecialchars($kategorieItem->nazev) ?></td>
                    <td data-label="Akce">
                        <button class="edit-btn">
                            <a href="/dashboard/kategorie/edit/<?= $kategorieItem->id ?>">Editovat</a>
                        </button>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</section>
