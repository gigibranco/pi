<?php
require_once "verificarLogin.php";
require_once "config/banco.php";

$usuario_id = (int) $_SESSION["usuario_id"];

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: personalizarConta.php");
    exit;
}

$acao = $_POST["acao"] ?? "";

function removerFotoPerfil($caminho)
{
    if (empty($caminho) || strpos($caminho, "uploads/perfis/") !== 0) {
        return;
    }

    $arquivo = __DIR__ . "/" . $caminho;
    $pasta = realpath(__DIR__ . "/uploads/perfis");
    $arquivoReal = realpath($arquivo);

    if (
        $pasta !== false &&
        $arquivoReal !== false &&
        strpos($arquivoReal, $pasta . DIRECTORY_SEPARATOR) === 0 &&
        is_file($arquivoReal)
    ) {
        unlink($arquivoReal);
    }
}

if ($acao === "excluir") {

    $sqlFoto = "SELECT foto_perfil FROM usuarios WHERE id = ?";
    $stmtFoto = mysqli_prepare($conn, $sqlFoto);
    mysqli_stmt_bind_param($stmtFoto, "i", $usuario_id);
    mysqli_stmt_execute($stmtFoto);

    $resultadoFoto = mysqli_stmt_get_result($stmtFoto);
    $dadosUsuario = mysqli_fetch_assoc($resultadoFoto);

    $fotoAntiga = $dadosUsuario["foto_perfil"] ?? null;

    mysqli_stmt_close($stmtFoto);

    $sqlExcluir = "DELETE FROM usuarios WHERE id = ?";
    $stmtExcluir = mysqli_prepare($conn, $sqlExcluir);
    mysqli_stmt_bind_param($stmtExcluir, "i", $usuario_id);

    if (mysqli_stmt_execute($stmtExcluir)) {

        removerFotoPerfil($fotoAntiga);

        mysqli_stmt_close($stmtExcluir);
        mysqli_close($conn);

        session_unset();
        session_destroy();

        header("Location: index.php?conta=excluida");
        exit;

    } else {
        mysqli_stmt_close($stmtExcluir);
        header("Location: personalizarConta.php?erro=excluir");
        exit;
    }
}

