<?php

namespace Model {

    class Stav
    {
        private int $id = 0;
        private string $stav;

        public function __get($name) {
            if (!array_key_exists($name, get_object_vars($this))) {
                throw new \Exception("Vlastnost {$name} neexistuje.");
            }
            return $this->$name;
        }

        public function __set($name, $value) {
            if (!array_key_exists($name, get_object_vars($this))) {
                throw new \Exception("Vlastnost {$name} neexistuje.");
            }
            if (in_array($name, ["id"])) {
                throw new \Exception("Vlastnost {$name} je pouze pro čtení.");
            }
            $this->$name = $value;
        }

        public function insUpdStav(): ?bool {
            $params = [
                new DbParam(":stav", $this->stav)
            ];

            $sql = "";
            if ($this->id > 0) {
                $sql = "UPDATE stav SET stav = :stav WHERE idStav = :id";
                $params[] = new DbParam(":id", $this->id, \PDO::PARAM_INT);
            } else {
                $sql = "INSERT INTO stav (stav) VALUES (:stav)";
            }

            return 1 === (new Db())->exec($sql, $params);
        }

        public static function ziskatVse(): ?array {
            return (new Db())->fetchAll(
                "SELECT idStav AS id, stav AS stav FROM stav",
                Stav::class
            );
        }

        public static function ziskatPodleId(int $id): ?Stav {
            return (new Db())->fetch(
                "SELECT idStav AS id, stav AS stav FROM stav WHERE idStav = :id",
                Stav::class,
                [
                    new DbParam(":id", $id, \PDO::PARAM_INT)
                ]
            );
        }
    }

}
