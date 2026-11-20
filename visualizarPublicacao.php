<?php
require_once "config/banco.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: minhasPublicacoes.php");
    exit;
}

$sql = "SELECT * FROM publicacoes WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) === 0) {
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

   header("Location: minhasPublicacoes.php");
    exit;
}

$flor = mysqli_fetch_assoc($resultado);

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($flor["nome_flor"]) ?> - Florescer</title>

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

            <a href="minhasPublicacoes.php" class="btn btn-navbar">
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

            <section class="visualizar-card">

                <h2 class="visualizar-nome">
                    <?= htmlspecialchars($flor["nome_flor"]) ?>
                </h2>

                <?php if (!empty($flor["imagem"]) && file_exists(__DIR__ . "/" . $flor["imagem"])): ?>

                    <div class="visualizar-imagem-container">

                        <img
                            src="<?= htmlspecialchars($flor["imagem"]) ?>"
                            alt="<?= htmlspecialchars($flor["nome_flor"]) ?>"
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

                            <p>
                                <?= htmlspecialchars($flor["nome_cientifico"] ?? "") ?>
                            </p>
                        </div>

                    </div>

                    <div class="visualizar-campo">

                        <span class="visualizar-icone">🌷</span>

                        <div>
                            <strong>Categoria</strong>

                            <p>
                                <?= htmlspecialchars($flor["categoria"] ?? "") ?>
                            </p>
                        </div>

                    </div>

                    <div class="visualizar-campo">

                        <span class="visualizar-icone">🎨</span>

                        <div>
                            <strong>Cor</strong>

                            <p>
                                <?= htmlspecialchars($flor["cor"] ?? "") ?>
                            </p>
                        </div>

                    </div>

                    <div class="visualizar-campo visualizar-descricao">

                        <span class="visualizar-icone">📝</span>

                        <div>
                            <strong>Descrição</strong>

                            <p>
                                <?= nl2br(htmlspecialchars($flor["descricao"] ?? "")) ?>
                            </p>
                        </div>

                    </div>

                </div>

                <div class="visualizar-acoes text-center">

                    <a href="minhasPublicacoes.php" class="btn btn-rosa">
                         ← Voltar às minhas publicações
                    </a>

                </div>

            </section>

        </div>

    </main>

    <footer class="footer-florescer text-center py-4">

        <div class="footer-flor">❀</div>

        <small>Florescer © 2026</small>

    </footer>

</body>
</html>
