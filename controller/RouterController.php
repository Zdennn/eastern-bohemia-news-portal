<?php
namespace Controller {
    class RouterController extends Controller
    {
        public function zpracuj(array $params): void
        {

            $parsedURL = $this->parseURL($params[0]);

            if ($parsedURL[0] == "") {
                $this->presmeruj('index');
            }

            $controllerName = $this->toControllerName(array_shift($parsedURL));

            try {
                $this->controller = new $controllerName;
            } catch (\Throwable $th) {
                $this->controller = new ErrorController;
            }

            $this->controller->zpracuj($parsedURL);

            if (str_contains($controllerName, "Dashboard")) {
                $this->view = 'layoutDashboard';
            }else if(str_contains($controllerName, "Login")){
                $this->view = 'layoutLoginRegister';
            }else if(str_contains($controllerName, "Register")){
                $this->view = 'layoutLoginRegister';
            }else{
                $this->view = 'layout';
            }
            
            $this->zobraz();

        }
        private function parseURL(string $url): array
        {
            return explode("/", trim($url, "/"));
        }
        private function toControllerName(string $text): string
        {
            $text = str_replace('-', ' ', $text);
            $text = ucwords($text);
            $text = str_replace(' ', '', $text);
            return 'Controller\\' . $text . 'Controller';
        }

    }
}