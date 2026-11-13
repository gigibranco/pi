<?php
session_start();

require_once "config/banco.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$usuario = trim($_POST["usuario"] ?? "");
$senha = $_POST["senha"] ?? "";

if ($usuario === "" || $senha === "") {
    header("Location: index.php?erro=credenciais");
    exit;
}

$sql = "SELECT id, nome_completo, nome_usuario, email, senha, tipo
        FROM usuarios
        WHERE nome_usuario = ? OR email = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "ss", $usuario, $usuario);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
$dados = mysqli_fetch_assoc($resultado);

if ($dados && password_verify($senha, $dados["senha"])) {

    session_regenerate_id(true);

    $_SESSION["usuario_id"] = $dados["id"];
    $_SESSION["nome_usuario"] = $dados["nome_completo"];
    $_SESSION["tipo"] = $dados["tipo"];

    header("Location: telaPrincipal.php");
    exit;

} else {
    header("Location: index.php?erro=credenciais");
    exit;
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
