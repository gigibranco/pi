
<?php
$servidor = "db";
$usuario = "florescer_user";
$senha = "florescer123";
$banco = "florescer";

$conn = mysqli_connect($servidor, $usuario, $senha, $banco);

if (!$conn) {
    die("Erro ao conectar ao banco de dados.");
}

mysqli_set_charset($conn, "utf8mb4");
?>