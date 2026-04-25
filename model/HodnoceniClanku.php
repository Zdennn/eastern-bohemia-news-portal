<?php

namespace Model;

class HodnoceniClanku
{
    private int $id = 0;
    private int $hodnoceni;
    private int $idClanek;
    private int $idUzivatel;

    public function __get($name)
    {
        if (!array_key_exists($name, get_object_vars($this))) {
            throw new \Exception("Vlastnost {$name} neexistuje.");
        }
        return $this->$name;
    }

    public function __set($name, $value)
    {
        if (!array_key_exists($name, get_object_vars($this))) {
            throw new \Exception("Vlastnost {$name} neexistuje.");
        }
        if ($name === "id") {
            throw new \Exception("Vlastnost {$name} je pouze pro čtení.");
        }
        $this->$name = $value;
    }

    public function vytvorHodnoceniClanku(
        int $hodnoceni,
        int $idClanek,
        int $idUzivatel
    ): void {
        $this->id = 0;
        $this->hodnoceni = $hodnoceni;
        $this->idClanek = $idClanek;
        $this->idUzivatel = $idUzivatel;
    }

    public function insUpHodnoceniClanku(): ?bool
    {
        $params = [
            new DbParam(":hodnoceni", $this->hodnoceni, \PDO::PARAM_INT),
            new DbParam(":idClanek", $this->idClanek, \PDO::PARAM_INT),
            new DbParam(":idUzivatel", $this->idUzivatel, \PDO::PARAM_INT)
        ];

        $sql = "";
        if ($this->id > 0) {
            $sql = "UPDATE hodnoceniclanku SET hodnoceni = :hodnoceni, Clanky_idClanky = :idClanek, Uzivatele_idUzivatele = :idUzivatel WHERE idHodnoceniClanku = :id";
            $params[] = new DbParam(":id", $this->id, \PDO::PARAM_INT);
        } else {
            $sql = "INSERT INTO hodnoceniclanku (hodnoceni, Clanky_idClanky, Uzivatele_idUzivatele) VALUES (:hodnoceni, :idClanek, :idUzivatel)";
        }

        return 1 === (new Db())->exec($sql, $params);
    }

    public static function ziskatVse(): ?array
    {
        return (new Db())->fetchAll(
            "SELECT idHodnoceniClanku AS id, hodnoceni AS hodnoceni, Clanky_idClanky AS idClanek, Uzivatele_idUzivatele AS idUzivatel FROM hodnoceniclanku",
            HodnoceniClanku::class
        );
    }

    public static function ziskatPodleId($id): ?HodnoceniClanku
    {
        return (new Db())->fetch(
            "SELECT idHodnoceniClanku AS id, hodnoceni AS hodnoceni, Clanky_idClanky AS idClanek, Uzivatele_idUzivatele AS idUzivatel FROM hodnoceniclanku WHERE idHodnoceniClanku = :id",
            HodnoceniClanku::class,
            [
                new DbParam(":id", $id, \PDO::PARAM_INT)
            ]
        );
    }

    public static function ziskatPodleIdClanku($idClanku): ?array
    {
        return (new Db())->fetchAll(
            "SELECT idHodnoceniClanku AS id, hodnoceni AS hodnoceni, Clanky_idClanky AS idClanek, Uzivatele_idUzivatele AS idUzivatel FROM hodnoceniclanku WHERE Clanky_idClanky = :idClanku",
            HodnoceniClanku::class,
            [
                new DbParam(":idClanku", $idClanku, \PDO::PARAM_INT)
            ]
        );
    }
    public static function ziskatPocetPodleIdClanku($idClanku): ?array
    {
        return (new Db())->fetchAll(
            "SELECT idHodnoceniClanku AS id, hodnoceni AS hodnoceni, Clanky_idClanky AS idClanek, Uzivatele_idUzivatele AS idUzivatel FROM hodnoceniclanku WHERE Clanky_idClanky = :idClanku && hodnoceni = 1",
            HodnoceniClanku::class,
            [
                new DbParam(":idClanku", $idClanku, \PDO::PARAM_INT)
            ]
        );
    }
    public static function ziskatPodleIdUzivatele($idUzivatele): ?array
    {
        return (new Db())->fetchAll(
            "SELECT idHodnoceniClanku AS id, hodnoceni AS hodnoceni, Clanky_idClanky AS idClanek, Uzivatele_idUzivatele AS idUzivatel
        FROM hodnoceniclanku
        WHERE Uzivatele_idUzivatele = :idUzivatele ORDER BY idHodnoceniClanku DESC",
            HodnoceniClanku::class,
            [
                new DbParam(":idUzivatele", $idUzivatele, \PDO::PARAM_INT)
            ]
        );
    }
    public static function ziskatPodleIdClankuUzivatele($idClanku, $idUzivatele): ?HodnoceniClanku
    {
        return (new Db())->fetch(
            "SELECT idHodnoceniClanku AS id, hodnoceni AS hodnoceni, Clanky_idClanky AS idClanek, Uzivatele_idUzivatele AS idUzivatel
        FROM hodnoceniclanku
        WHERE Clanky_idClanky = :idClanku AND Uzivatele_idUzivatele = :idUzivatele",
            HodnoceniClanku::class,
            [
                new DbParam(":idClanku", $idClanku, \PDO::PARAM_INT),
                new DbParam(":idUzivatele", $idUzivatele, \PDO::PARAM_INT)
            ]
        );
    }
}
