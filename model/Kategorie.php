<?php

namespace Model;

class Kategorie
{
    private int $id = 0;
    private string $nazev;

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

    public function vytvorKategorii(
        string $nazev
    ): void {
        $this->id = 0;
        $this->nazev = $nazev;
    }

    public function insUpdKategorie(): ?bool
    {
        $params = [
            new DbParam(":nazev", $this->nazev),
        ];

        $sql = "";
        if ($this->id > 0) {
            $sql = "UPDATE kategorie SET nazev = :nazev WHERE idKategorie = :id";
            $params[] = new DbParam(":id", $this->id, \PDO::PARAM_INT);
        } else {
            $sql = "INSERT INTO kategorie (nazev) VALUES (:nazev)";
        }

        return 1 === (new Db())->exec($sql, $params);
    }

    public static function ziskatVse(): array
    {
        return (new Db())->fetchAll(
            "SELECT idKategorie AS id, nazev AS nazev FROM kategorie",
            Kategorie::class
        );
    }

    public static function ziskatNumFilter(int $pocet = 1, $filter = null, $filterValue = null): ?array
    {
        $params = [];
        $where = "";
        if ($filter !== null && $filterValue !== null) {
            $where = "WHERE $filter = :filterValue";
            $params[] = new DbParam(":filterValue", $filterValue);
        }

        $sql = "SELECT idKategorie AS id, nazev AS nazev FROM kategorie $where ORDER BY idKategorie LIMIT :pocet";
        $params[] = new DbParam(":pocet", $pocet, \PDO::PARAM_INT);

        return (new Db())->fetchAll($sql, Kategorie::class, $params);
    }

    public static function ziskatPodleId($id): ?Kategorie
    {
        return (new Db())->fetch(
            "SELECT idKategorie AS id, nazev AS nazev FROM kategorie WHERE idKategorie = :id",
            Kategorie::class,
            [
                new DbParam(":id", $id, \PDO::PARAM_INT),
            ]
        );
    }
}
