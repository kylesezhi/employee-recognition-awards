<?php
//Turn on error reporting
ini_set('display_errors', 'On');

include_once "texCert.php";

$id = $_POST["id"];
texCert ($id, "v");
?>