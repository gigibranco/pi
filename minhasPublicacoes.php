<?php
require_once "verificarLogin.php";
require_once "config/banco.php";

$usuario_id = $_SESSION["usuario_id"];

$sql = "SELECT * FROM publicacoes WHERE usuario_id = ? ORDER BY data_cadastro DESC";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $usuario_id);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Minhas Publicações - Florescer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="pagina-minhas-publicacoes">

    <nav class="navbar navbar-expand-lg navbar-florescer shadow-sm">
        <div class="container">

            <a class="navbar-brand marca-navbar" href="telaPrincipal.php">
                <span class="marca-icone">❀</span>
                Florescer
            </a>

            <a href="telaPrincipal.php" class="btn btn-navbar">
                ← Voltar
            </a>

        </div>
    </nav>

    <main class="minhas-publicacoes-conteudo">

        <div class="container py-5">

            <header class="minhas-publicacoes-cabecalho text-center">

                <div class="minhas-publicacoes-icone">🌷</div>

                <h1>Minhas Publicações</h1>

                <p>
                    Todas as flores que você compartilhou com a comunidade
                </p>

                <div class="principal-divisor">
                    <span></span>
                    ❀
                    <span></span>
                </div>

            </header>

            <div class="d-flex justify-content-end mb-4">
                <a href="cadastroFlor.php" class="btn btn-rosa btn-nova-publicacao">
                    + Cadastrar nova flor
                </a>
            </div>

            <div class="row g-4">

                <?php if (mysqli_num_rows($resultado) > 0): ?>

                    <?php while ($flor = mysqli_fetch_assoc($resultado)): ?>

                        <div class="col-md-6 col-lg-4">

                            <div class="card card-menu card-minhas-publicacoes h-100">

                                <?php if (
                                    !empty($flor["imagem"]) &&
                                    file_exists(__DIR__ . "/" . $flor["imagem"])
                                ): ?>

                                    <div class="minhas-publicacoes-imagem">
                                        <img
                                            src="<?= htmlspecialchars($flor["imagem"]) ?>"
                                            alt="<?= htmlspecialchars($flor["nome_flor"]) ?>">
                                    </div>

                                <?php else: ?>

                                    <div class="minhas-publicacoes-sem-imagem">
                                        🌸
                                    </div>

                                <?php endif; ?>

                                <div class="card-body">

                                    <span class="publicacao-etiqueta">
                                        Minha publicação
                                    </span>

                                    <h5 class="mt-3">
                                        <?= htmlspecialchars($flor["nome_flor"]) ?>
                                    </h5>

                                    <p class="mb-2">
                                        <strong>Categoria:</strong>
                                        <?= htmlspecialchars($flor["categoria"]) ?>
                                    </p>

                                    <p class="text-muted small">
                                        Compartilhada por você ✿
                                    </p>

                                    <div class="d-flex flex-wrap gap-2 mt-3">

                                        <a
                                            href="visualizarPublicacao.php?id=<?= (int)$flor["id"] ?>"
                                            class="btn btn-rosa flex-grow-1">
                                            Ver
                                        </a>

                                        <a
                                            href="editarPublicacao.php?id=<?= (int)$flor["id"] ?>"
                                            class="btn btn-editar-publicacao">
                                            Editar
                                        </a>

                                        <a
                                            href="excluirPublicacao.php?id=<?= (int)$flor["id"] ?>"
                                            class="btn btn-excluir-publicacao"
                                            onclick="return confirm('Deseja realmente excluir esta publicação?');">
                                            Excluir
                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    <?php endwhile; ?>

                <?php else: ?>

                    <div class="col-12">

                        <div class="minhas-publicacoes-vazio text-center">

                            <div class="vazio-icone">🌼</div>

                            <h3>Suas descobertas começam aqui!</h3>

                            <p>
                                Você ainda não possui publicações.
                                Cadastre sua primeira flor e compartilhe
                                suas descobertas com a comunidade
                            </p>

                            <a href="cadastroFlor.php" class="btn btn-rosa">
                                Cadastrar minha primeira flor
                            </a>

                        </div>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </main>

    <footer class="footer-florescer text-center py-4">

        <div class="footer-flor">❀</div>

        <small>
            Florescer © 2026
        </small>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
