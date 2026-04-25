<?php

namespace Model {

    require_once "_db/database.php";
    require_once "DbParam.php";

    class Db
    {

        private \PDO $connection;

        public function __construct()
        {
            $this->connection = new \PDO(
                "mysql:dbname=" . DB_N . ";host=" . HOST,
                USER,
                PASS,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,  //při chybě v db vyhodí exeptions v php
                    \PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,  //zakáže více dotazů v 1 dotazu, nebere ; jako ukončení dotazu
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4", //kodování na utf8
                ]
            );
        }

        //insert, update, delete
        public function exec(string $sql, array $params = []): ?int
        {
            try {
                $dotaz = $this->connection->prepare($sql);
                foreach ($params as $param) {
                    $dotaz->bindParam($param->name, $param->value, $param->type);
                }
                $dotaz->execute();
                return $dotaz->rowCount();
            } catch (\PDOException $ex) {
                return null;
            }
        }

        //select na jeden záznam
        public function fetch(string $sql, string $class, array $params = []): ?object
        {
            try {
                $dotaz = $this->connection->prepare($sql);
                foreach ($params as $param) {
                    $dotaz->bindParam($param->name, $param->value, $param->type);
                }
                $dotaz->execute();
                $dotaz->setFetchMode(\PDO::FETCH_CLASS, $class);

                $result = $dotaz->fetch();

                if ($result === false) {
                    return null;
                }
                return $result;
            } catch (\PDOException $ex) {
                return null;
            }
        }

        //select na všechny záznamy
        public function fetchAll(string $sql, string $class, array $params = []): ?array
        {
            try {
                $dotaz = $this->connection->prepare(query: $sql);
                foreach ($params as $param) {
                    $dotaz->bindParam($param->name, $param->value, $param->type);
                }
                $dotaz->execute();
                $dotaz->setFetchMode(\PDO::FETCH_CLASS, $class);
                $result = $dotaz->fetchAll();
                return $result;
            } catch (\PDOException $ex) {
                return null;
            }
        }

        //select na jednu hodnotu (např. SELECT count() FROM table)
        public function fetchValue(string $sql, array $params = []): mixed
        {
            try {
                $dotaz = $this->connection->prepare($sql);
                foreach ($params as $param) {
                    $dotaz->bindValue($param->name, $param->value, $param->type);
                }
                $dotaz->execute();
                return $dotaz->fetch(\PDO::FETCH_NUM)[0];
            } catch (\PDOException $ex) {
                return null;
            }
        }

        //lastinsertID
        public function lastInsertId()
        {
            return $this->connection->lastInsertId();
        }
    }
}
