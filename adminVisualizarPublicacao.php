<?php
require_once "verificarAdmin.php";
require_once "config/banco.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: adminPublicacoes.php");
    exit;
}

$id = (int) $_GET["id"];

$sql = "SELECT publicacoes.*, usuarios.nome_completo, usuarios.nome_usuario
        FROM publicacoes
        INNER JOIN usuarios ON publicacoes.usuario_id = usuarios.id
        WHERE publicacoes.id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
$publicacao = mysqli_fetch_assoc($resultado);

if (!$publicacao) {
    header("Location: adminPublicacoes.php");
    exit;
}

function e($valor) {
    return htmlspecialchars($valor ?? "", ENT_QUOTES, "UTF-8");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Visualizar Publicação - Florescer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="pagina-admin-visualizar">

    <nav class="navbar navbar-expand-lg navbar-florescer shadow-sm">

        <div class="container">

            <a class="navbar-brand marca-navbar" href="admin.php">
                <span class="marca-icone">🌸</span>
                Florescer | Administração
            </a>

            <div class="d-flex align-items-center gap-2">

                <span class="admin-identificacao">
                    Administrador
                </span>

                <a href="index.php" class="btn btn-sair">
                    Sair
                </a>

            </div>

        </div>

    </nav>

    <main class="container conteudo-admin-visualizar">

        <div class="cabecalho-admin-visualizar">

            <div>
                <h2>Visualizar publicação</h2>

                <p>
                    Confira as informações da flor cadastrada no Florescer
                </p>
            </div>

            <a href="adminPublicacoes.php" class="btn-voltar-admin">
                ← Voltar
            </a>

        </div>

        <section class="card-publicacao-visualizar">

            <?php if (!empty($publicacao["imagem"])): ?>

                <div class="imagem-publicacao-visualizar">

                    <img
                        src="<?= e($publicacao["imagem"]) ?>"
                        alt="<?= e($publicacao["nome_flor"]) ?>">

                </div>

            <?php endif; ?>

            <div class="dados-publicacao-visualizar">

                <span class="etiqueta-publicacao">
                    Publicação cadastrada
                </span>

                <h3>
                    <?= e($publicacao["nome_flor"]) ?>
                </h3>

                <div class="informacoes-publicacao">

                    <div>
                        <span>Nome científico</span>
                        <p>
                            <?= e($publicacao["nome_cientifico"] ?: "Não informado") ?>
                        </p>
                    </div>

                    <div>
                        <span>Categoria</span>
                        <p>
                            <?= e($publicacao["categoria"] ?: "Não informada") ?>
                        </p>
                    </div>

                    <div>
                        <span>Cor</span>
                        <p>
                            <?= e($publicacao["cor"] ?: "Não informada") ?>
                        </p>
                    </div>

                    <div>
                        <span>Publicado por</span>
                        <p>
                            <?= e($publicacao["nome_completo"]) ?>
                            (@<?= e($publicacao["nome_usuario"]) ?>)
                        </p>
                    </div>

                    <div>
                        <span>Data de cadastro</span>
                        <p>
                            <?= !empty($publicacao["data_cadastro"])
                                ? date("d/m/Y H:i", strtotime($publicacao["data_cadastro"]))
                                : "Não informada" ?>
                        </p>
                    </div>

                </div>

                <div class="descricao-publicacao-visualizar">

                    <h5>Sobre esta flor</h5>

                    <p>
                        <?= e($publicacao["descricao"] ?: "Nenhuma descrição informada.") ?>
                    </p>

                </div>

                <div class="acoes-publicacao-visualizar">

                    <a href="adminEditarPublicacao.php?id=<?= $id ?>" class="btn btn-rosa">
                        Editar publicação
                    </a>

                    <a href="adminExcluirPublicacao.php?id=<?= $id ?>" class="btn btn-outline-danger">
                        Excluir publicação
                    </a>

                    <a href="adminPublicacoes.php" class="btn btn-outline-secondary">
                        Voltar às publicações
                    </a>

                </div>

            </div>

        </section>

    </main>
    <footer class="footer-florescer text-center py-4">

        <small>
            Florescer © 2026
        </small>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
