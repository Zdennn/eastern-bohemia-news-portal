<?php

namespace Model;

class ClankyTagy
{
    private int $idClanek;
    private int $idTagu;

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
        throw new \Exception("Vlastnost {$name} je pouze pro čtení.");
    }

    public function vytvorClankyTagy(int $idClanek, int $idTagu): void
    {
        $this->idClanek = $idClanek;
        $this->idTagu = $idTagu;
    }

    public function insClankyTagy(): ?bool
    {
        $params = [
            new DbParam(":Clanky_idClanky", $this->idClanek, \PDO::PARAM_INT),
            new DbParam(":Tagy_idTagy", $this->idTagu, \PDO::PARAM_INT),
        ];

        $sql = "INSERT INTO clanky_tagy (Clanky_idClanky, Tagy_idTagy) VALUES (:Clanky_idClanky, :Tagy_idTagy)";

        return 1 === (new Db())->exec($sql, $params);
    }

    public static function ziskatPodleClanku(int $idClanek): ?array
    {
        return (new Db())->fetchAll(
            "SELECT Clanky_idClanky AS idClanek, Tagy_idTagy AS idTagu 
             FROM clanky_tagy 
             WHERE Clanky_idClanky = :Clanky_idClanky",
            ClankyTagy::class,
            [new DbParam(":Clanky_idClanky", $idClanek, \PDO::PARAM_INT)]
        );
    }

    public static function ziskatPodleTagu(int $idTagu): ?array
    {
        return (new Db())->fetchAll(
            "SELECT Clanky_idClanky AS idClanek, Tagy_idTagy AS idTagu 
             FROM clanky_tagy 
             WHERE Tagy_idTagy = :Tagy_idTagy",
            ClankyTagy::class,
            [new DbParam(":Tagy_idTagy", $idTagu, \PDO::PARAM_INT)]
        );
    }

    public static function smazatSpojeni(int $idClanek, int $idTagu): ?bool
    {
        $params = [
            new DbParam(":Clanky_idClanky", $idClanek, \PDO::PARAM_INT),
            new DbParam(":Tagy_idTagy", $idTagu, \PDO::PARAM_INT),
        ];

        $sql = "DELETE FROM clanky_tagy WHERE Clanky_idClanky = :Clanky_idClanky AND Tagy_idTagy = :Tagy_idTagy";

        return 1 === (new Db())->exec($sql, $params);
    }
    public static function smazatPodleClanku(int $idClanek): ?bool
    {
        $params = [
            new DbParam(":Clanky_idClanky", $idClanek, \PDO::PARAM_INT)
        ];

        $sql = "DELETE FROM clanky_tagy WHERE Clanky_idClanky = :Clanky_idClanky";

        return 1 === (new Db())->exec($sql, $params);
    }

}
