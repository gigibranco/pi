<?php
require_once "verificarLogin.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Flores Favoritas - Florescer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="pagina-favoritos">

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

    <main class="favoritos-conteudo">

        <div class="container py-5">

            <header class="favoritos-cabecalho text-center mb-5">

                <div class="favoritos-icone">♡</div>

                <h1>Minhas Flores Favoritas</h1>

                <p>
                    Um cantinho especial para guardar as flores que encantam você
                </p>

                <div class="principal-divisor">
                    <span></span>
                    ❀
                    <span></span>
                </div>

            </header>

            <div class="row justify-content-center g-4">

                <div class="col-md-7 col-lg-5">

                    <div class="card card-menu card-favorito h-100">

                        <div class="favorito-imagem">
                            <img
                                src="imagens/girassol.webp"
                                alt="Girassol">
                            <span class="favorito-selo">♡ Favorita</span>
                        </div>

                        <div class="card-body text-center">

                            <h3>Girassol</h3>

                            <p class="favorito-nome-cientifico">
                                Helianthus annuus
                            </p>

                            <p class="favorito-descricao">
                                Símbolo de alegria, energia e prosperidade.
                                Uma das flores mais admiradas pela sua beleza.
                            </p>

                            <a href="detalhesGirassol.html?voltar=favoritos" class="btn btn-rosa w-100">
                                        Conhecer flor
                            </a>

                        </div>

                    </div>

                </div>

            </div>

            <p class="favoritos-frase text-center">
                "Assim como as flores, cada detalhe tem sua beleza" 🌷
            </p>

        </div>

    </main>

    <footer class="footer-florescer text-center py-4">
        <small>Florescer © 2026</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
