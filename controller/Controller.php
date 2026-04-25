<?php
namespace Controller {

    abstract class Controller
    {

        protected $view, $data = array();
        protected $controller;
        protected ?int $potrebnaRole = null;

        abstract function zpracuj(array $params): void;

        public function __construct()
        {
            $this->kontrolaPristupu();
            $this->kontrolaBan();
        }

        protected function kontrolaBan(){
            if (isset($_SESSION["uzivatel_role"]) && $_SESSION["uzivatel_role"] == 0) {
                $this->presmeruj("ban");
            }
        }

        protected function kontrolaPristupu()
        {
            if ($this->potrebnaRole !== null) {
                if (!isset($_SESSION["uzivatel_role"])) {//Potřebuje být přihlášený
                    $this->presmeruj("login");
                }

                if ($_SESSION["uzivatel_role"] < $this->potrebnaRole) {//Potřebuje mít spocifickou roli
                    $this->view = "error";
                    return;
                }
            }
        }

        public function zobraz()
        {
            if ($this->view) {
                extract($this->data);
                require_once("view/" . $this->view . ".php");
            }
        }
        public function styl()
        {
            $filePath = $_SERVER['DOCUMENT_ROOT'] . "/assets/styly/" . $this->view . ".css";
            if (file_exists($filePath)) {
                return "<link rel='stylesheet' href='/assets/styly/" . $this->view . ".css'>";
            }
            return "";
        }
        
        public function script()
        {
            $filePath = $_SERVER['DOCUMENT_ROOT'] . "/assets/js/" . $this->view . ".js";
            if (file_exists($filePath)) {
                return "<script src='/assets/js/" . $this->view . ".js'></script>";
            }
            return "";
        }
        
        public function presmeruj($url)
        {
            header("Location: /$url");
            exit;
        }
    }
}