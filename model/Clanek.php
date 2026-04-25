<?php

namespace Model {

    class Clanek
    {
        private ?int $id = 0;
        private ?string $nadpis = "";
        private ?string $upoutavka;
        private ?string $uryvek;
        private ?string $obsah;
        private \DateTime|string $createdAt;
        private \DateTime|string $updatedAt;
        private ?int $zhlednuti;
        private ?int $idAutor;
        private ?int $idKategorie;
        private ?int $idStav;

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
            if (in_array($name, ["id"])) {
                throw new \Exception("Vlastnost {$name} je pouze pro čtení.");
            }
            $this->$name = $value;
        }

        public function vytvorClanek(
            string $nadpis,
            string $upoutavka,
            string $uryvek,
            string $obsah,
            ?int $idAutor,
            ?int $idKategorie
        ): void {
            $this->id = 0;
            $this->nadpis = $nadpis;
            $this->upoutavka = $upoutavka;
            $this->uryvek = $uryvek;
            $this->obsah = $obsah;
            $this->zhlednuti = 0;
            $this->idAutor = $idAutor;
            $this->idKategorie = $idKategorie;
            $this->idStav = 1;
        }

        public function __construct()
        {
            if (isset($this->createdAt) && isset($this->updatedAt)) {
                if (is_string($this->createdAt)) {
                    $this->createdAt = new \DateTime($this->createdAt);
                }
                if (is_string($this->updatedAt)) {
                    $this->updatedAt = new \DateTime($this->updatedAt);
                }
            }
        }

        public function insUpdClanek(): ?bool
        {
            $params = [
                new DbParam(":nadpis", $this->nadpis),
                new DbParam(":upoutavka", $this->upoutavka),
                new DbParam(":uryvek", $this->uryvek),
                new DbParam(":obsah", $this->obsah),
                new DbParam(":zhlednuti", $this->zhlednuti, \PDO::PARAM_INT),
                new DbParam(":idAutor", $this->idAutor, \PDO::PARAM_INT),
                new DbParam(":idKategorie", $this->idKategorie, \PDO::PARAM_INT),
                new DbParam(":idStav", $this->idStav, \PDO::PARAM_INT)
            ];

            $sql = "";
            if ($this->id > 0) {
                $sql = "UPDATE clanky SET nadpis = :nadpis, upoutavka = :upoutavka, uryvek = :uryvek, obsah = :obsah, 
                         zhlednuti = :zhlednuti, Uzivatele_idUzivatele = :idAutor, 
                        Kategorie_idKategorie = :idKategorie, Stav_idStav = :idStav
                        WHERE idClanky = :id";
                $params[] = new DbParam(":id", $this->id, \PDO::PARAM_INT);
            } else {
                $sql = "INSERT INTO clanky (nadpis, upoutavka, uryvek, obsah, zhlednuti, 
                        Uzivatele_idUzivatele, Kategorie_idKategorie, Stav_idStav) 
                        VALUES (:nadpis, :upoutavka, :uryvek, :obsah, :zhlednuti, :idAutor, 
                        :idKategorie, :idStav)";
            }
            $db = new Db();

            if ($db->exec($sql, $params)) {
                $this->id = $db->lastInsertId();
                return true;
            }

