<?php

namespace Controller {

    use Model\Clanek;
    use Model\Kategorie;
    use Model\Obrazek;

    class IndexController extends Controller
    {
        public function zpracuj(array $params): void
        {
            $kategorie = Kategorie::ziskatVse();
            $this->data['kategorie'] = $kategorie;
            $obrazky = Obrazek::ziskatVse();
            $this->data['obrazky'] = $obrazky;

            $clanky = Clanek::ziskatNumFilter(15);
            $this->data['nejClanky'] = $clanky;

            $clankyKultura = Clanek::ziskatNumFilter(8, "Kategorie_idKategorie", 1);
            $this->data['clankyKultura'] = $clankyKultura;
            $clankySport = Clanek::ziskatNumFilter(8, "Kategorie_idKategorie", 4);
            $this->data['clankySport'] = $clankySport;
            $clankyEkonomika = Clanek::ziskatNumFilter(8, "Kategorie_idKategorie", 2);
            $this->data['clankyEkonomika'] = $clankyEkonomika;
            $clankyUdalosti = Clanek::ziskatNumFilter(8, "Kategorie_idKategorie", 3);
            $this->data['clankyUdalosti'] = $clankyUdalosti;

            $this->view = "index";
        }
    }
}
