<?php

namespace Controller;

use Model\Uzivatel;

class LoginController extends Controller
{
    public function zpracuj(array $params): void
    {
        if (!isset($_SESSION['uzivatel_id'])) {

            $uzivatelModel = new Uzivatel();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email = $_POST['email'] ?? '';
                $heslo = $_POST['heslo'] ?? '';

                $chyba = "";
                $chyba .= Validator::notEmpty($email, "Email");
                $chyba .= Validator::noSpecialChars($email, "Email") ;
                $chyba .= Validator::validEmail($email);
                $chyba .= Validator::validateHeslo($heslo);

                if ($chyba) {
                    $this->data['error'] = $chyba;
                } else {

                    $uzivatel = $uzivatelModel->prihlasit($email, $heslo);

                    if ($uzivatel) {
                        $_SESSION['uzivatel_id'] = $uzivatel->id;
                        $_SESSION['uzivatel_jmeno'] = $uzivatel->jmeno;
                        $_SESSION['uzivatel_email'] = $uzivatel->email;
                        $_SESSION['uzivatel_role'] = $uzivatel->idRole;
                        $this->presmeruj('ucet');
                    } else {
                        $this->data['error'] = 'Neplatný e-mail nebo heslo.';
                    }
                }
            }

            $this->view = 'login';
        } else {
            $this->presmeruj("ucet");
        }
    }
}
