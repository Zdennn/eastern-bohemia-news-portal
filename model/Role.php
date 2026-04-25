<?php

namespace Model;

class Role
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
        if (in_array($name, ["id"])) {
            throw new \Exception("Vlastnost {$name} je pouze pro čtení.");
        }
        $this->$name = $value;
    }

    public function insUpdRole(): ?bool
    {
        $params = [
            new DbParam(":nazev", $this->nazev)
        ];

        $sql = "";
        if ($this->id > 0) {
            $sql = "UPDATE role SET nazev = :nazev WHERE idRole = :id";
            $params[] = new DbParam(":id", $this->id, \PDO::PARAM_INT);
        } else {
            $sql = "INSERT INTO role (nazev) VALUES (:nazev)";
        }

        return 1 === (new Db())->exec($sql, $params);
    }

    public static function ziskatVse(): ?array
    {
        return (new Db())->fetchAll(
            "SELECT idRole AS id, nazev AS nazev FROM role",
            Role::class
        );
    }

    public static function ziskatPodleId(int $id): ?Role
    {
        return (new Db())->fetch(
            "SELECT idRole AS id, nazev AS nazev FROM role WHERE idRole = :id",
            Role::class,
            [
                new DbParam(":id", $id, \PDO::PARAM_INT)
            ]
        );
    }
}
