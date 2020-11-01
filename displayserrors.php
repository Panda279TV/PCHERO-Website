<?php
if ($_SERVER["SERVER_ADDR"] === "127.0.0.1" || $_SERVER["SERVER_ADDR"] === "::1") {
    error_reporting(E_ALL);
    ini_set("display_errors", "1");
} else {
    error_reporting(E_ERROR);
    ini_set("display_errors", "0");
}
?>