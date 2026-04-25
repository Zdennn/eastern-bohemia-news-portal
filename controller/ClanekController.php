<?php

namespace Controller {

    use Model\Clanek;
    use Model\Kategorie;
    use Model\Tag;
    use Model\ClankyTagy;
    use Model\Uzivatel;
    use Model\Obrazek;
    use Model\Komentar;
    use Model\HodnoceniClanku;
    use Model\HodnoceniKomentare;

    class ClanekController extends Controller
    {
        public function zpracuj(array $params): void {

            require_once 'Validator.php';

            if (isset($params[0])) {
                $clanek = Clanek::ziskatPodleId($params[0]);
                if (!$clanek) {
                    $this->view = "error";
                    return;
                }
                $kategorie = Kategorie::ziskatPodleId($clanek->idKategorie);
                $ClankyTagy = ClankyTagy::ziskatPodleClanku($clanek->id);
                $autor = Uzivatel::ziskatPodleId($clanek->idAutor);
                $obrazky = Obrazek::ziskatPodleIdClanku($clanek->id);
                $tagy = Tag::ziskatVse();
                $komentare = Komentar::ziskatPodleIdClanku($clanek->id);
                $uzivatele = Uzivatel::ziskatVse();

                $pocetLiku = HodnoceniClanku::ziskatPocetPodleIdClanku($clanek->id);
                $this->data["pocetLiku"] = count($pocetLiku);

                if (isset($_SESSION["uzivatel_id"])) {
                    $hodnoceniClanku = HodnoceniClanku::ziskatPodleIdClankuUzivatele($clanek->id, $_SESSION["uzivatel_id"]);
                    $this->data["hodnoceniClanku"] = $hodnoceniClanku;

                    $hodnoceniKomentare = HodnoceniKomentare::ziskatPodleIdClankuUzivatele($clanek->id, $_SESSION["uzivatel_id"]);
                    $this->data["hodnoceniKomentare"] = $hodnoceniKomentare;

                    $prihlasenyUzivatel = Uzivatel::ziskatPodleId($_SESSION["uzivatel_id"]);
                    $this->data["prihlasenyUzivatel"] = $prihlasenyUzivatel;
                }

                $this->data["clanek"] = $clanek;
                $this->data["kategorie"] = $kategorie;
                $this->data["ClankyTagy"] = $ClankyTagy;
                $this->data["autor"] = $autor;
                $this->data["obrazky"] = $obrazky;
                $this->data["tagy"] = $tagy;
                $this->data["komentare"] = $komentare;
                $this->data["uzivatele"] = $uzivatele;

                Clanek::noveZhlednuti($clanek->id);

                if (isset($_POST['like'])) {
                    $hodnoceniClanku = HodnoceniClanku::ziskatPodleIdClankuUzivatele($clanek->id, $_SESSION["uzivatel_id"]);
                    if ($hodnoceniClanku) {
                        if ($hodnoceniClanku->hodnoceni == 1) {
                            $hodnoceniClanku->hodnoceni = 0;
                        }else{
                            $hodnoceniClanku->hodnoceni = 1;
                        }
                        
                    }else{
                        $hodnoceniClanku = new HodnoceniClanku();
                        $hodnoceniClanku->vytvorHodnoceniClanku(1, $clanek->id, $_SESSION["uzivatel_id"]);
                    }
                    $hodnoceniClanku->insUpHodnoceniClanku();

                    $this->presmeruj("/".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                }

                if (isset($_POST['novyKomentar'])) {
                    $obsah = $_POST["obsah"];

                    $chyba = "";
                    $chyba .= Validator::notEmpty($obsah, 'Komentář');
                    $chyba .= Validator::noSpecialChars($obsah, 'Komentář');
                    $chyba .= Validator::lengthBetween($obsah, 1, 1200, 'Komentář');
                    
                    if ($chyba) {
                        $this->data['message'] = $chyba;
                    } else {
                        $komentar = new Komentar();
                        $komentar->vytvorKomentar($obsah, $clanek->id, $_SESSION["uzivatel_id"], null);
                
                        if ($komentar->insUpdKomentar()) {
                            $this->presmeruj("/".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                        } else {
                            $this->data['message'] = 'Chyba při přidávání komentáře.';
                        }
                    }
                }

                if (isset($_POST['novaOdpoved'])) {
                    $obsah = $_POST["obsah"];
                    $idNadKomentar = $_POST["idNadKomentar"];
                    
                    $chyba = "";
                    $chyba .= Validator::notEmpty($obsah, 'Odpověď');
                    $chyba .= Validator::noSpecialChars($obsah, 'Odpověď');
                    $chyba .= Validator::lengthBetween($obsah, 1, 1200, 'Odpověď');
                    
                    if ($chyba) {
                        $this->data['message'] = $chyba;
                    } else {
                        $komentar = new Komentar();
                        $komentar->vytvorKomentar($obsah, $clanek->id, $_SESSION["uzivatel_id"], $idNadKomentar);
                
                        if ($komentar->insUpdKomentar()) {
                            $this->presmeruj("/".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                        } else {
                            $this->data['message'] = 'Chyba při přidávání odpovědi.';
                        }
                    }
                }

                if (isset($_POST['likeKomentar'])) {
                    $idKomentar = $_POST["idKomentar"];
                    $hodnoceniKomentare = HodnoceniKomentare::ziskatPodleIdKomentareUzivatele($idKomentar, $_SESSION["uzivatel_id"]);
                    if ($hodnoceniKomentare) {

                        if ($hodnoceniKomentare->hodnoceni == 1) {
                            $hodnoceniKomentare->hodnoceni = 0;
                        }else{
                            $hodnoceniKomentare->hodnoceni = 1;
                        }
                        
                    }else{
                        $hodnoceniKomentare = new HodnoceniKomentare();
                        $hodnoceniKomentare->vytvorHodnoceniKomentare(1, $idKomentar, $_SESSION["uzivatel_id"]);
                    }
                    $hodnoceniKomentare->insUpHodnoceniKomentare();

                    $this->presmeruj("/".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                }

                if (isset($params[1] ) && $params[1] == "komentare") {
                    $uzivatele = Uzivatel::ziskatVse();
                    $this->data["uzivatele"] = $uzivatele;

                    $this->view = "clanekKomentare";
                }else{
                    $this->view = "clanek";
                }
            }
        }
    }
}
