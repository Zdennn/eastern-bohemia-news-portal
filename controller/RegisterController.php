<?php

namespace Controller;

use Model\Uzivatel;

class RegisterController extends Controller
{
    public function zpracuj(array $params): void
    {
        require_once 'Validator.php';

        if (!isset($_SESSION['uzivatel_id'])) {

            $uzivatel = new Uzivatel();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $jmeno = $_POST['jmeno'] ?? '';
                $email = $_POST['email'] ?? '';
                $heslo = $_POST['heslo'] ?? '';
                $hesloZnovu = $_POST['hesloZnovu'] ?? '';

                $chyba = "";
                $chyba .= Validator::notEmpty($jmeno, "Jmeno");
                $chyba .= Validator::noSpecialChars($jmeno, "Jmeno");
                $chyba .= Validator::notEmpty($email, "Email");
                $chyba .= Validator::noSpecialChars($email, "Email");
                $chyba .= Validator::validEmail($email);
                $chyba .= Validator::validateHeslo($heslo);
                $chyba .= Validator::validateHeslo($hesloZnovu);

                if ($heslo != $hesloZnovu) {
                    $chyba .= "Zadaná hesla se neschodují";
                }

                if ($chyba) {
                    $this->data['error'] = $chyba;
                } else {

                    $existujiciUzivatel = Uzivatel::ziskatPodleEmailu($email);

                    if ($existujiciUzivatel != null) {
                        $this->data['error'] = 'Uživatel s tímto emailem již existuje.';
                    } else {
                        $uzivatel->jmeno = $jmeno;
                        $uzivatel->email = $email;
                        $uzivatel->heslo = $heslo;
                        $uzivatel->idRole = 1;

                        if ($uzivatel->insUpdUzivatel()) {
                            $this->presmeruj('login');
                        } else {
                            $this->data['error'] = 'Registrace se nezdařila. Zkuste to prosím znovu.';
                        }
                    }
                }
            }

            $this->view = 'register';
        } else {
            $this->presmeruj("ucet");
        }
    }
}
