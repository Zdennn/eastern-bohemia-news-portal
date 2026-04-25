<?php

namespace Model;

class HodnoceniKomentare
{
    private int $id = 0;
    private int $hodnoceni;
    private int $idKomentar;
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

    public function vytvorHodnoceniKomentare(
        int $hodnoceni,
        int $idKomentar,
        int $idUzivatel
    ): void {
        $this->id = 0;
        $this->hodnoceni = $hodnoceni;
        $this->idKomentar = $idKomentar;
        $this->idUzivatel = $idUzivatel;
    }

    public function insUpHodnoceniKomentare(): ?bool
    {
        $params = [
            new DbParam(":hodnoceni", $this->hodnoceni, \PDO::PARAM_INT),
            new DbParam(":idKomentar", $this->idKomentar, \PDO::PARAM_INT),
            new DbParam(":idUzivatel", $this->idUzivatel, \PDO::PARAM_INT)
        ];

        $sql = "";
        if ($this->id > 0) {
            $sql = "UPDATE hodnocenikomentare SET hodnoceni = :hodnoceni, Komentare_idKomentare = :idKomentar, Uzivatele_idUzivatele = :idUzivatel WHERE idHodnoceniKomentare = :id";
            $params[] = new DbParam(":id", $this->id, \PDO::PARAM_INT);
        } else {
            $sql = "INSERT INTO hodnocenikomentare (hodnoceni, Komentare_idKomentare, Uzivatele_idUzivatele) VALUES (:hodnoceni, :idKomentar, :idUzivatel)";
        }

        return 1 === (new Db())->exec($sql, $params);
    }

    public static function ziskatVse(): ?array
    {
        return (new Db())->fetchAll(
            "SELECT idHodnoceniKomentare AS id, hodnoceni AS hodnoceni, Komentare_idKomentare AS idKomentar, Uzivatele_idUzivatele AS idUzivatel FROM hodnocenikomentare",
            HodnoceniKomentare::class
        );
    }

    public static function ziskatPodleId($id): ?HodnoceniKomentare
    {
        return (new Db())->fetch(
            "SELECT idHodnoceniKomentare AS id, hodnoceni AS hodnoceni, Komentare_idKomentare AS idKomentar, Uzivatele_idUzivatele AS idUzivatel FROM hodnocenikomentare WHERE idHodnoceniKomentare = :id",
            HodnoceniKomentare::class,
            [
                new DbParam(":id", $id, \PDO::PARAM_INT)
            ]
        );
    }

    public static function ziskatPodleIdKomentare($idKomentar): ?array
    {
        return (new Db())->fetchAll(
            "SELECT idHodnoceniKomentare AS id, hodnoceni AS hodnoceni, Komentare_idKomentare AS idKomentar, Uzivatele_idUzivatele AS idUzivatel FROM hodnocenikomentare WHERE Komentare_idKomentare = :idKomentar",
            HodnoceniKomentare::class,
            [
                new DbParam(":idKomentar", $idKomentar, \PDO::PARAM_INT)
            ]
        );
    }

    public static function ziskatPodleIdUzivatele($idUzivatel): ?array
    {
        return (new Db())->fetchAll(
            "SELECT idHodnoceniKomentare AS id, hodnoceni AS hodnoceni, Komentare_idKomentare AS idKomentar, Uzivatele_idUzivatele AS idUzivatel
            FROM hodnocenikomentare
            WHERE Uzivatele_idUzivatele = :idUzivatel",
            HodnoceniKomentare::class,
            [
                new DbParam(":idUzivatel", $idUzivatel, \PDO::PARAM_INT)
            ]
        );
    }
    public static function ziskatPodleIdKomentareUzivatele($idKomentar, $idUzivatel): ?HodnoceniKomentare
    {
        return (new Db())->fetch(
            "SELECT idHodnoceniKomentare AS id, hodnoceni AS hodnoceni, Komentare_idKomentare AS idKomentar, Uzivatele_idUzivatele AS idUzivatel
            FROM hodnocenikomentare
            WHERE Komentare_idKomentare = :idKomentar AND Uzivatele_idUzivatele = :idUzivatel",
            HodnoceniKomentare::class,
            [
                new DbParam(":idKomentar", $idKomentar, \PDO::PARAM_INT),
                new DbParam(":idUzivatel", $idUzivatel, \PDO::PARAM_INT)
            ]
        );
    }

    public static function ziskatPodleIdClankuUzivatele($idClanku, $idUzivatel): ?array
{
    return (new Db())->fetchAll(
        "SELECT hk.idHodnoceniKomentare AS id, hk.hodnoceni AS hodnoceni, hk.Komentare_idKomentare AS idKomentar, hk.Uzivatele_idUzivatele AS idUzivatel
        FROM hodnocenikomentare hk
        JOIN komentare k ON hk.Komentare_idKomentare = k.idKomentare
        WHERE k.Clanky_idClanky = :idClanku AND hk.Uzivatele_idUzivatele = :idUzivatel",
        HodnoceniKomentare::class,
        [
            new DbParam(":idClanku", $idClanku, \PDO::PARAM_INT),
            new DbParam(":idUzivatel", $idUzivatel, \PDO::PARAM_INT)
        ]
    );
}
}
