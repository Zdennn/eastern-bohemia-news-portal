<?php

namespace Controller {

    use Model\Kategorie;
    use Model\Clanek;
    use Model\Tag;
    use Model\Obrazek;

    class FiltrController extends Controller
    {
        public function zpracuj(array $params): void
        {
            $clanky = null;
            if (isset($params[0]) && isset($params[1])) {
                if (str_contains($params[0], "kategorie")) {
                    if (Validator::noSpecialChars($params[1]) == null) {
                        $clanky = Clanek::ziskatFiltr(null, $params[1], null);
                        $this->data["kategorieUrl"] = $params[1];
                    } else {
                        $clanky = null;
                    }
                } else if (str_contains($params[0], "tag")) {
                    if (Validator::noSpecialChars($params[1]) == null) {
                        $tagy[] = $params[1];
                        $clanky = Clanek::ziskatFiltr(null, null, $tagy);
                        $tag = Tag::ziskatPodleId($params[1]);
                        if ($tag != null) {
                            $tagyy[] = $tag->nazev;
                        } else {
                            $tagyy = null;
                        }
                        $this->data["tagUrl"] = json_encode($tagyy);
                    }
                }
            } else {
                $clanky = Clanek::ziskatFiltr(null, null, null);
            }
            $kategorie = Kategorie::ziskatVse();
            $this->data["kategorie"] = $kategorie;
            $obrazky = Obrazek::ziskatVse();
            $this->data["obrazky"] = $obrazky;

            $idTagy = array();
            if (isset($_POST["vyhledat"]) && $_POST["vyhledat"] != 0) {
                if (isset($_POST["idKategorie"]) && $_POST["idKategorie"] != 0) {
                    $idKategorie = $_POST["idKategorie"];
                    if (Validator::noSpecialChars($idKategorie) != null) {
                        $idKategorie = null;
                    }
                } else {
                    $idKategorie = null;
                }
                if (isset($_POST["tagy"])) {
                    $tagy = JSON_decode($_POST["tagy"]);
                    foreach ($tagy as $tag) {
                        if (Validator::noSpecialChars($tag) == null) {
                            $vysledek = Tag::ziskatPodleNazvu($tag);
                            if ($vysledek != null) {
                                $idTagy[] = $vysledek->id;
                            }
                        }
                    }
                } else {
                    $tagy = null;
                }
                if (isset($_POST["nazev"])) {
                    if(Validator::noSpecialChars($_POST["nazev"]) == null){
                        $nazev = $_POST["nazev"];
                    }else{
                        $nazev = null;
                    }
                } else {
                    $nazev = null;
                }

                $clanky = Clanek::ziskatFiltr($nazev, $idKategorie, $idTagy);
            }

            $this->data["clanky"] = $clanky;
            $this->view = "filtr";
        }
    }
}
