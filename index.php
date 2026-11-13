
<?php
$mensagemErro = "";

if (isset($_GET["erro"])) {
    if ($_GET["erro"] === "login") {
        $mensagemErro = "Você precisa fazer login para acessar esta página.";
    } elseif ($_GET["erro"] === "credenciais") {
        $mensagemErro = "Usuário ou senha incorretos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Florescer</title>
</head>

<body>
    <main>
        <div class="container vh-100 d-flex justify-content-center align-items-center">
            <div class="card shadow caixa-login">
                <div class="card-body p-5">
                    <h2 class="text-center titulo mb-4">
                        🌸 Florescer
                    </h2>

                    <?php if ($mensagemErro !== ""): ?>
                        <div class="alert alert-danger text-center" role="alert">
                            <?= htmlspecialchars($mensagemErro) ?>
                        </div>
                    <?php endif; ?>

                    <form action="processarLogin.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Usuário ou e-mail</label>
                            <input type="text" name="usuario" class="form-control"
                                placeholder="Digite seu usuário ou e-mail" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Senha</label>
                            <input type="password" name="senha" class="form-control"
                                placeholder="Digite sua senha" required>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-rosa">
                                Entrar
                            </button>

                            <a href="telaPrincipal.php" class="btn btn-outline-secondary">
                                Acessar sem login
                            </a>
                        </div>

                        <div class="text-center mt-3">
                            <a href="recuperarSenha.html" class="link-rosa">
                                Esqueceu sua senha?
                            </a>
                        </div>

                        <div class="text-center mt-2">
                            <small>
                                Não possui uma conta?
                                <a href="cadastroUsuario.php" class="link-rosa">
                                    Clique aqui!
                                </a>
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-center py-4 mt-5">
        <svg width="28" height="28" viewBox="0 0 64 64" class="mb-2" style="fill:#E86A92;">
            <circle cx="32" cy="18" r="10" />
            <circle cx="32" cy="46" r="10" />
            <circle cx="18" cy="32" r="10" />
            <circle cx="46" cy="32" r="10" />
            <circle cx="32" cy="32" r="9" style="fill:#FFDCE8;" />
        </svg>
        <br>
        <small class="text-muted">Projeto Florescer © 2026</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
