<section id="clankyAutora">
    <?php

use Model\Stav;

 if (!empty($message)) echo "<p>$message</p>"; ?>
    <table>
        <thead>
            <tr>
            <th></th>
            <?= $_SESSION["uzivatel_role"] != 2 ? "<th>Autor</th>" : "" ?>
            <th>Nadpis</th>
            <th>Kategorie</th>
            <th>Datum vytvoření</th>
            <th>Zhlednutí</th>
            <th>Stav</th>
            <th>Akce</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($clanky as $clanek) {

            ?>
                <tr>
                <td><div class="carka <?=barvaPozadi($clanek->idStav)?>"></div></td>
                    <?php
                    if ($_SESSION["uzivatel_role"] != 2) {
                        foreach ($uzivatele as $uzivatel) {
                            if ($uzivatel->id == $clanek->idAutor) {
                                echo "<td data-label='Autor' class='jmeno'>".htmlspecialchars($uzivatel->jmeno)."</td>";
                                break;
                            }
                        }
                    }
                    ?>
                    <td data-label="Nadpis"><?= htmlspecialchars($clanek->nadpis) ?></td>
                    <td data-label="Kategorie"><?= htmlspecialchars($kategorie[$clanek->idKategorie - 1]->nazev) ?></td>
                    <td data-label="Datum vytvoření" class="datum"><?= $clanek->createdAt->format('d-m-Y') ?></td>
                    <td data-label="Zhlednutí"><?= $clanek->zhlednuti ?></td>
                    <form method="post" action="/dashboard/clanky">
                        <td data-label="Stav">
                            <select name="stavClanku" id="stav" onchange="this.form.submit()">
                                <?php
                                foreach ($stavy as $stav) {
                                    if ($_SESSION['uzivatel_role'] == 2) {
                                        if ($stav->id >= 3) {
                                ?>
                                            <option disabled value="<?= $stav->id ?>" <?php if ($clanek->idStav == $stav->id) echo 'selected' ?>><?= htmlspecialchars($stav->stav) ?></option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="<?= $stav->id ?>" <?php if ($clanek->idStav == $stav->id) echo 'selected' ?>><?= htmlspecialchars($stav->stav) ?></option>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <option value="<?= $stav->id ?>" <?php if ($clanek->idStav == $stav->id) echo 'selected' ?>><?= htmlspecialchars($stav->stav) ?></option>
                                    <?php
                                    }
                                    ?>
                                <?php
                                }
                                ?>
                            </select>
                            <input type="hidden" name="idClanku" value="<?= $clanek->id ?>">
                        </td>
                    </form>
                    <td data-label="Akce">
                        <button class="edit-btn"><a href="/dashboard/clanky/edit/<?= $clanek->id ?>">Editovat</a></button>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</section>

<?php

function barva($idStav){
    switch ($idStav) {
        case '1':
            return "cerna";
            break;
        
        case '2':
            return "modra";
            break;
        
        case '3':
            return "modrozelena";
            break;
        
        case '4':
            return "zelena";
            break;
        
        case '5':
            return "cervena";
            break;
        
        case '6':
            return "cervena";
            break;
        
        default:
            break;
    }
}
function barvaPozadi($idStav){
    switch ($idStav) {
        case '1':
            return "cernaP";
            break;
        
        case '2':
            return "modraP";
            break;
        
        case '3':
            return "modrozelenaP";
            break;
        
        case '4':
            return "zelenaP";
            break;
        
        case '5':
            return "cervenaP";
            break;
        
        case '6':
            return "cervenaP";
            break;
        
        default:
            break;
    }
}


