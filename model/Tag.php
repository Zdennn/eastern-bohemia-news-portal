<?php

namespace Model;

class Tag
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

    public function vytvorTag(string $nazev): void
    {
        $this->id = 0;
        $this->nazev = $nazev;
    }

    public function insUpdTag(): ?bool
    {
        $params = [
            new DbParam(":nazev", $this->nazev),
        ];

        $sql = "";
        if ($this->id > 0) {
            $sql = "UPDATE tagy SET nazev = :nazev WHERE idTagy = :id";
            $params[] = new DbParam(":id", $this->id, \PDO::PARAM_INT);
        } else {
            $sql = "INSERT INTO tagy (nazev) VALUES (:nazev)";
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
            "SELECT idTagy AS id, nazev AS nazev FROM tagy",
            Tag::class
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

        $sql = "SELECT idTagy AS id, nazev AS nazev FROM tagy $where ORDER BY idTagy LIMIT :pocet";
        $params[] = new DbParam(":pocet", $pocet, \PDO::PARAM_INT);

        return (new Db())->fetchAll($sql, Tag::class, $params);
    }

    public static function ziskatPodleId($id): ?Tag
    {
        return (new Db())->fetch(
            "SELECT idTagy AS id, nazev AS nazev FROM tagy WHERE idTagy = :id",
            Tag::class,
            [
                new DbParam(":id", $id, \PDO::PARAM_INT),
            ]
        );
    }
    public static function ziskatPodleNazvu($nazev): ?Tag
    {
        return (new Db())->fetch(
            "SELECT idTagy AS id, nazev AS nazev FROM tagy WHERE nazev = :nazev",
            Tag::class,
            [
                new DbParam(":nazev", $nazev),
            ]
        );
    }
}
