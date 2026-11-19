<?php
require_once "verificarLogin.php";
require_once "config/banco.php";

$usuario_id = $_SESSION["usuario_id"];

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: minhasPublicacoes.php");
    exit;
}

$sql = "SELECT * FROM publicacoes WHERE id = ? AND usuario_id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "ii", $id, $usuario_id);
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

<body>

    <nav class="navbar navbar-expand-lg navbar-dark cor-principal shadow-sm">
        <div class="container">

            <a class="navbar-brand fw-bold" href="telaPrincipal.php">
                🌸 Florescer
            </a>

            <a href="minhasPublicacoes.php" class="btn btn-light btn-sm">
                Voltar
            </a>

        </div>
    </nav>

    <main class="container py-5">

        <div class="card card-menu mx-auto" style="max-width: 850px;">

            <div class="card-body p-4 p-md-5">

                <h2 class="titulo text-center mb-4">
                    <?= htmlspecialchars($flor["nome_flor"]) ?>
                </h2>

                <?php if (!empty($flor["imagem"]) && file_exists(__DIR__ . "/" . $flor["imagem"])): ?>

                    <div class="text-center mb-4">
                        <img
                            src="<?= htmlspecialchars($flor["imagem"]) ?>"
                            alt="<?= htmlspecialchars($flor["nome_flor"]) ?>"
                            class="img-fluid rounded"
                            style="max-height: 400px; object-fit: cover;">
                    </div>

                <?php else: ?>

                    <div class="text-center mb-4 py-5 bg-light rounded">
                        <span style="font-size: 70px;">🌺</span>
                    </div>

                <?php endif; ?>

                <div class="mb-3">
                    <strong>Nome científico:</strong>
                    <p><?= htmlspecialchars($flor["nome_cientifico"]) ?></p>
                </div>

                <div class="mb-3">
                    <strong>Categoria:</strong>
                    <p><?= htmlspecialchars($flor["categoria"]) ?></p>
                </div>

                <div class="mb-3">
                    <strong>Cor:</strong>
                    <p><?= htmlspecialchars($flor["cor"]) ?></p>
                </div>

                <div class="mb-4">
                    <strong>Descrição:</strong>
                    <p><?= nl2br(htmlspecialchars($flor["descricao"])) ?></p>
                </div>

                <div class="text-center">
                    <a href="minhasPublicacoes.php" class="btn btn-rosa">
                        Voltar às minhas publicações
                    </a>
                </div>

            </div>

        </div>

    </main>

    <footer class="text-center py-4 mt-5">
        <small class="text-muted">
            Projeto Florescer © 2026
        </small>
    </footer>

</body>
</html>