            return false;
        }
        public static function ziskatVse(): ?array
        {
            return (new Db())->fetchAll(
                "SELECT idClanky AS id, nadpis AS nadpis, upoutavka AS upoutavka, uryvek AS uryvek, obsah AS obsah, created_at AS createdAt, 
                updated_at AS updatedAt, zhlednuti AS zhlednuti, Uzivatele_idUzivatele AS idAutor, 
                Kategorie_idKategorie AS idKategorie, Stav_idStav AS idStav FROM clanky ORDER BY created_at DESC",
                Clanek::class
            );
        }
        public static function ziskatVsePublikovane(): ?array
        {
            return (new Db())->fetchAll(
                "SELECT idClanky AS id, nadpis AS nadpis, upoutavka AS upoutavka, uryvek AS uryvek, obsah AS obsah, created_at AS createdAt, 
                updated_at AS updatedAt, zhlednuti AS zhlednuti, Uzivatele_idUzivatele AS idAutor, 
                Kategorie_idKategorie AS idKategorie, Stav_idStav AS idStav FROM clanky ORDER BY created_at WHERE Stav_idStav = 4",
                Clanek::class
            );
        }

        public static function ziskatVsePodleAutora(int $idAutora): ?array
        {
            return (new Db())->fetchAll(
                "SELECT idClanky AS id, nadpis AS nadpis, upoutavka AS upoutavka, uryvek AS uryvek, obsah AS obsah, created_at AS createdAt, 
                updated_at AS updatedAt, zhlednuti AS zhlednuti, Uzivatele_idUzivatele AS idAutor, 
                Kategorie_idKategorie AS idKategorie, Stav_idStav AS idStav FROM clanky WHERE Uzivatele_idUzivatele = :idUzivatel && Stav_idStav = 4 ORDER BY created_at DESC",
                Clanek::class,
                [new DbParam(":idUzivatel", $idAutora, \PDO::PARAM_INT)]
            );
        }
        public static function ziskatNumFilter(int $pocet = 1, $filter = null, $filterValue = null): ?array
        {
            $params = [];
            $where = "WHERE Stav_idStav = 4";

            if ($filter !== null && $filterValue !== null) {
                $where .= " AND $filter = :filterValue";
                $params[] = new DbParam(":filterValue", $filterValue);
            }

            $sql = "SELECT idClanky AS id, nadpis AS nadpis, upoutavka AS upoutavka, uryvek AS uryvek, obsah AS obsah, created_at AS createdAt, 
            updated_at AS updatedAt, zhlednuti AS zhlednuti, Uzivatele_idUzivatele AS idAutor, 
            Kategorie_idKategorie AS idKategorie, Stav_idStav AS idStav 
            FROM clanky $where ORDER BY created_at DESC LIMIT :pocet";

            $params[] = new DbParam(":pocet", $pocet, \PDO::PARAM_INT);

            return (new Db())->fetchAll($sql, Clanek::class, $params);
        }

        public static function ziskatPodleId($id): ?Clanek
        {
            return (new Db())->fetch(
                "SELECT idClanky AS id, nadpis AS nadpis, upoutavka AS upoutavka, uryvek AS uryvek, obsah AS obsah, created_at AS createdAt, 
                updated_at AS updatedAt, zhlednuti AS zhlednuti, Uzivatele_idUzivatele AS idAutor, 
                Kategorie_idKategorie AS idKategorie, Stav_idStav AS idStav FROM clanky WHERE idClanky = :id",
                Clanek::class,
                [
                    new DbParam(":id", $id, \PDO::PARAM_INT)
                ]
            );
        }
        public static function ziskatPodleIdKategorie($id): ?array
        {
            return (new Db())->fetchAll(
                "SELECT idClanky AS id, nadpis AS nadpis, upoutavka AS upoutavka, uryvek AS uryvek, obsah AS obsah, created_at AS createdAt, 
                updated_at AS updatedAt, zhlednuti AS zhlednuti, Uzivatele_idUzivatele AS idAutor, 
                Kategorie_idKategorie AS idKategorie, Stav_idStav AS idStav FROM clanky WHERE Kategorie_idKategorie = :id",
                Clanek::class,
                [
                    new DbParam(":id", $id, \PDO::PARAM_INT)
                ]
            );
        }

        public static function ziskatFiltr($nazev = null, $idKategorie = null, ?array $idTagy = null): ?array
        {
            $params = [];
            $where = "WHERE Stav_idStav = 4";

            if ($nazev != null && $nazev != "") {
                $where .= " AND nadpis LIKE :nazev";
                $params[] = new DbParam(":nazev", '%' . $nazev . '%', \PDO::PARAM_STR);
            }

            if ($idKategorie != null) {
                $where .= " AND Kategorie_idKategorie = :idKategorie";
                $params[] = new DbParam(":idKategorie", $idKategorie, \PDO::PARAM_INT);
            }

            if ($idTagy !== null && count($idTagy) > 0) {
                $placeholders = [];
                foreach ($idTagy as $index => $tag) {
                    $placeholder = ":tag" . $index;
                    $placeholders[] = $placeholder;
                    $params[] = new DbParam($placeholder, $tag, \PDO::PARAM_INT);
                }

                $where .= " AND idClanky IN (SELECT Clanky_idClanky FROM clanky_tagy WHERE Tagy_idTagy IN (" . implode(", ", $placeholders) . "))";
            }

            $sql = "SELECT idClanky AS id, nadpis AS nadpis, upoutavka AS upoutavka, uryvek AS uryvek, obsah AS obsah, created_at AS createdAt, 
                    updated_at AS updatedAt, zhlednuti AS zhlednuti, Uzivatele_idUzivatele AS idAutor, 
                    Kategorie_idKategorie AS idKategorie, Stav_idStav AS idStav FROM clanky $where ORDER BY created_at DESC";
            return (new Db())->fetchAll($sql, Clanek::class, $params);
        }

        public static function noveZhlednuti($idClanku)
        {
            return (new Db())->exec(
                "UPDATE clanky SET zhlednuti = zhlednuti + 1 WHERE idClanky = :idClanku",
                [new DbParam(":idClanku", $idClanku, \PDO::PARAM_INT)]
            );
        }
    }
}
