<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$logado = isset($_SESSION["usuario_id"]);

$administrador = $logado &&
    isset($_SESSION["tipo"]) &&
    $_SESSION["tipo"] === "administrador";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Florescer - Menu Principal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="pagina-principal">

    <nav class="navbar navbar-expand-lg navbar-florescer shadow-sm">
        <div class="container">

            <a class="navbar-brand marca-navbar" href="telaPrincipal.php">
                <span class="marca-icone">❀</span>
                Florescer
            </a>

            <div class="d-flex align-items-center gap-2 flex-wrap">

                <?php if ($logado): ?>

                    <span class="usuario-navbar">
                        Olá, <?= htmlspecialchars($_SESSION["nome_usuario"]) ?>!
                    </span>

                    <?php if ($administrador): ?>

                        <a href="admin.php" class="btn btn-navbar">
                            Painel Administrativo
                        </a>

                    <?php endif; ?>

                    <a href="sair.php" class="btn btn-navbar">
                        Sair
                    </a>

                <?php else: ?>

                    <span class="usuario-navbar">
                        Acesso de visitante
                    </span>

                    <a href="index.php" class="btn btn-navbar">
                        Entrar
                    </a>

                <?php endif; ?>

            </div>
        </div>
    </nav>

    <main class="principal-conteudo">

        <div class="container">

            <header class="principal-cabecalho text-center">

                <div class="principal-flor">✿</div>

                <h1>Bem-vindo ao Florescer</h1>

                <p class="principal-subtitulo">
                    Um espaço dedicado à beleza e ao conhecimento das flores
                </p>

                <?php if (!$logado): ?>
                    <div class="aviso-visitante">
                        <span>🌷</span>
                        Você está acessando como visitante
                        Crie uma conta para aproveitar todas as funcionalidades!
                    </div>
                <?php endif; ?>

                <div class="principal-divisor">
                    <span></span>
                    ❀
                    <span></span>
                </div>

            </header>

            <div class="row justify-content-center g-4 mb-4">

                <div class="col-md-5 col-lg-4">
                    <div class="card card-menu card-florescer h-100">
                        <div class="card-body text-center">

                            <div class="icone">🌼</div>

                            <h5>Catálogo</h5>

                            <p>
                                Explore diferentes espécies e descubra suas características
                            </p>

                            <a href="catalogo.php" class="btn btn-rosa btn-card">
                                Explorar catálogo
                                <span>→</span>
                            </a>

                        </div>
                    </div>
                </div>

                <div class="col-md-5 col-lg-4">
                    <div class="card card-menu card-florescer h-100">
                        <div class="card-body text-center">

                            <div class="icone">💗</div>

                            <h5>Favoritos</h5>

                            <p>
                                Guarde suas flores preferidas e encontre-as facilmente
                            </p>

                            <?php if ($logado): ?>

                                <a href="favoritos.php" class="btn btn-rosa btn-card">
                                    Ver favoritos
                                    <span>→</span>
                                </a>

                            <?php else: ?>

                                <button type="button" class="btn btn-rosa btn-card"
                                    onclick="mostrarAviso('favoritos')">
                                    Ver favoritos
                                    <span>→</span>
                                </button>

                            <?php endif; ?>

                        </div>
                    </div>
                </div>

            </div>

            <div class="row justify-content-center g-4">

                <div class="col-md-4 col-lg-3">
                    <div class="card card-menu card-florescer h-100">
                        <div class="card-body text-center">

                            <div class="icone">📝</div>

                            <h5>Minhas Publicações</h5>

                            <p>
                                Consulte e organize as flores que você cadastrou
                            </p>

                            <?php if ($logado): ?>

                                <a href="minhasPublicacoes.php" class="btn btn-rosa btn-card">
                                    Minhas flores
                                    <span>→</span>
                                </a>

                            <?php else: ?>

                                <button type="button" class="btn btn-rosa btn-card"
                                    onclick="mostrarAviso('publicações')">
                                    Minhas flores
                                    <span>→</span>
                                </button>

                            <?php endif; ?>

                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3">
                    <div class="card card-menu card-florescer h-100">
                        <div class="card-body text-center">

                            <div class="icone">🌱</div>

                            <h5>Nova Flor</h5>

                            <p>
                                Compartilhe uma nova espécie com a comunidade
                            </p>

                            <?php if ($logado): ?>

                                <a href="cadastroFlor.php" class="btn btn-rosa btn-card">
                                    Cadastrar flor
                                    <span>→</span>
                                </a>

                            <?php else: ?>

                                <button type="button" class="btn btn-rosa btn-card"
                                    onclick="mostrarAviso('cadastro de flores')">
                                    Cadastrar flor
                                    <span>→</span>
                                </button>

                            <?php endif; ?>

                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3">
                    <div class="card card-menu card-florescer h-100">
                        <div class="card-body text-center">

                            <div class="icone">👤</div>

                            <h5>Meu Perfil</h5>

                            <p>
                                Gerencie suas informações e personalize sua conta
                            </p>

                            <?php if ($logado): ?>

                                <a href="personalizarConta.php" class="btn btn-rosa btn-card">
                                    Meu perfil
                                    <span>→</span>
                                </a>

                            <?php else: ?>

                                <button type="button" class="btn btn-rosa btn-card"
                                    onclick="mostrarAviso('perfil')">
                                    Meu perfil
                                    <span>→</span>
                                </button>

                            <?php endif; ?>

                        </div>
                    </div>
                </div>

            </div>

            <div class="principal-frase text-center">
                <span>✿</span>
                Cultive conhecimento, compartilhe descobertas e deixe florescer
                <span>✿</span>
            </div>

        </div>

    </main>

    <?php if (!$logado): ?>

        <div class="modal fade" id="modalCadastro" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content modal-florescer">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            <span>❀</span> Faça parte do Florescer!
                        </h5>

                        <button type="button" class="btn-close"
                            data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>

                    <div class="modal-body text-center py-4">

                        <div class="modal-flor">🌸</div>

                        <p id="mensagemCadastro" class="mb-0">
                            Você precisa ter uma conta para utilizar esta funcionalidade
                            Cadastre-se gratuitamente!
                        </p>

                    </div>

                    <div class="modal-footer justify-content-center">

                        <a href="cadastroUsuario.php" class="btn btn-rosa">
                            Criar conta
                        </a>

                        <a href="index.php" class="btn btn-modal-secundario">
                            Fazer login
                        </a>

                    </div>

                </div>
            </div>
        </div>

    <?php endif; ?>

    <footer class="footer-florescer text-center py-4">

        <div class="footer-flor">❀</div>

        <small>
            Florescer © 2026
        </small>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <?php if (!$logado): ?>

        <script>
            function mostrarAviso(funcionalidade) {

                const mensagem = document.getElementById("mensagemCadastro");

                mensagem.textContent =
                    "Você não possui uma conta para acessar " + funcionalidade +
                    ". Cadastre-se gratuitamente ou faça login para utilizar esta funcionalidade!";

                const modal = new bootstrap.Modal(
                    document.getElementById("modalCadastro")
                );

                modal.show();
            }
        </script>

    <?php endif; ?>

</body>
</html>
