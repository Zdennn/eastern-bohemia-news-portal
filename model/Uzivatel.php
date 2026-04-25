<?php

namespace Model;

class Uzivatel
{
    private int $id = 0;
    private string $jmeno;
    private string $email;
    private string $heslo;
    private \DateTime|String $createdAt;
    private \DateTime|String $updatedAt;
    private ?string $popis = null;
    private ?string $profilovka = null;
    private int $idRole;

    public function __get($name)
    {
        if (!array_key_exists($name, get_object_vars($this)))
            throw new \Exception("Vlastnost {$name} neexistuje.");

        return $this->$name;
    }

    public function __set($name, $value)
    {
        if (!property_exists($this, $name)) {
            throw new \Exception("Vlastnost {$name} neexistuje.");
        }
        if (in_array($name, ["id"])) {
            throw new \Exception("Vlastnost {$name} je pouze pro čtení nebo ji nelze nastavit přímo.");
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

    public function insUpdUzivatel($file = null, $pasword = null)
    {
        if ($this->id != 0) {
            if ($file !== null) {
                if (!isset($file['error']) || is_array($file['error'])) {
                    return 'Neplatné parametery.';
                }

                switch ($file['error']) {
                    case UPLOAD_ERR_OK:
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        return 'Neposlán žádný soubor.';
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        return 'Přesažena maximální velikost souboru.';
                    default:
                        return 'Neznámý error.';
                }

                if ($file['size'] > 10000000) {
                    return 'Přesažena maximální velikost souboru.';
                }

                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $ext = array_search(
                    $finfo->file($file['tmp_name']),
                    [
                        'jpg' => 'image/jpeg',
                        'png' => 'image/png',
                        'gif' => 'image/gif',
                        'webp' => 'image/webp'
                    ],
                    true
                );

                if ($ext === false) {
                    return 'Neplatný formát souboru.';
                }

                $nazevSouboru = sprintf('%s.%s', sha1_file($file['tmp_name']), $ext);
                $cesta = 'assets/img/' . $nazevSouboru;

                
                if (!move_uploaded_file($file['tmp_name'], $cesta)) {
                    return 'Selhalo nahrávání obrázku.';
                }

                $this->profilovka = "/" . $cesta;
            }
            if ($pasword != null) {
                $this->heslo = password_hash($pasword, PASSWORD_BCRYPT);
            }
        } else {
            $this->heslo = password_hash($this->heslo, PASSWORD_BCRYPT);
        }

        $params = [
            new DbParam(":jmeno", $this->jmeno),
            new DbParam(":email", $this->email),
            new DbParam(":heslo", $this->heslo),
            new DbParam(":popis", $this->popis),
            new DbParam(":profilovka", $this->profilovka),
            new DbParam(":idRole", $this->idRole, \PDO::PARAM_INT)
        ];

        $sql = "";
        if ($this->id > 0) {
            $sql = "UPDATE uzivatele SET jmeno = :jmeno, email = :email, heslo = :heslo, popis = :popis, profilovka = :profilovka, Role_idRole = :idRole
                    WHERE idUzivatele = :id";
            $params[] = new DbParam(":id", $this->id, \PDO::PARAM_INT);
        } else {
            $sql = "INSERT INTO uzivatele (jmeno, email, heslo, popis, profilovka, Role_idRole)
                    VALUES (:jmeno, :email, :heslo, :popis, :profilovka, :idRole)";
        }

        return 1 === (new Db())->exec($sql, $params) ? true : 'Database error.';
    }

    public static function ziskatVse(): array
    {
        return (new Db())->fetchAll(
            "SELECT idUzivatele AS id, jmeno AS jmeno, email AS email, heslo AS heslo, created_at AS createdAt,
            updated_at AS updatedAt, popis AS popis, profilovka AS profilovka, Role_idRole AS idRole FROM uzivatele ORDER BY created_at DESC",
            Uzivatel::class
        );
    }

    public static function ziskatPodleId($id): ?Uzivatel
    {
        return (new Db())->fetch(
            "SELECT idUzivatele AS id, jmeno AS jmeno, email AS email, heslo AS heslo, created_at AS createdAt,
            updated_at AS updatedAt, popis AS popis, profilovka AS profilovka, Role_idRole AS idRole FROM uzivatele
            WHERE idUzivatele = :id",
            Uzivatel::class,
            [
                new DbParam(":id", $id, \PDO::PARAM_INT)
            ]
        );
    }



    public static function prihlasit(string $email, string $heslo): ?Uzivatel
    {
        $uzivatel = self::ziskatPodleEmailu($email);

        if ($uzivatel && $uzivatel->overitHeslo($heslo)) {
            return $uzivatel;
        }

        return null;
    }
    public function overitHeslo(string $heslo): bool
    {
        return password_verify($heslo, $this->heslo);
    }
    public static function ziskatPodleEmailu(string $email): ?Uzivatel
    {
        return (new Db())->fetch(
            "SELECT idUzivatele AS id, jmeno AS jmeno, email AS email, heslo AS heslo, created_at AS createdAt,
                    updated_at AS updatedAt, popis AS popis, profilovka AS profilovka, Role_idRole AS idRole 
             FROM uzivatele 
             WHERE email = :email",
            Uzivatel::class,
            [new DbParam(":email", $email, \PDO::PARAM_STR)]
        );
    }
}
