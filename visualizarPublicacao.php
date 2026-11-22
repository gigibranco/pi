<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "config/banco.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: catalogo.php");
    exit;
}

// Define a página de retorno
$origem = $_GET["voltar"] ?? "catalogo";

$paginasRetorno = [
    "catalogo" => "catalogo.php",
    "minhasPublicacoes" => "minhasPublicacoes.php",
    "adminPublicacoes" => "adminPublicacoes.php",
    "favoritos" => "favoritos.php"
];

$paginaVoltar = $paginasRetorno[$origem] ?? "catalogo.php";

$usuarioLogado = isset($_SESSION["usuario_id"]);
$usuario_id = $usuarioLogado ? (int) $_SESSION["usuario_id"] : 0;

$mensagem = "";
$mensagemTipo = "success";

$sql = "SELECT * FROM publicacoes WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
$flor = mysqli_fetch_assoc($resultado);

mysqli_stmt_close($stmt);

if (!$flor) {
    mysqli_close($conn);
    header("Location: catalogo.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!$usuarioLogado) {
        $mensagem = "Você precisa entrar na sua conta para realizar essa ação.";
        $mensagemTipo = "warning";

    } else {

        $acao = $_POST["acao"] ?? "";

        if ($acao === "adicionar") {

            $sql = "INSERT IGNORE INTO favoritos (usuario_id, publicacao_id)
                    VALUES (?, ?)";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $usuario_id, $id);

            if (mysqli_stmt_execute($stmt)) {
                header("Location: visualizarPublicacao.php?id=$id&voltar=$origem&status=adicionado");
                exit;
            }

            mysqli_stmt_close($stmt);

        } elseif ($acao === "remover") {

            $sql = "DELETE FROM favoritos
                    WHERE usuario_id = ? AND publicacao_id = ?";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $usuario_id, $id);

            if (mysqli_stmt_execute($stmt)) {
                header("Location: visualizarPublicacao.php?id=$id&voltar=$origem&status=removido");
                exit;
            }

            mysqli_stmt_close($stmt);
        }
    }
}

$favoritada = false;

if ($usuarioLogado) {

    $sql = "SELECT id FROM favoritos
            WHERE usuario_id = ? AND publicacao_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $usuario_id, $id);
    mysqli_stmt_execute($stmt);

    $resultadoFavorito = mysqli_stmt_get_result($stmt);
    $favoritada = mysqli_num_rows($resultadoFavorito) > 0;

    mysqli_stmt_close($stmt);
}

if (isset($_GET["status"])) {

    if ($_GET["status"] === "adicionado") {
        $mensagem = "Flor adicionada aos seus favoritos!";
    } elseif ($_GET["status"] === "removido") {
        $mensagem = "Flor removida dos seus favoritos!";
    }
}

function e($valor) {
    return htmlspecialchars($valor ?? "", ENT_QUOTES, "UTF-8");
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= e($flor["nome_flor"]) ?> - Florescer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="pagina-visualizar-publicacao">

    <nav class="navbar navbar-expand-lg navbar-florescer shadow-sm">
        <div class="container">

            <a class="navbar-brand marca-navbar" href="telaPrincipal.php">
                <span class="marca-icone">❀</span>
                Florescer
            </a>

            <a href="<?= e($paginaVoltar) ?>" class="btn btn-navbar">
                ← Voltar
            </a>

        </div>
    </nav>

    <main class="visualizar-conteudo">

        <div class="container">

            <div class="visualizar-cabecalho text-center">

                <div class="visualizar-flor">✿</div>

                <h1>Detalhes da publicação</h1>

                <p>Conheça melhor esta espécie cadastrada pela comunidade</p>

            </div>

            <?php if (!empty($mensagem)): ?>
                <div class="alert alert-<?= e($mensagemTipo) ?> text-center">
                    <?= e($mensagem) ?>
                </div>
            <?php endif; ?>

            <section class="visualizar-card">

                <h2 class="visualizar-nome">
                    <?= e($flor["nome_flor"]) ?>
                </h2>

                <?php if (!empty($flor["imagem"]) && file_exists(__DIR__ . "/" . $flor["imagem"])): ?>

                    <div class="visualizar-imagem-container">

                        <img
                            src="<?= e($flor["imagem"]) ?>"
                            alt="<?= e($flor["nome_flor"]) ?>"
                            class="visualizar-imagem">

                    </div>

                <?php else: ?>

                    <div class="visualizar-imagem-vazia">
                        🌺
                    </div>

                <?php endif; ?>

                <div class="visualizar-informacoes">

                    <div class="visualizar-campo">
                        <span class="visualizar-icone">🌱</span>
                        <div>
                            <strong>Nome científico</strong>
                            <p><?= e($flor["nome_cientifico"]) ?></p>
                        </div>
                    </div>

                    <div class="visualizar-campo">
                        <span class="visualizar-icone">🌷</span>
                        <div>
                            <strong>Categoria</strong>
                            <p><?= e($flor["categoria"]) ?></p>
                        </div>
                    </div>

                    <div class="visualizar-campo">
                        <span class="visualizar-icone">🎨</span>
                        <div>
                            <strong>Cor</strong>
                            <p><?= e($flor["cor"]) ?></p>
                        </div>
                    </div>

                    <div class="visualizar-campo visualizar-descricao">
                        <span class="visualizar-icone">📝</span>
                        <div>
                            <strong>Descrição</strong>
                            <p><?= nl2br(e($flor["descricao"])) ?></p>
                        </div>
                    </div>

                </div>

                <div class="visualizar-acoes text-center">

                    <?php if ($usuarioLogado): ?>

                        <form method="POST">

                            <?php if ($favoritada): ?>

                                <button
                                    type="submit"
                                    name="acao"
                                    value="remover"
                                    class="btn btn-rosa">
                                    ❤️ Remover dos Favoritos
                                </button>

                            <?php else: ?>

                                <button
                                    type="submit"
                                    name="acao"
                                    value="adicionar"
                                    class="btn btn-rosa">
                                    ♡ Adicionar aos Favoritos
                                </button>

                            <?php endif; ?>

                        </form>

                    <?php else: ?>

                        <p class="text-muted">
                            Entre na sua conta para adicionar esta flor aos favoritos
                        </p>

                    <?php endif; ?>

                    <a href="<?= e($paginaVoltar) ?>" class="btn btn-rosa mt-3">
                        ← Voltar
                    </a>

                </div>

            </section>

        </div>

    </main>

    <footer class="footer-florescer text-center py-4">
        <small>Florescer © 2026</small>
    </footer>

</body>
</html>
