<?php
require_once "config/banco.php";

$sql = "SELECT * FROM publicacoes ORDER BY data_cadastro DESC";
$resultado = mysqli_query($conn, $sql);

if (!$resultado) {
    die("Erro ao carregar o catálogo.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Catálogo - Florescer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="pagina-catalogo">

    <nav class="navbar navbar-expand-lg navbar-florescer shadow-sm">
        <div class="container">

            <a class="navbar-brand marca-navbar" href="telaPrincipal.php">
                <span class="marca-icone">❀</span>
                Florescer
            </a>

            <a href="telaPrincipal.php" class="btn btn-navbar">
                Voltar
            </a>

        </div>
    </nav>

    <main class="container py-5">

        <div class="text-center mb-5">
            <h1 class="titulo">Catálogo de Flores 🌸</h1>

            <p class="text-muted">
                Conheça diferentes flores e descubra suas características.
            </p>
        </div>

        <div class="row g-4">

            <!-- GIRASSOL FIXO DE EXEMPLO -->

            <div class="col-md-6 col-lg-4">

                <div class="card card-catalogo h-100">

                    <img
                        src="imagens/girassol.webp"
                        class="card-img-top"
                        alt="Girassol">

                    <div class="card-body">

                        <h5 class="card-title">Girassol</h5>

                        <p class="text-muted">
                            Helianthus annuus
                        </p>

                        <a href="detalhesGirassol.html" class="btn btn-rosa">
                            Conhecer flor
                        </a>

                    </div>

                </div>

            </div>


            <!-- FLORES CADASTRADAS PELOS USUÁRIOS -->

            <?php while ($flor = mysqli_fetch_assoc($resultado)): ?>

                <div class="col-md-6 col-lg-4">

                    <div class="card card-catalogo h-100">

                        <?php if (
                            !empty($flor["imagem"]) &&
                            file_exists(__DIR__ . "/" . $flor["imagem"])
                        ): ?>

                            <img
                                src="<?= htmlspecialchars($flor["imagem"]) ?>"
                                class="card-img-top"
                                alt="<?= htmlspecialchars($flor["nome_flor"]) ?>"
                                style="height: 220px; object-fit: cover;">

                        <?php else: ?>

                            <div class="bg-light text-center py-5">
                                <span style="font-size: 60px;">🌺</span>
                            </div>

                        <?php endif; ?>

                        <div class="card-body">

                            <h5 class="card-title">
                                <?= htmlspecialchars($flor["nome_flor"]) ?>
                            </h5>

                            <p class="text-muted">
                                <?= htmlspecialchars($flor["nome_cientifico"]) ?>
                            </p>

                            <p>
                                <strong>Categoria:</strong>
                                <?= htmlspecialchars($flor["categoria"]) ?>
                            </p>

                            <a
                                href="visualizarPublicacao.php?id=<?= (int)$flor["id"] ?>"
                                class="btn btn-rosa">
                                Conhecer flor
                            </a>

                        </div>

                    </div>

                </div>

            <?php endwhile; ?>

        </div>

    </main>

    <footer class="footer-florescer text-center py-4">

        <div class="footer-flor">❀</div>

        <small>Florescer © 2026</small>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
mysqli_close($conn);
?>
