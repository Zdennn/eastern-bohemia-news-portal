<?php

namespace Controller;

class LogoutController extends Controller
{
    public function zpracuj(array $params): void
    {

        if (isset($_SESSION['uzivatel_id'])) {
            
                unset($_SESSION['uzivatel_id']);
                unset($_SESSION['uzivatel_jmeno']);
                unset($_SESSION['uzivatel_email']);
                unset($_SESSION['uzivatel_role']);
        }

        $this->presmeruj("index");
    }
}
