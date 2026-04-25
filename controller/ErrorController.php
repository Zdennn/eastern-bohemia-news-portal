<?php
namespace Controller {
    class ErrorController extends Controller
    {
        public function zpracuj(array $params): void
        {
            $this->view = "error";
        }
    }

}