if ($acao === "salvar") {

    $nome = trim($_POST["nome_completo"] ?? "");
    $usuario = trim($_POST["nome_usuario"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $novaSenha = $_POST["nova_senha"] ?? "";
    $confirmarSenha = $_POST["confirmar_senha"] ?? "";

    if ($nome === "" || $usuario === "" || $email === "") {
        header("Location: personalizarConta.php?erro=campos");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: personalizarConta.php?erro=email");
        exit;
    }

    $sqlVerificar = "SELECT id FROM usuarios
                     WHERE (nome_usuario = ? OR email = ?)
                     AND id <> ?";

    $stmtVerificar = mysqli_prepare($conn, $sqlVerificar);
    mysqli_stmt_bind_param($stmtVerificar, "ssi", $usuario, $email, $usuario_id);
    mysqli_stmt_execute($stmtVerificar);

    $resultadoVerificar = mysqli_stmt_get_result($stmtVerificar);

    if (mysqli_num_rows($resultadoVerificar) > 0) {
        mysqli_stmt_close($stmtVerificar);
        header("Location: personalizarConta.php?erro=duplicado");
        exit;
    }

    mysqli_stmt_close($stmtVerificar);

    if ($novaSenha !== "" || $confirmarSenha !== "") {

        if ($novaSenha !== $confirmarSenha) {
            header("Location: personalizarConta.php?erro=senhas");
            exit;
        }

        if (strlen($novaSenha) < 6) {
            header("Location: personalizarConta.php?erro=senha_curta");
            exit;
        }
    }

    $sqlAtual = "SELECT foto_perfil FROM usuarios WHERE id = ?";
    $stmtAtual = mysqli_prepare($conn, $sqlAtual);
    mysqli_stmt_bind_param($stmtAtual, "i", $usuario_id);
    mysqli_stmt_execute($stmtAtual);

    $resultadoAtual = mysqli_stmt_get_result($stmtAtual);
    $dadosAtuais = mysqli_fetch_assoc($resultadoAtual);
    $fotoAntiga = $dadosAtuais["foto_perfil"] ?? null;

    mysqli_stmt_close($stmtAtual);

    $novaFoto = null;

    if (isset($_FILES["foto_perfil"]) &&
        $_FILES["foto_perfil"]["error"] !== UPLOAD_ERR_NO_FILE) {

        if ($_FILES["foto_perfil"]["error"] !== UPLOAD_ERR_OK) {
            header("Location: personalizarConta.php?erro=upload");
            exit;
        }

        if ($_FILES["foto_perfil"]["size"] > 5 * 1024 * 1024) {
            header("Location: personalizarConta.php?erro=tamanho");
            exit;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $tipoArquivo = finfo_file($finfo, $_FILES["foto_perfil"]["tmp_name"]);
        finfo_close($finfo);

        $tiposPermitidos = [
            "image/jpeg" => "jpg",
            "image/png"  => "png",
            "image/webp" => "webp"
        ];

        if (!isset($tiposPermitidos[$tipoArquivo])) {
            header("Location: personalizarConta.php?erro=formato");
            exit;
        }

        $pasta = __DIR__ . "/uploads/perfis/";

        if (!is_dir($pasta)) {
            mkdir($pasta, 0755, true);
        }

        $nomeArquivo = "perfil_" . $usuario_id . "_" .
                       bin2hex(random_bytes(8)) . "." .
                       $tiposPermitidos[$tipoArquivo];

        $destino = $pasta . $nomeArquivo;

        if (!move_uploaded_file($_FILES["foto_perfil"]["tmp_name"], $destino)) {
            header("Location: personalizarConta.php?erro=upload");
            exit;
        }

        $novaFoto = "uploads/perfis/" . $nomeArquivo;
    }

    if ($novaSenha !== "") {

        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

        if ($novaFoto !== null) {
            $sqlAtualizar = "UPDATE usuarios
                             SET nome_completo = ?, nome_usuario = ?,
                                 email = ?, senha = ?, foto_perfil = ?
                             WHERE id = ?";

            $stmtAtualizar = mysqli_prepare($conn, $sqlAtualizar);
            mysqli_stmt_bind_param(
                $stmtAtualizar,
                "sssssi",
                $nome,
                $usuario,
                $email,
                $senhaHash,
                $novaFoto,
                $usuario_id
            );

        } else {
            $sqlAtualizar = "UPDATE usuarios
                             SET nome_completo = ?, nome_usuario = ?,
                                 email = ?, senha = ?
                             WHERE id = ?";

            $stmtAtualizar = mysqli_prepare($conn, $sqlAtualizar);
            mysqli_stmt_bind_param(
                $stmtAtualizar,
                "ssssi",
                $nome,
                $usuario,
                $email,
                $senhaHash,
                $usuario_id
            );
        }

    } else {

        if ($novaFoto !== null) {
            $sqlAtualizar = "UPDATE usuarios
                             SET nome_completo = ?, nome_usuario = ?,
                                 email = ?, foto_perfil = ?
                             WHERE id = ?";

            $stmtAtualizar = mysqli_prepare($conn, $sqlAtualizar);
            mysqli_stmt_bind_param(
                $stmtAtualizar,
                "ssssi",
                $nome,
                $usuario,
                $email,
                $novaFoto,
                $usuario_id
            );

        } else {
            $sqlAtualizar = "UPDATE usuarios
                             SET nome_completo = ?, nome_usuario = ?, email = ?
                             WHERE id = ?";

            $stmtAtualizar = mysqli_prepare($conn, $sqlAtualizar);
            mysqli_stmt_bind_param(
                $stmtAtualizar,
                "sssi",
                $nome,
                $usuario,
                $email,
                $usuario_id
            );
        }
    }

    if (mysqli_stmt_execute($stmtAtualizar)) {

        mysqli_stmt_close($stmtAtualizar);

        if ($novaFoto !== null && $fotoAntiga !== $novaFoto) {
            removerFotoPerfil($fotoAntiga);
        }

        mysqli_close($conn);

        header("Location: personalizarConta.php?sucesso=1");
        exit;

    } else {
        if ($novaFoto !== null) {
            removerFotoPerfil($novaFoto);
        }

        mysqli_stmt_close($stmtAtualizar);
        header("Location: personalizarConta.php?erro=salvar");
        exit;
    }
}

header("Location: personalizarConta.php");
exit;
?>