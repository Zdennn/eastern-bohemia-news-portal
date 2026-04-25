<?php

namespace Controller {

    use Model\Clanek;
    use Model\HodnoceniClanku;
    use Model\Uzivatel;
    use Model\Stav;
    use Model\Kategorie;
    use Model\Komentar;
    use Model\Obrazek;

    class UcetController extends Controller
    {

        public function zpracuj(array $params): void
        {
            if (isset($_SESSION['uzivatel_id'])) {
                if (isset($params[0])) {

                    $uzivatel = Uzivatel::ziskatPodleId($params[0]);
                    if (!$uzivatel) {
                        $this->view = "error";
                        return;
                    }
                    $this->data["uzivatel"] = $uzivatel;

                    $clanky = Clanek::ziskatVse();
                    $obrazky = Obrazek::ziskatVse();
                    $kategorie = Kategorie::ziskatVse();
                    $this->data["kategorie"] = $kategorie;
                    $this->data["clanky"] = $clanky;
                    $this->data["obrazky"] = $obrazky;

                    if (isset($_SESSION['uzivatel_id'])) {
                        $existujiciUzivatel = Uzivatel::ziskatPodleId($_SESSION['uzivatel_id']);
                    }
                    $hodnoceniClanku = HodnoceniClanku::ziskatPodleIdUzivatele($params[0]);
                    $this->data["hodnoceniClanku"] = $hodnoceniClanku;


                    if (isset($_POST['zmenaHesla'])) {
                        $heslo = $_POST['heslo'] ?? '';
                        $noveHeslo = $_POST['noveHeslo'] ?? '';
                        $noveHesloZnovu = $_POST['noveHesloZnovu'] ?? '';

                        $chyba = "";
                        $chyba .= Validator::validateHeslo($heslo);
                $chyba .= Validator::validateHeslo($noveHeslo);
                $chyba .= Validator::validateHeslo($noveHesloZnovu);

                        if ($chyba) {
                            $this->data['error'] = $chyba;
                        } else {

                            if ($existujiciUzivatel->overitHeslo($heslo)) {

                                if ($noveHeslo == $noveHesloZnovu) {

                                    if ($existujiciUzivatel->insUpdUzivatel(null, $noveHeslo)) {
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

                        $chyba = "";
                        $chyba .= Validator::notEmpty($noveJmeno);
                        $chyba .= Validator::noSpecialChars($noveJmeno, "Jmeno");
                        $chyba .= Validator::lengthBetween($noveJmeno, 0, 255, "Jmeno");

                        if ($chyba) {
                            $this->data['error'] = $chyba;
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

                        $chyba = "";
                        $chyba .= Validator::notEmpty($novyPopis);
                        $chyba .= Validator::noSpecialChars($novyPopis, "Popis");
                        $chyba .= Validator::lengthBetween($novyPopis, 0, 600, "Popis");

                        if ($chyba) {
                            $this->data['errorZmenaEmailu'] = $chyba;
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
                        if (isset($_FILES['novaProfilovka'])) {

                            $file = [
                                'name' => $_FILES['novaProfilovka']['name'],
                                'type' => $_FILES['novaProfilovka']['type'],
                                'tmp_name' => $_FILES['novaProfilovka']["tmp_name"],
                                'error' => $_FILES['novaProfilovka']['error'],
                                'size' => $_FILES['novaProfilovka']['size'],
                            ];
                            $vysledek = $existujiciUzivatel->insUpdUzivatel($file);
                            if (is_string($vysledek)) {
                                $this->data['errorZmenaProfilovky'] = $vysledek;
                            } else {
                                $this->data['successZmenaProfilovky'] = 'Profilový obrázek byl úspěšně změněn.';
                            }
                        } else {
                            $this->data['errorZmenaProfilovky'] = 'Nepodařilo se nahrát soubor. Zkontrolujte formát a velikost souboru.';
                        }
                    }

                    if (isset($_POST['like'])) {
                        $idClanek = $_POST['idClanek'];
                        var_dump($idClanek);
                        $hodnoceniClanku = HodnoceniClanku::ziskatPodleIdClankuUzivatele($idClanek, $_SESSION["uzivatel_id"]);
                        if ($hodnoceniClanku) {
                            if ($hodnoceniClanku->hodnoceni == 1) {
                                $hodnoceniClanku->hodnoceni = 0;
                            } else {
                                $hodnoceniClanku->hodnoceni = 1;
                            }
                        } else {
                            $hodnoceniClanku = new HodnoceniClanku();
                            $hodnoceniClanku->vytvorHodnoceniClanku(1, $idClanek, $_SESSION["uzivatel_id"]);
                        }
                        $hodnoceniClanku->insUpHodnoceniClanku();

                        $this->presmeruj("/".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    }

                    if (isset($params[1])) {

                        switch ($params[1]) {
                            case 'clanky':
                                $clankyUzivatele = Clanek::ziskatVsePodleAutora($params[0]);
                                $this->data["clankyUzivatele"] = $clankyUzivatele;
                                $this->view = "ucetClanky";
                                break;

                            case 'komentare':
                                $komentare = Komentar::ziskatPodleIdUzivatele($params[0]);
                                $this->data["komentare"] = $komentare;

                                $this->view = "ucetKomentare";
                                break;

                            case 'oblibene':

                                $this->view = "ucetOblibene";
                                break;

                            case 'nastaveni':
                                $this->view = "ucetNastaveni";
                                break;

                            default:
                                $this->view = "ucetClanky";
                                break;
                        }
                    } else {
                        $this->presmeruj('ucet/' . $uzivatel->id . '/clanky');
                    }
                } else {
                    $this->presmeruj('ucet/' . $_SESSION['uzivatel_id']);
                }
            } else {
                $this->presmeruj('login');
            }
        }
    }
}
