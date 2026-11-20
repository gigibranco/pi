
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Meu Perfil - Florescer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="pagina-perfil">

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

    <main class="perfil-conteudo">

        <div class="container py-5">

            <header class="perfil-cabecalho text-center mb-4">

                <div class="perfil-icone">🌷</div>

                <h1>Meu Perfil</h1>

                <p>
                    Cuide do seu cantinho e mantenha suas informações atualizadas.
                </p>

                <div class="principal-divisor">
                    <span></span>
                    ❀
                    <span></span>
                </div>

            </header>

            <div class="card perfil-card mx-auto">

                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">

                        <div class="perfil-foto">
                            <img
                                src="https://via.placeholder.com/120"
                                alt="Foto do usuário">
                        </div>

                        <div class="mt-3">
                            <button type="button" class="btn btn-alterar-foto btn-sm">
                                Alterar foto
                            </button>
                        </div>

                    </div>

                    <form>

                        <div class="mb-3">
                            <label class="form-label">Nome</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Nome do Usuário">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Usuário</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="usuario123">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">E-mail</label>
                            <input
                                type="email"
                                class="form-control"
                                placeholder="usuario@email.com">
                        </div>

                        <div class="perfil-divisor"></div>

                        <h5 class="perfil-subtitulo">
                            Alterar senha ✿
                        </h5>

                        <div class="mb-3">
                            <label class="form-label">Nova senha</label>
                            <input
                                type="password"
                                class="form-control"
                                placeholder="Digite uma nova senha">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Confirmar senha</label>
                            <input
                                type="password"
                                class="form-control"
                                placeholder="Confirme sua nova senha">
                        </div>

                        <div class="d-grid gap-3">

                            <button type="button" class="btn btn-rosa btn-perfil">
                                Salvar alterações
                            </button>

                            <button type="button" class="btn btn-excluir-conta">
                                Excluir conta
                            </button>

                        </div>

                    </form>

                </div>

            </div>

            <p class="perfil-frase text-center">
                "Floresça no seu próprio tempo." 🌸
            </p>

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
