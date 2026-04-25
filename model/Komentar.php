<?php

namespace Model;

class Komentar
{
    private int $id = 0;
    private string $obsah;
    private \DateTime|string $createdAt;
    private \DateTime|string $updatedAt;
    private bool $stav;
    private int $idClanek;
    private int $idUzivatel;
    private ?int $idNadKomentar = null;

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

    public function vytvorKomentar(
        string $obsah,
        int $idClanek,
        int $idUzivatel,
        ?int $idNadKomentar
    ) {
        $this->id = 0;
        $this->obsah = $obsah;
        $this->stav = true;
        $this->idClanek = $idClanek;
        $this->idUzivatel = $idUzivatel;
        $this->idNadKomentar = $idNadKomentar;
    }

    public function insUpdKomentar(): ?bool
    {
        $params = [
            new DbParam(":obsah", $this->obsah),
            new DbParam(":stav", $this->stav, \PDO::PARAM_INT),
            new DbParam(":idClanek", $this->idClanek, \PDO::PARAM_INT),
            new DbParam(":idUzivatel", $this->idUzivatel, \PDO::PARAM_INT),
            new DbParam(":idNadKomentar", $this->idNadKomentar, \PDO::PARAM_INT)
        ];

        $sql = "";
        if ($this->id > 0) {
            $sql = "UPDATE komentare 
                    SET obsah = :obsah, stav = :stav, Clanky_idClanky = :idClanek, 
                        Uzivatele_idUzivatele = :idUzivatel, idNadKomentar = :idNadKomentar 
                    WHERE idKomentare = :id";
            $params[] = new DbParam(":id", $this->id, \PDO::PARAM_INT);
        } else {
            $sql = "INSERT INTO komentare (obsah, stav, Clanky_idClanky, Uzivatele_idUzivatele, idNadKomentar) 
                    VALUES (:obsah, :stav, :idClanek, :idUzivatel, :idNadKomentar)";
        }

        return 1 === (new Db())->exec($sql, $params);
    }

    public static function ziskatVse(): ?array
    {
        return (new Db())->fetchAll(
            "SELECT idKomentare AS id, obsah AS obsah, created_at AS createdAt, updated_at AS updatedAt,
            stav AS stav, Clanky_idClanky AS idClanek, Uzivatele_idUzivatele AS idUzivatel,
            idNadKomentar AS idNadKomentar FROM komentare order by created_at DESC",
            Komentar::class
        );
    }

    public static function ziskatPodleId($id): ?Komentar
    {
        return (new Db())->fetch(
            "SELECT idKomentare AS id, obsah AS obsah, created_at AS createdAt, updated_at AS updatedAt,
            stav AS stav, Clanky_idClanky AS idClanek, Uzivatele_idUzivatele AS idUzivatel,
            idNadKomentar AS idNadKomentar FROM komentare WHERE idKomentare = :id",
            Komentar::class,
            [
                new DbParam(":id", $id, \PDO::PARAM_INT)
            ]
        );
    }

    public static function ziskatPodleIdUzivatele($idUzivatele): ?array
    {
        return (new Db())->fetchAll(
            "SELECT idKomentare AS id, obsah AS obsah, created_at AS createdAt, updated_at AS updatedAt,
            stav AS stav, Clanky_idClanky AS idClanek, Uzivatele_idUzivatele AS idUzivatel,
            idNadKomentar AS idNadKomentar FROM komentare WHERE Uzivatele_idUzivatele = :idUzivatele order by created_at DESC",
            Komentar::class,
            [
                new DbParam(":idUzivatele", $idUzivatele, \PDO::PARAM_INT)
            ]
        );
    }
    public static function ziskatPodleIdClanku($idClanku): ?array
    {
        return (new Db())->fetchAll(
            "SELECT idKomentare AS id, obsah AS obsah, created_at AS createdAt, updated_at AS updatedAt,
            stav AS stav, Clanky_idClanky AS idClanek, Uzivatele_idUzivatele AS idUzivatel,
            idNadKomentar AS idNadKomentar FROM komentare WHERE Clanky_idClanky = :idClanku AND stav = 1 order by created_at DESC",
            Komentar::class,
            [
                new DbParam(":idClanku", $idClanku, \PDO::PARAM_INT)
            ]
        );
    }
}
