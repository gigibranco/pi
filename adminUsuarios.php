<?php
require_once "verificarAdmin.php";
require_once "config/banco.php";

$sql = "SELECT id, nome_completo, nome_usuario, email, tipo
        FROM usuarios
        ORDER BY nome_completo ASC";

$resultado = mysqli_query($conn, $sql);

function e($valor) {
    return htmlspecialchars($valor ?? "", ENT_QUOTES, "UTF-8");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gerenciar Usuários - Florescer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="pagina-admin-usuarios">

    <nav class="navbar navbar-expand-lg navbar-florescer shadow-sm">
        <div class="container">

            <a class="navbar-brand marca-navbar" href="admin.php">
                <span class="marca-icone">🌸</span>
                Florescer | Administração
            </a>

            <div class="d-flex align-items-center gap-2">
                <span class="admin-identificacao">Administrador</span>
                <a href="index.php" class="btn btn-sair">Sair</a>
            </div>

        </div>
    </nav>

    <main class="usuarios-conteudo">

        <div class="usuarios-cabecalho">
            <h1>Gerenciar Usuários</h1>
            <p>Visualize os usuários cadastrados no Florescer</p>
        </div>

        <section class="pesquisa-usuarios-card">

            <input
                type="text"
                id="pesquisaUsuarios"
                class="form-control"
                placeholder="Pesquisar usuário..."
            >

        </section>

        <section class="tabela-usuarios-card">

            <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>

                <div class="table-responsive">

                    <table class="table align-middle" id="tabelaUsuarios">

                        <thead>
                            <tr>
                                <th>Nome completo</th>
                                <th>Nome de usuário</th>
                                <th>E-mail</th>
                                <th>Tipo de conta</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php while ($usuario = mysqli_fetch_assoc($resultado)): ?>

                                <tr>

                                    <td>
                                        <span class="usuario-nome">
                                            <?= e($usuario["nome_completo"]) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <span class="usuario-apelido">
                                            @<?= e($usuario["nome_usuario"]) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <span class="usuario-email">
                                            <?= e($usuario["email"]) ?>
                                        </span>
                                    </td>

                                    <td>

                                        <?php if ($usuario["tipo"] === "administrador"): ?>

                                            <span class="tipo-administrador">
                                                Administrador
                                            </span>

                                        <?php else: ?>

                                            <span class="tipo-usuario">
                                                Usuário
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                </tr>

                            <?php endwhile; ?>

                        </tbody>

                    </table>

                </div>

                <p id="nenhumResultado" class="sem-usuario-msg" style="display: none;">
                    Nenhum usuário encontrado na pesquisa.
                </p>

            <?php else: ?>

                <p class="sem-usuario-msg">
                    Ainda não existem usuários cadastrados.
                </p>

            <?php endif; ?>

        </section>

        <div class="text-center mt-4">

            <a href="admin.php" class="btn btn-navbar">
                ← Voltar ao painel
            </a>

        </div>

    </main>

    <footer class="footer-florescer text-center py-4">
        <small>Florescer © 2026</small>
    </footer>

    <script>
        const pesquisa = document.getElementById("pesquisaUsuarios");
        const tabela = document.getElementById("tabelaUsuarios");
        const mensagem = document.getElementById("nenhumResultado");

        if (pesquisa && tabela) {

            pesquisa.addEventListener("input", function () {

                const termo = this.value.toLowerCase();
                const linhas = tabela.querySelectorAll("tbody tr");

                let encontrados = 0;

                linhas.forEach(function (linha) {

                    const conteudo = linha.textContent.toLowerCase();
                    const corresponde = conteudo.includes(termo);

                    linha.style.display = corresponde ? "" : "none";

                    if (corresponde) {
                        encontrados++;
                    }

                });

                if (mensagem) {
                    mensagem.style.display = encontrados === 0 ? "block" : "none";
                }

            });

        }
    </script>

</body>
</html>

<?php
if ($resultado) {
    mysqli_free_result($resultado);
}

mysqli_close($conn);
?>
