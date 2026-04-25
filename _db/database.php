<?php
 if ($_SERVER['HTTP_HOST'] === '' || $_SERVER['SERVER_NAME'] === '') {
     define("HOST", "");
     define("USER", "");
     define("PASS", "");
     define("DB_N", "");
 } elseif ($_SERVER['HTTP_HOST'] === 'zpravodaj' || $_SERVER['SERVER_NAME'] === 'zpravodaj') {
     define("HOST", "localhost");
     define("USER", "root");
     define("PASS", "");
     define("DB_N", "zpravodajskyportal");
 } else {
     define("HOST", "localhost");
     define("USER", "root");
     define("PASS", "");
     define("DB_N", "zpravodajskyportal");
 }