<?php

namespace Model {

    class Obrazek
    {
        private ?int $id = 0;
        private ?int $idClanek = null;
        private ?string $nazev = "";
        private ?string $cesta = "";
        private ?string $alt = "";

        public function __get($name)
        {
            if (!array_key_exists($name, get_object_vars($this)))
                throw new \Exception("Vlastnost {$name} neexistuje.");

            return $this->$name;
        }
        public function __set($name, $value)
        {
            if (!array_key_exists($name, get_object_vars($this))) {
                throw new \Exception("Vlastnost {$name} neexistuje.");
            }
            if (in_array($name, ["id", "idClanek"])) {
                throw new \Exception("Vlastnost {$name} je pouze pro čtení.");
            }
            $this->$name = $value;
        }

        public function vytvorObrazek(string $nazev, string $cesta, string $alt, ?int $idClanek): void
        {
            $this->id = 0;
            $this->nazev = $nazev;
            $this->cesta = $cesta;
            $this->alt = $alt;
            $this->idClanek = $idClanek;
        }

        public function insUpdObrazek($file, int $idClanek): string|bool
        {
            if (!isset($file['error']) || is_array($file['error'])) {
                return 'Neplatné parametery.';
            }

            switch ($file['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    return 'Neposlán žádný soubor.';
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    return 'Přesažena maximální velikost souboru.';
                default:
                    return 'Neznámý error.';
            }

            if ($file['size'] > 10000000) {
                return 'Přesažena maximální velikost souboru.';
            }

            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $ext = array_search(
                $finfo->file($file['tmp_name']),
                [
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                    'webp' => 'image/webp'
                ],
                true
            );

            if ($ext === false) {
                return 'Neplatný formát souboru.';
            }

            $nazevSouboru = sprintf('%s.%s', sha1_file($file['tmp_name']), $ext);
            $cesta = 'assets/img/' . $nazevSouboru;

            if (!move_uploaded_file($file['tmp_name'], $cesta)) {
                return 'Selhalo nahrávání obrázku.';
            }

            $this->nazev = $file['name'];
            $this->cesta = "/" . $cesta;
            $this->alt = pathinfo($file['name'], PATHINFO_FILENAME);
            $this->idClanek = $idClanek;

            $params = [
                new DbParam(":nazev", $this->nazev),
                new DbParam(":cesta", $this->cesta),
                new DbParam(":alt", $this->alt),
                new DbParam(":idClanek", $this->idClanek, \PDO::PARAM_INT),
            ];

            $sql = "";
            if ($this->id > 0) {
                $sql = "UPDATE obrazky SET nazev = :nazev, cesta = :cesta, alt = :alt, Clanky_idClanky = :idClanek WHERE idObrazky = :id";
                $params[] = new DbParam(":id", $this->id, \PDO::PARAM_INT);
            } else {
                $sql = "INSERT INTO obrazky (nazev, cesta, alt, Clanky_idClanky) VALUES (:nazev, :cesta, :alt, :idClanek)";
            }

            if (1 === (new Db())->exec($sql, $params)) {
                return true;
            }

            return 'Selhalo nahrávání obrázku.';
        }

        public static function ziskatVse(): ?array
        {
            return (new Db())->fetchAll(
                "SELECT idObrazky AS id, nazev AS nazev, cesta AS cesta, alt AS alt, Clanky_idClanky AS idClanek 
                 FROM obrazky ORDER BY idObrazky",
                Obrazek::class
            );
        }

        public static function ziskatPodleId($id): ?Obrazek
        {
            return (new Db())->fetch(
                "SELECT idObrazky AS id, nazev AS nazev, cesta AS cesta, alt AS alt, Clanky_idClanky AS idClanek 
                 FROM obrazky WHERE idObrazky = :id",
                Obrazek::class,
                [
                    new DbParam(":id", $id, \PDO::PARAM_INT)
                ]
            );
        }

        public static function ziskatPodleIdClanku(int $idClanek): ?array
        {
            return (new Db())->fetchAll(
                "SELECT idObrazky AS id, nazev AS nazev, cesta AS cesta, alt AS alt, Clanky_idClanky AS idClanek 
                 FROM obrazky WHERE Clanky_idClanky = :idClanek",
                Obrazek::class,
                [
                    new DbParam(":idClanek", $idClanek, \PDO::PARAM_INT)
                ]
            );
        }
        public static function smazatPodleId(int $idClanek): ?bool
        {
            return (new Db())->exec(
                "DELETE FROM obrazky WHERE idObrazky = :id",
                [
                    new DbParam(":id", $idClanek, \PDO::PARAM_INT)
                ]
            ) === 1;
        }
    }
}
