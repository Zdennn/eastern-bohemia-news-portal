<?php

namespace Controller {

    class Validator
    {
        public static function notEmpty(string $value, string $fieldName = 'Pole'): ?string
        {
            return empty($value) ? "$fieldName nesmí být prázdné.<br>" : null;
        }

        public static function noSpecialChars(string $value, string $fieldName = 'Pole'): ?string
        {
            return preg_match('/[*<>{}()"\'`;]/', $value) ? "$fieldName obsahuje nepovolené speciální znaky.<br>" : null;
        }

        public static function validateJmeno(string $jmeno): ?string
        {
            if (empty($jmeno)) {
                return 'Jméno nesmí být prázdné.<br>';
            }
            if (preg_match('/[<>{}()"\'`;]/', $jmeno)) {
                return 'Jméno obsahuje nepovolené speciální znaky.<br>';
            }
            return null;
        }

        public static function validEmail(string $email): ?string
        {
            return filter_var($email, FILTER_VALIDATE_EMAIL) ? null : "Neplatný formát e-mailu.<br>";
        }

        public static function lengthBetween(string $value, int $min, int $max, string $fieldName = 'Pole'): ?string
        {
            $length = mb_strlen($value);
            if ($length < $min) {
                return "$fieldName musí mít alespoň $min znaků.<br>";
            }
            if ($length > $max) {
                return "$fieldName nesmí mít více než $max znaků.<br>";
            }
            return null;
        }

        public static function validateHeslo(string $heslo): ?string
        {
            $errorMessage = '';
            $isValid = true;

            if (empty($heslo)) {
                $errorMessage .= 'Heslo nesmí být prázdné.<br>';
                $isValid = false;
            }
            if (strlen($heslo) < 8) {
                $errorMessage .= 'Heslo musí mít alespoň 8 znaků.<br>';
                $isValid = false;
            }
            if (!preg_match('/[A-Z]/', $heslo)) {
                $errorMessage .= 'Heslo musí obsahovat alespoň jedno velké písmeno.<br>';
                $isValid = false;
            }
            if (!preg_match('/[a-z]/', $heslo)) {
                $errorMessage .= 'Heslo musí obsahovat alespoň jedno malé písmeno.<br>';
                $isValid = false;
            }
            if (!preg_match('/\d/', $heslo)) {
                $errorMessage .= 'Heslo musí obsahovat alespoň jednu číslici.<br>';
                $isValid = false;
            }
            if ($isValid) {
                return null;
            }else{
                return $errorMessage;
            }
        }
    }
}
