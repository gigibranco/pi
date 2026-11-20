<?php
require_once "verificarAdmin.php";
require_once "config/banco.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: adminPublicacoes.php");
    exit;
}

$id = (int) $_GET["id"];

$sql = "SELECT * FROM publicacoes WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
$flor = mysqli_fetch_assoc($resultado);

mysqli_stmt_close($stmt);

if (!$flor) {
    mysqli_close($conn);
    header("Location: adminPublicacoes.php");
    exit;
}

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM publicacoes WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        header("Location: adminPublicacoes.php");
        exit;
    } else {
        $erro = "Não foi possível excluir a publicação. Tente novamente.";
    }

    mysqli_stmt_close($stmt);
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

    <title>Exclusão de Publicação - Florescer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="pagina-exclusao-admin">

    <nav class="navbar navbar-expand-lg navbar-florescer shadow-sm">
        <div class="container">

            <a class="navbar-brand marca-navbar" href="admin.php">
                <span class="marca-icone">🌸</span>
                Florescer | Administração
            </a>

            <div class="d-flex align-items-center gap-2">
                <span class="admin-identificacao">Administrador</span>
                <a href="index.php" class="btn btn-sair">Sair</a>
            </div>

        </div>
    </nav>

    <main class="container py-5">

        <div class="card caixa-formulario shadow-sm">

            <div class="card-body text-center p-4 p-md-5">

                <div class="icone">🗑️</div>

                <h2 class="titulo">Exclusão de Publicação</h2>

                <p class="text-muted">
                    Tem certeza que deseja excluir esta publicação?
                </p>

                <?php if ($erro !== ""): ?>
                    <div class="alert alert-danger">
                        <?= e($erro) ?>
                    </div>
                <?php endif; ?>

                <div class="card border-0 bg-light p-3 my-4">

                    <h5 class="mb-1">
                        🌺 <?= e($flor["nome_flor"]) ?>
                    </h5>

                    <p class="mb-0 small text-muted">
                        Categoria: <?= e($flor["categoria"]) ?>
                    </p>

                </div>

                <p class="text-danger small">
                    Esta ação não poderá ser desfeita.
                </p>

                <div class="d-flex justify-content-center flex-wrap gap-2 mt-4">

                    <button
                        class="btn btn-outline-danger"
                        type="button"
                        data-bs-toggle="modal"
                        data-bs-target="#confirmarExclusao">
                        Excluir publicação
                    </button>

                    <a
                        href="adminVisualizarPublicacao.php?id=<?= $id ?>"
                        class="btn btn-outline-secondary">
                        Cancelar
                    </a>

                </div>

            </div>
        </div>

        <div class="modal fade" id="confirmarExclusao" tabindex="-1"
            aria-labelledby="tituloConfirmacao" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title titulo" id="tituloConfirmacao">
                            Confirmar exclusão
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Fechar">
                        </button>
                    </div>

                    <div class="modal-body">
                        Deseja realmente excluir a publicação
                        “<?= e($flor["nome_flor"]) ?>”?
                    </div>

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">
                            Voltar
                        </button>

                        <form method="POST">
                            <button type="submit" class="btn btn-rosa">
                                Confirmar exclusão
                            </button>
                        </form>

                    </div>

                </div>
            </div>
        </div>

    </main>

    <footer class="footer-florescer text-center py-4">
        <small>Florescer © 2026</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
