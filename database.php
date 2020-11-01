<?php
// Host, Name, User, Passwort und Port werden in einer Variable gespeichert
$db_host = 'localhost';
$db_name = 'PCHERO';
$db_user = 'root';
$db_password = 'root';
$db_port = 8889;

// Datenbank Verbindung herstellen mit MYSQL PDO
$dbh = new PDO("mysql:host=$db_host;dbname=$db_name;port=$db_port;charset=utf8", $db_user, $db_password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone = '+00:00'"));

// PHP Timezone wird auf UTC +00:00 gesetzt
date_default_timezone_set("UTC");
?>