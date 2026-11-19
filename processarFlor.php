<?php
require_once "verificarLogin.php";
require_once "config/banco.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: cadastroFlor.php");
    exit;
}

$nome_flor = trim($_POST["nome_flor"] ?? "");
$nome_cientifico = trim($_POST["nome_cientifico"] ?? "");
$categoria = trim($_POST["categoria"] ?? "");
$cor = trim($_POST["cor"] ?? "");
$descricao = trim($_POST["descricao"] ?? "");

$usuario_id = $_SESSION["usuario_id"] ?? null;

if (
    empty($nome_flor) ||
    empty($nome_cientifico) ||
    empty($categoria) ||
    empty($cor) ||
    empty($descricao) ||
    !$usuario_id
) {
    die("Preencha todos os campos obrigatórios e faça login novamente.");
}

$caminhoImagem = null;

if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] !== UPLOAD_ERR_NO_FILE) {

    if ($_FILES["imagem"]["error"] !== UPLOAD_ERR_OK) {
        die("Erro ao enviar a imagem.");
    }

    if ($_FILES["imagem"]["size"] > 5 * 1024 * 1024) {
        die("A imagem deve ter no máximo 5 MB.");
    }

    $tiposPermitidos = [
        "image/jpeg" => "jpg",
        "image/png" => "png",
        "image/webp" => "webp"
    ];

    $tipoImagem = mime_content_type($_FILES["imagem"]["tmp_name"]);

    if (!isset($tiposPermitidos[$tipoImagem])) {
        die("Formato de imagem não permitido. Envie JPG, PNG ou WEBP.");
    }

    $pastaDestino = "imagens/publicacoes/";

    if (!is_dir($pastaDestino)) {
        if (!mkdir($pastaDestino, 0755, true)) {
            die("Não foi possível criar a pasta de imagens.");
        }
    }

    $nomeArquivo = uniqid("flor_", true) . "." . $tiposPermitidos[$tipoImagem];

    $destino = $pastaDestino . $nomeArquivo;

    if (!move_uploaded_file($_FILES["imagem"]["tmp_name"], $destino)) {
        die("Não foi possível salvar a imagem.");
    }

    $caminhoImagem = $destino;
}

$sql = "INSERT INTO publicacoes
        (usuario_id, nome_flor, nome_cientifico, categoria, cor, descricao, imagem)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Erro ao preparar o cadastro.");
}

mysqli_stmt_bind_param(
    $stmt,
    "issssss",
    $usuario_id,
    $nome_flor,
    $nome_cientifico,
    $categoria,
    $cor,
    $descricao,
    $caminhoImagem
);

if (mysqli_stmt_execute($stmt)) {

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    header("Location: minhasPublicacoes.php");
    exit;

} else {

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    die("Erro ao cadastrar a flor.");
}
