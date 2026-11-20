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
    <title>Florescer | Bem-vindo</title>
</head>

<body class="pagina-login">

    <main>
        <section class="login-page">
            <div class="login-decoracao login-decoracao-1">✿</div>
            <div class="login-decoracao login-decoracao-2">❀</div>
            <div class="login-decoracao login-decoracao-3">✧</div>

            <div class="card caixa-login login-card">
                <div class="card-body">

                    <div class="login-marca">
                        <div class="login-flor">❀</div>
                        <h1>Florescer</h1>
                        <p>Um espaço para cultivar conhecimento</p>
                    </div>

                    <div class="login-divisor">
                        <span></span>
                        <span class="login-divisor-flor">✿</span>
                        <span></span>
                    </div>

                    <h2 class="login-boas-vindas">Que bom ter você aqui!</h2>
                    <p class="login-instrucao">
                        Entre na sua conta para continuar
                    </p>

                    <?php if ($mensagemErro !== ""): ?>
                        <div class="alert alert-danger text-center login-alerta" role="alert">
                            <?= htmlspecialchars($mensagemErro) ?>
                        </div>
                    <?php endif; ?>

                    <form action="processarLogin.php" method="POST">

                        <div class="mb-3">
                            <label class="form-label">Usuário ou e-mail</label>
                            <input
                                type="text"
                                name="usuario"
                                class="form-control login-input"
                                placeholder="Digite seu usuário ou e-mail"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Senha</label>
                            <input
                                type="password"
                                name="senha"
                                class="form-control login-input"
                                placeholder="Digite sua senha"
                                required>
                        </div>

                        <div class="d-grid gap-3 mt-4">
                            <button type="submit" class="btn btn-rosa login-botao">
                                Entrar na minha conta
                            </button>

                            <a href="telaPrincipal.php" class="btn login-visitante">
                                Acessar como visitante
                            </a>
                        </div>

                        <div class="text-center mt-4">
                            <a href="recuperarSenha.html" class="link-rosa">
                                Esqueceu sua senha?
                            </a>
                        </div>

                        <div class="login-cadastro text-center mt-3">
                            <span>Não possui uma conta?</span>
                            <a href="cadastroUsuario.php" class="link-rosa">
                                Cadastre-se aqui
                            </a>
                        </div>

                    </form>
                </div>
            </div>

            <p class="login-frase">
                <span>✿</span> Cada flor tem seu tempo para florescer <span>✿</span>
            </p>
        </section>
    </main>

    <footer class="text-center py-3 login-footer">
        <small class="text-muted">Florescer © 2026</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
