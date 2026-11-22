<?php

date_default_timezone_set("America/Sao_Paulo");

$conn = mysqli_connect("db", "florescer_user", "florescer123", "florescer");

if (!$conn) {
    die("Erro ao conectar ao banco de dados.");
}

mysqli_set_charset($conn, "utf8mb4");

mysqli_query($conn, "SET time_zone = '-03:00'");