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
            foreach ($tagy as $tag) {
            ?>
                <tr>
                    <td data-label="Název"><?= htmlspecialchars($tag->nazev) ?></td>
                    <td data-label="Akce">
                        <button class="edit-btn">
                            <a href="/dashboard/tagy/edit/<?= $tag->id ?>">Editovat</a>
                        </button>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</section>
