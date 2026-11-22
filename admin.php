<?php
require_once "verificarAdmin.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Painel do Administrador - Florescer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="pagina-admin">

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

    <main class="admin-conteudo">

        <div class="container">

            <header class="admin-cabecalho text-center">

                <div class="admin-icone-principal">
                    🌷
                </div>

                <h1 class="titulo">
                    Painel do Administrador
                </h1>

                <p>
                    Bem-vindo ao espaço de gerenciamento do Florescer.
                    Aqui você pode administrar as publicações e os usuários da plataforma
                </p>

                <div class="principal-divisor">
                    <span></span>
                    ❀
                    <span></span>
                </div>

            </header>

            <div class="row g-4 justify-content-center">

                <div class="col-md-6 col-lg-5">

                    <div class="card card-menu-admin h-100">

                        <div class="card-body text-center">

                            <div class="icone-admin">
                                📝
                            </div>

                            <h5>
                                Gerenciamento de Publicações
                            </h5>

                            <p>
                                Visualize as publicações cadastradas e
                                edite ou exclua conteúdos incorretos.
                            </p>

                            <a href="adminPublicacoes.php" class="btn btn-rosa">
                                Gerenciar publicações
                            </a>

                        </div>

                    </div>

                </div>

                <div class="col-md-6 col-lg-5">

                    <div class="card card-menu-admin h-100">

                        <div class="card-body text-center">

                            <div class="icone-admin">
                                👥
                            </div>

                            <h5>
                                Gerenciamento de Usuários
                            </h5>

                            <p>
                                Consulte os usuários registrados
                                na plataforma
                            </p>

                            <a href="adminUsuarios.php" class="btn btn-rosa">
                                Gerenciar usuários
                            </a>

                        </div>

                    </div>

                </div>

            </div>

            <div class="text-center admin-voltar">

                <a href="telaPrincipal.php" class="btn btn-voltar-admin">
                    ← Voltar ao Florescer
                </a>

            </div>

        </div>

    </main>

    <footer class="footer-florescer text-center py-4">

        <small>
            Florescer © 2026
        </small>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
