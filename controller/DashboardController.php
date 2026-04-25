<?php

namespace Controller {

    use Model\Clanek;
    use Model\ClankyTagy;
    use Model\Obrazek;
    use Model\Kategorie;
    use Model\Komentar;
    use Model\Tag;
    use Model\Role;
    use Model\Stav;
    use Model\Uzivatel;

    class DashboardController extends Controller
    {
        protected ?int $potrebnaRole = 2;

        public function zpracuj(array $params): void
        {
            require_once 'Validator.php';


            $stavy = Stav::ziskatVse();
            $kategorie = Kategorie::ziskatVse();
            $clanky = Clanek::ziskatVse();

            $this->data["stavy"] = $stavy;
            $this->data['kategorie'] = $kategorie;
            $this->data['clanky'] = $clanky;

            if (isset($_POST['zmenaRole']) && isset($_POST['idUzivatele'])) { //Uživatelé

                $uzivatel = Uzivatel::ziskatPodleId($_POST["idUzivatele"]);
                if ($uzivatel) {
                    $uzivatel->idRole = (int)$_POST['idRole'];
                    if ($uzivatel->insUpdUzivatel()) {
                        $this->data['message'] = 'Role uživatele byla úspěšně aktualizována.';
                    } else {
                        $this->data['message'] = 'Chyba při aktualizaci role uživatele.';
                    }
                } else {
                    $this->data['message'] = 'Uživatel nenalezen.';
                }
            }

            if (isset($_POST['pridatUzivatele'])) {
                $jmeno = trim($_POST['jmeno']) ?? '';
                $email = trim($_POST['email']) ?? '';
                $heslo = trim($_POST['heslo']) ?? '';
                $hesloZnovu = trim($_POST['hesloZnovu']) ?? '';
                $idRole = (int)$_POST['idRole'];

                $chyba = "";
                $chyba .= Validator::notEmpty($jmeno, "jmeno");
                $chyba .= Validator::noSpecialChars($jmeno, "jmeno");

                $chyba .= Validator::notEmpty($email, "email");
                $chyba .= Validator::noSpecialChars($email, "email");
                $chyba .= Validator::validEmail($email);

                $chyba .= Validator::validateHeslo($heslo);

                $chyba .= Validator::validateHeslo($hesloZnovu);

                if ($heslo != $hesloZnovu) {
                    $chyba .= "Zadaná hesla se neschodují";
                }

                $chyba .= Validator::notEmpty($idRole, "role");

                if ($chyba) {
                    $this->data['message'] = $chyba;
                } else {

                    $existujiciUzivatel = Uzivatel::ziskatPodleEmailu($email);

                    if ($existujiciUzivatel != null) {
                        $this->data['message'] = 'Uživatel s tímto emailem již existuje.';
                    } else {

                        $uzivatel = new Uzivatel();
                        $uzivatel->jmeno = $jmeno;
                        $uzivatel->email = $email;
                        $uzivatel->heslo = $heslo;
                        $uzivatel->idRole = $idRole;

                        if ($uzivatel->insUpdUzivatel()) {
                            $this->presmeruj('dashboard/uzivatele');
                        } else {
                            $this->data['message'] = 'Chyba při přidávání uživatele.';
                        }
                    }
                }
            }

            if (isset($_POST['novaKategorie'])) { //Kategorie
                $nazev = trim($_POST['nazev']) ?? '';

                if (empty($nazev)) {
                    $this->data['message'] = 'Název kategorie nesmí být prázdný.';
                } elseif (preg_match('/[<>{}()"\'`;]/', $nazev)) {
                    $this->data['message'] = 'Název kategorie obsahuje nepovolené speciální znaky.';
                } elseif (strlen($nazev) > 255) {
                    $this->data['message'] = 'Název kategorie nesmí být delší než 255 znaků.';
                } elseif (Kategorie::ziskatNumFilter(1, 'nazev', $nazev)) {
                    $this->data['message'] = 'Kategorie s tímto názvem již existuje.';
                } else {
                    $kategorie = new Kategorie();
                    $kategorie->vytvorKategorii($nazev);

                    if ($kategorie->insUpdKategorie()) {
                        $this->data['message'] = 'Kategorie byla úspěšně přidána.';
                    } else {
                        $this->data['message'] = 'Chyba při přidávání kategorie.';
                    }
                }
            }
            if (isset($_POST['editKategorie'])) {
                $idKategorie = $_POST["idKategorie"];
                $nazev = trim($_POST['nazev']) ?? '';
                $kategorie = Kategorie::ziskatPodleId($idKategorie);


                $chyba = "";
                $chyba .= Validator::notEmpty($nazev, "Název kategorie");
                $chyba .= Validator::noSpecialChars($nazev, "Název kategorie");
                $chyba .= Validator::lengthBetween($nazev, 0, 255, "Název kategorie");


                if ($chyba) {
                    $this->data['message'] = $chyba;
                } else {
                    $kategorie->nazev = $nazev;

                    if ($kategorie->insUpdKategorie()) {
                        $this->data['message'] = 'Kategorie byla úspěšně upravena.';
                    } else {
                        $this->data['message'] = 'Chyba při úpravě kategorie.';
                    }
                }
            }

            if (isset($_POST['novyTag'])) { // Tagy
                $nazev = trim($_POST['nazev']) ?? '';

                $chyba = "";
                $chyba .= Validator::notEmpty($nazev, "Název tagu");
                $chyba .= Validator::noSpecialChars($nazev, "Název tagu");
                $chyba .= Validator::lengthBetween($nazev, 0, 255, "Název tagu");
                if (Tag::ziskatNumFilter(1, 'nazev', $nazev)) {
                    $chyba .= "Tag s tímto názvem již existuje.";
                }

                if ($chyba) {
                    $this->data['message'] = $chyba;
                } else {
                    $tag = new Tag();
                    $tag->vytvorTag($nazev);

                    if ($tag->insUpdTag()) {
                        $this->data['message'] = 'Tag byl úspěšně přidán.';
                    } else {
                        $this->data['message'] = 'Chyba při přidávání tagu.';
                    }
                }
            }
            if (isset($_POST['editTag'])) {
                $idTag = $_POST['idTag'];
                $nazev = trim($_POST['nazev']) ?? '';
                $tag = Tag::ziskatPodleId($idTag);

                $chyba = "";
                $chyba .= Validator::notEmpty($nazev, "Název tagu");
                $chyba .= Validator::noSpecialChars($nazev, "Název tagu");
                $chyba .= Validator::lengthBetween($nazev, 0, 255, "Název tagu");

                if ($chyba) {
                    $this->data['message'] = $chyba;
                } else {
                    $tag->nazev = $nazev;

                    if ($tag->insUpdTag()) {
                        $this->data['message'] = 'Tag byl úspěšně upraven.';
                    } else {
                        $this->data['message'] = 'Chyba při úpravě tagu.';
                    }
                }
            }

            if (isset($_POST['zmenaHesla'])) { //Ucet
                $heslo = $_POST['heslo'] ?? '';
                $noveHeslo = $_POST['noveHeslo'] ?? '';
                $noveHesloZnovu = $_POST['noveHesloZnovu'] ?? '';

                $chyba = "";
                $chyba .= Validator::validateHeslo($heslo);
                $chyba .= Validator::validateHeslo($noveHeslo);
                $chyba .= Validator::validateHeslo($noveHesloZnovu);

                if ($chyba) {
                    $this->data['errorZmenaHesla'] = $chyba;
                } else {

                    $existujiciUzivatel = Uzivatel::ziskatPodleId($_SESSION['uzivatel_id']);

                    if ($existujiciUzivatel->overitHeslo($heslo)) {

                        if ($noveHeslo == $noveHesloZnovu) {

                            $existujiciUzivatel->heslo = $noveHeslo;

                            if ($existujiciUzivatel->insUpdUzivatel()) {
                                $this->data['successZmenaHesla'] = 'Změna hesla se zdařila.';
                            } else {
                                $this->data['errorZmenaHesla'] = 'Změna hesla se nezdařila. Zkuste to prosím znovu.';
                            }
                        } else {
                            $this->data['errorZmenaHesla'] = 'Nesla se neshodují.';
                        }
                    } else {
                        $this->data['errorZmenaHesla'] = 'Špatné heslo.';
                    }
                }
            }

            if (isset($_POST['zmenaJmena'])) {
                $noveJmeno = $_POST['noveJmeno'] ?? '';
                $existujiciUzivatel = Uzivatel::ziskatPodleId($_SESSION['uzivatel_id']);

                $chyba = "";
                $chyba .= Validator::notEmpty($noveJmeno);
                $chyba .= Validator::noSpecialChars($noveJmeno, "Jmeno");
                $chyba .= Validator::lengthBetween($noveJmeno, 0, 255, "Jmeno");

                if ($chyba) {
                    $this->data['errorZmenaJmena'] = $chyba;
                } else {
                    $existujiciUzivatel->jmeno = $noveJmeno;

                    if ($existujiciUzivatel->insUpdUzivatel()) {
                        $_SESSION['uzivatel_jmeno'] = $noveJmeno;
                        $this->data['successZmenaJmena'] = 'Změna jména se zdařila.';
                    } else {
                        $this->data['errorZmenaJmena'] = 'Změna jména se nezdařila. Zkuste to prosím znovu.';
                    }
                }
            }

            if (isset($_POST['zmenaEmailu'])) {
                $novyEmail = $_POST['novyEmail'] ?? '';
                $existujiciUzivatel = Uzivatel::ziskatPodleId($_SESSION['uzivatel_id']);

                $chyba = "";
                $chyba .= Validator::notEmpty($novyEmail);
                $chyba .= Validator::noSpecialChars($novyEmail, "Email");
                $chyba .= Validator::validEmail($novyEmail);
                $chyba .= Validator::lengthBetween($novyEmail, 0, 255, "Email");

                if ($chyba) {
                    $this->data['errorZmenaEmailu'] = $chyba;
                } else {
                    $existujiciUzivatel->email = $novyEmail;

                    if ($existujiciUzivatel->insUpdUzivatel()) {
                        $this->data['successZmenaEmailu'] = 'Změna emailu se zdařila.';
                    } else {
                        $this->data['errorZmenaEmailu'] = 'Změna emailu se nezdařila. Zkuste to prosím znovu.';
                    }
                }
            }
            if (isset($_POST['zmenaPopisu'])) {
                $novyPopis = $_POST['novyPopis'] ?? '';
                $existujiciUzivatel = Uzivatel::ziskatPodleId($_SESSION['uzivatel_id']);

                $chyba = "";
                $chyba .= Validator::notEmpty($novyPopis);
                $chyba .= Validator::noSpecialChars($novyPopis, "Popis");
                $chyba .= Validator::lengthBetween($novyPopis, 0, 600, "Popis");

                if ($chyba) {
                    $this->data['errorZmenaPopisu'] = $chyba;
                } else {
                    $existujiciUzivatel->popis = $novyPopis;

                    if ($existujiciUzivatel->insUpdUzivatel()) {
                        $this->data['successZmenaPopisu'] = 'Změna popisu se zdařila.';
                    } else {
                        $this->data['errorZmenaPopisu'] = 'Změna popisu se nezdařila. Zkuste to prosím znovu.';
                    }
                }
            }
            if (isset($_POST['zmenaProfilovky'])) {
                $existujiciUzivatel = Uzivatel::ziskatPodleId($_SESSION['uzivatel_id']);
                if (isset($_FILES['novaProfilovka'])) {

                    
                    $file = [
                        'name' => $_FILES['novaProfilovka']['name'],
                        'type' => $_FILES['novaProfilovka']['type'],
                        'tmp_name' => $_FILES['novaProfilovka']["tmp_name"],
                        'error' => $_FILES['novaProfilovka']['error'],
                        'size' => $_FILES['novaProfilovka']['size'],
                    ];
                    if ($existujiciUzivatel->insUpdUzivatel($file)) {
                        $this->data['successZmenaProfilovky'] = 'Profilový obrázek byl úspěšně změněn.';
                    } else {
                        $this->data['errorZmenaProfilovky'] = 'Změna profilového obrázku se nezdařila. Zkuste to prosím znovu.';
                    }
                } else {
                    $this->data['errorZmenaProfilovky'] = 'Nepodařilo se nahrát soubor. Zkontrolujte formát a velikost souboru.';
                }
            }

            if (isset($_POST['idKomentare']) && isset($_POST['stav'])) { //Změna stavu komentáře
                $idKomentare = $_POST['idKomentare'];
                $stav = $_POST['stav'] == '1' ? true : false;

                $komentar = Komentar::ziskatPodleId($idKomentare);
                $komentar->stav = $stav;
                $komentar->insUpdKomentar();
            }

            if (isset($_POST['idClanku']) && isset($_POST["stavClanku"])) { //Změna stavu článku
                $idClanku  = $_POST['idClanku'];
                $stav = $_POST['stavClanku'];

                if ($_SESSION['uzivatel_role'] == 2 && $stav != 1 && $stav != 2) {
                    $this->data['message'] = 'Pro tuto úpravu nemáte oprávnění.';
                } else {
                    $clanek = Clanek::ziskatPodleId($idClanku);
                    $clanek->idStav = $stav;
                    if ($clanek->insUpdClanek()) {
                        $this->data['message'] = 'Stav článku byl úspěšně změněn.';
                    } else {
                        $this->data['message'] = 'Chyba při změně stavu článku.';
                    }
                    $role = $_SESSION['uzivatel_role'];
                    $uzivatelId = $_SESSION['uzivatel_id'];
                    if ($role >= 3) { // Redaktor, Admin
                        $clanky = Clanek::ziskatVse();
                    } else if ($role == 2) { // Autor
                        $clanky = Clanek::ziskatVsePodleAutora($uzivatelId);
                    }
                }


                $this->data['clanky'] = $clanky;
            }

            if (isset($_POST['novyClanek'])) { //Nový článek
                $idKategorie = trim($_POST['idKategorie'] ?? '');
                $tagy = trim($_POST['tagy'] ?? '');
                $nadpis = trim($_POST['nadpis'] ?? '');
                $upoutavka = trim($_POST['upoutavka'] ?? '');
                $obsah = trim($_POST['obsah'] ?? '');
                $uryvek = trim($_POST['uryvek'] ?? '');
                $idUzivatele = $_SESSION['uzivatel_id'] ?? null;

                $chyba = "";
                $chyba .= Validator::notEmpty($idKategorie, "ID kategorie");

                $chyba .= Validator::notEmpty($tagy, "Tagy");
                $chyba .= Validator::noSpecialChars($tagy, "Tagy");
                $chyba .= Validator::lengthBetween($tagy, 0, 255, "Tagy");

                $chyba .= Validator::notEmpty($nadpis, "Nadpis");
                $chyba .= Validator::noSpecialChars($nadpis, "Nadpis");
                $chyba .= Validator::lengthBetween($nadpis, 0, 20000, "Nadpis");

                $chyba .= Validator::notEmpty($upoutavka, "Upoutávka");
                $chyba .= Validator::noSpecialChars($upoutavka, "Upoutávka");
                $chyba .= Validator::lengthBetween($upoutavka, 0, 20000, "Upoutávka");

                $chyba .= Validator::notEmpty($uryvek, "Úryvek");
                $chyba .= Validator::noSpecialChars($uryvek, "Úryvek");
                $chyba .= Validator::lengthBetween($uryvek, 0, 20000, "Úryvek");

                $chyba .= Validator::notEmpty($obsah, "Obsah");
                $chyba .= Validator::lengthBetween($obsah, 0, 16777215, "Obsah"); // mediumtext

                $chyba .= Validator::notEmpty($idUzivatele, "Uživatel");
                $chyba .= Validator::notEmpty($idKategorie, "Kategorie");

                if ($chyba) {
                    $this->data['error'] = $chyba;
                } else {
                    $clanek = new Clanek();
                    $clanek->vytvorClanek($nadpis, $upoutavka, $uryvek, $obsah, $idUzivatele, $idKategorie);

                    $aaa = $clanek->insUpdClanek();
                    if ($aaa) {
                        $idClanek = $clanek->id;

                        $tagy = explode(",", $tagy);
                        foreach ($tagy as $tag) {
                            $vysledek = Tag::ziskatPodleNazvu($tag);
                            if ($vysledek == null) {
                                $novyTag = new Tag();
                                $novyTag->vytvorTag($tag);
                                $novyTag->insUpdTag();
                                $tag = $novyTag;
                            } else {
                                $tag = $vysledek;
                            }
                            $clanekTag = new ClankyTagy();
                            $clanekTag->vytvorClankyTagy($idClanek, $tag->id);
                            $clanekTag->insClankyTagy();
                        }

                        if (isset($_FILES['obrazky'])) {

                            foreach ($_FILES['obrazky']['tmp_name'] as $index => $tmpName) {
                                $file = [
                                    'name' => $_FILES['obrazky']['name'][$index],
                                    'type' => $_FILES['obrazky']['type'][$index],
                                    'tmp_name' => $tmpName,
                                    'error' => $_FILES['obrazky']['error'][$index],
                                    'size' => $_FILES['obrazky']['size'][$index],
                                ];

                                $obrazek = new Obrazek();
                                $vysledek = $obrazek->insUpdObrazek($file, $idClanek);
                                if ($vysledek === true) {
                                    $this->data['message'] = 'Nahrání bylo úspěšné.';
                                } else {
                                    $this->data['error'] = $vysledek;
                                }
                            }
                        }
                    }
                    $this->presmeruj("dashboard/clanky");
                }
            }

            if (isset($_POST['editClanek'])) { // Editace článku
                $idClanek = trim($_POST['idClanek'] ?? '');
                $idKategorie = trim($_POST['idKategorie'] ?? '');
                $idStav = trim($_POST['idStav'] ?? '');
                $tagy = trim($_POST['tagy'] ?? '');
                $nadpis = trim($_POST['nadpis'] ?? '');
                $upoutavka = trim($_POST['upoutavka'] ?? '');
                $obsah = trim($_POST['obsah'] ?? '');
                $uryvek = trim($_POST['uryvek'] ?? '');
                $idUzivatele = $_SESSION['uzivatel_id'] ?? null;
                $odstranitObrDbId = json_decode($_POST['odstranitObrazky']) ?? null;

                $tagy = explode(",", $tagy);

                $chyba = "";
                $chyba .= Validator::notEmpty($idClanek, "ID článku");
                $chyba .= Validator::notEmpty($idKategorie, "ID kategorie");

                $chyba .= Validator::notEmpty($idStav, "ID stavu");
                $chyba .= Validator::notEmpty($idStav, "ID stavu");

                foreach ($tagy as $tag) {
                    $chyba .= Validator::notEmpty($tag, "Tagy");
                    $chyba .= Validator::noSpecialChars($tag, "Tagy");
                    $chyba .= Validator::lengthBetween($tag, 0, 255, "Tagy");
                }

                $chyba .= Validator::notEmpty($nadpis, "Nadpis");
                $chyba .= Validator::noSpecialChars($nadpis, "Nadpis");
                $chyba .= Validator::lengthBetween($nadpis, 0, 20000, "Nadpis");

                $chyba .= Validator::notEmpty($upoutavka, "Upoutávka");
                $chyba .= Validator::noSpecialChars($upoutavka, "Upoutávka");
                $chyba .= Validator::lengthBetween($upoutavka, 0, 20000, "Upoutávka");

                $chyba .= Validator::notEmpty($uryvek, "Úryvek");
                $chyba .= Validator::noSpecialChars($uryvek, "Úryvek");
                $chyba .= Validator::lengthBetween($uryvek, 0, 20000, "Úryvek");

                $chyba .= Validator::notEmpty($obsah, "Obsah");
                $chyba .= Validator::lengthBetween($obsah, 0, 16777215, "Obsah");

                $chyba .= Validator::notEmpty($idUzivatele, "Uživatel");
                $chyba .= Validator::notEmpty($idKategorie, "Kategorie");

                if ($chyba) {
                    $this->data['error'] = $chyba;
                } else {
                    $clanek = new Clanek();
                    $clanek = $clanek->ziskatPodleId($idClanek);
                    $clanek->nadpis = $nadpis;
                    $clanek->upoutavka = $upoutavka;
                    $clanek->uryvek = $uryvek;
                    $clanek->obsah = $obsah;
                    $clanek->idKategorie = $idKategorie;

                    if ($_SESSION['uzivatel_role'] == 2 && $stav != 1 && $stav != 2) {
                    } else {
                        $clanek->idStav = $idStav;
                    }

                    $clanek->insUpdClanek();

                    ClankyTagy::smazatPodleClanku($idClanek);
                    foreach ($tagy as $tag) {
                        $vysledek = Tag::ziskatPodleNazvu($tag);
                        if ($vysledek == null) {
                            $novyTag = new Tag();
                            $novyTag->vytvorTag($tag);
                            $novyTag->insUpdTag();
                            $tag = $novyTag;
                        } else {
                            $tag = $vysledek;
                        }
                        $clanekTag = new ClankyTagy();
                        $clanekTag->vytvorClankyTagy($idClanek, $tag->id);
                        $clanekTag->insClankyTagy();
                    }

                    if (isset($odstranitObrDbId)) {
                        foreach ($odstranitObrDbId as $obrazekId) {
                            Obrazek::smazatPodleId($obrazekId);
                        }
                    }

                    if (isset($_FILES['obrazky'])) {
                        $uploadedFiles = [];
                        foreach ($_FILES['obrazky']['tmp_name'] as $index => $tmpName) {
                            $file = [
                                'name' => $_FILES['obrazky']['name'][$index],
                                'type' => $_FILES['obrazky']['type'][$index],
                                'tmp_name' => $tmpName,
                                'error' => $_FILES['obrazky']['error'][$index],
                                'size' => $_FILES['obrazky']['size'][$index],
                            ];

                            if (!in_array($file['name'], $uploadedFiles)) {
                                $uploadedFiles[] = $file['name'];

                                $obrazek = new Obrazek();
                                $vysledek = $obrazek->insUpdObrazek($file, $idClanek);

                                if ($vysledek === true) {
                                    $this->data['message'] = 'Nahrání bylo úspěšné.';
                                } else {
                                    $this->data['error'] = $vysledek;
                                }
                            }
                        }
                    }
                }
            }

            if (isset($params[0])) { //Switch pro zobrazení stránek dashboardu
                $role = $_SESSION['uzivatel_role'];
                $uzivatelId = $_SESSION['uzivatel_id'];

                switch ($params[0]) {
                    case 'clanky':
                        if (isset($params[1])) {
                            if (str_contains($params[1], "novy")) {
                                if ($role >= 2) { //Autor, Redaktor, Admin
                                    $this->view = "dashboardClankyNovy";
                                }
                            } else {
                                $clanek = Clanek::ziskatPodleId($params[2]);
                                if ($role >= 3 || ($role == 2 && $clanek->idAutor == $uzivatelId)) { //Autor upravuje svůj článek nebo má vyšší oprávnění pro všechny články
                                    $obrazky = Obrazek::ziskatPodleIdClanku($clanek->id);
                                    $tagy = Tag::ziskatVse();
                                    $clanekTag = ClankyTagy::ziskatPodleClanku($clanek->id);
                                    $this->data["clanek"] = $clanek;
                                    $this->data["obrazky"] = $obrazky;
                                    $this->data["tagy"] = $tagy;
                                    $this->data["clanekTag"] = $clanekTag;
                                    $this->view = "dashboardClankyEdit";
                                }
                            }
                        } else {
                            $uzivatele = Uzivatel::ziskatVse();
                            $this->data["uzivatele"] = $uzivatele;
                            if ($role >= 3) { //Redaktor, Admin
                                $this->view = "dashboardClanky";
                            } else if ($role == 2) { //Autor
                                $clankyAutora = Clanek::ziskatVsePodleAutora($uzivatelId);
                                $this->data['clanky'] = $clankyAutora;
                                $this->view = "dashboardClanky";
                            }
                        }
                        break;
                    case 'uzivatele':
                        if ($role >= 4) { //Admin
                            if (isset($params[1])) {
                                if ($params[1] == "novy") {
                                    $this->data["role"] = Role::ziskatVse();
                                    $this->view = "dashboardUzivateleNovy";
                                }
                            } else {
                                $this->data["uzivatele"] = Uzivatel::ziskatVse();
                                $this->data["role"] = Role::ziskatVse();
                                $this->view = "dashboardUzivatele";
                            }
                        }
                        break;
                    case 'kategorie':
                        if ($role >= 3) { //Redaktor, Admin
                            if (isset($params[1])) {
                                if ($params[1] == "novy") {
                                    $this->view = "dashboardKategorieNovy";
                                } else {
                                    $kategorie = Kategorie::ziskatPodleId($params[2]);
                                    $this->data["kategorie"] = $kategorie;
                                    $this->view = "dashboardKategorieEdit";
                                }
                            } else {
                                $this->data["kategorie"] = Kategorie::ziskatVse();
                                $this->view = "dashboardKategorie";
                            }
                        }
                        break;
                    case 'tagy':
                        if ($role >= 2) { //Autor, Redaktor, Admin
                            if (isset($params[1])) {
                                if ($params[1] == "novy") {
                                    $this->view = "dashboardTagyNovy";
                                } else {
                                    $tag = Tag::ziskatPodleId($params[2]);
                                    $this->data["tag"] = $tag;
                                    $this->view = "dashboardTagyEdit";
                                }
                            } else {
                                $this->data["tagy"] = Tag::ziskatVse();
                                $this->view = "dashboardTagy";
                            }
                        }
                        break;
                    case 'komentare':
                        if ($role >= 4) { //Admin
                            $this->data["komentare"] = Komentar::ziskatVse();
                            $this->view = "dashboardKomentare";
                        }
                        break;
                    case 'ucet':
                        $this->view = "dashboardUcet";
                        break;

                    default:
                        $this->view = "dashboardClanky";
                        break;
                }
            } else {
                $this->view = "dashboardClanky";
            }
        }
    }
}
