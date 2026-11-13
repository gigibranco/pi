<?php
require_once "verificarLogin.php";


if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== "administrador") {
    header("Location: telaPrincipal.php");
    exit;
}
?>
