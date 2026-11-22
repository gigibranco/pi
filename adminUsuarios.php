<?php
require_once "verificarAdmin.php";
require_once "config/banco.php";

// Excluir usuário
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["excluir_usuario"])) {

    $id_usuario = filter_input(INPUT_POST, "id_usuario", FILTER_VALIDATE_INT);

    if (!$id_usuario || $id_usuario === (int) $_SESSION["usuario_id"]) {
        header("Location: adminUsuarios.php?erro=exclusao");
        exit;
    }

    $sqlFoto = "SELECT foto_perfil FROM usuarios WHERE id = ?";
    $stmtFoto = mysqli_prepare($conn, $sqlFoto);
    mysqli_stmt_bind_param($stmtFoto, "i", $id_usuario);
    mysqli_stmt_execute($stmtFoto);

    $resultadoFoto = mysqli_stmt_get_result($stmtFoto);
    $usuarioFoto = mysqli_fetch_assoc($resultadoFoto);

    mysqli_stmt_close($stmtFoto);

    if (!$usuarioFoto) {
        header("Location: adminUsuarios.php?erro=nao_encontrado");
        exit;
    }
    $sqlExcluir = "DELETE FROM usuarios WHERE id = ?";
    $stmtExcluir = mysqli_prepare($conn, $sqlExcluir);
    mysqli_stmt_bind_param($stmtExcluir, "i", $id_usuario);

    if (mysqli_stmt_execute($stmtExcluir)) {

        $foto = $usuarioFoto["foto_perfil"];

        if (
            !empty($foto) &&
            strpos($foto, "uploads/perfis/") === 0 &&
            file_exists(__DIR__ . "/" . $foto)
        ) {
            unlink(__DIR__ . "/" . $foto);
        }

        mysqli_stmt_close($stmtExcluir);

        header("Location: adminUsuarios.php?sucesso=exclusao");
        exit;

    } else {
        mysqli_stmt_close($stmtExcluir);
        header("Location: adminUsuarios.php?erro=exclusao");
        exit;
    }
}

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

    <style>
        .usuarios-conteudo {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .tabela-usuarios-card {
            width: 100%;
            max-width: 100%;
            overflow: hidden;
        }

        .tabela-usuarios-card .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        #tabelaUsuarios {
            width: 100%;
            table-layout: fixed;
            margin-bottom: 0;
        }

        #tabelaUsuarios th,
        #tabelaUsuarios td {
            padding: 14px 10px;
            overflow-wrap: anywhere;
            vertical-align: middle;
        }

        #tabelaUsuarios th:nth-child(1),
        #tabelaUsuarios td:nth-child(1) {
            width: 22%;
        }

        #tabelaUsuarios th:nth-child(2),
        #tabelaUsuarios td:nth-child(2) {
            width: 18%;
        }

        #tabelaUsuarios th:nth-child(3),
        #tabelaUsuarios td:nth-child(3) {
            width: 26%;
        }

        #tabelaUsuarios th:nth-child(4),
        #tabelaUsuarios td:nth-child(4) {
            width: 17%;
        }

        #tabelaUsuarios th:nth-child(5),
        #tabelaUsuarios td:nth-child(5) {
            width: 17%;
            text-align: center;
        }

        .usuario-nome,
        .usuario-apelido,
        .usuario-email {
            display: block;
            overflow-wrap: anywhere;
        }

        .btn-excluir-usuario {
            white-space: nowrap;
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            .usuarios-conteudo {
                padding: 25px 12px;
            }

            #tabelaUsuarios {
                min-width: 760px;
            }
        }
    </style>
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

        <?php if (isset($_GET["sucesso"]) && $_GET["sucesso"] === "exclusao"): ?>
            <div class="alert alert-success">
                Usuário excluído com sucesso!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET["erro"])): ?>
            <div class="alert alert-danger">
                <?php if ($_GET["erro"] === "nao_encontrado"): ?>
                    Usuário não encontrado
                <?php else: ?>
                    Não foi possível excluir esse usuário. Verifique se você não está tentando excluir sua própria conta
                <?php endif; ?>
            </div>
        <?php endif; ?>

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
                                <th>Ações</th>
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

                                    <td>

                                        <?php if ((int) $usuario["id"] !== (int) $_SESSION["usuario_id"]): ?>

                                            <form
                                                method="POST"
                                                action="adminUsuarios.php"
                                                onsubmit="return confirm('Tem certeza de que deseja excluir este usuário? Todas as publicações e os favoritos dessa conta também serão excluídos.');"
                                            >

                                                <input
                                                    type="hidden"
                                                    name="id_usuario"
                                                    value="<?= (int) $usuario["id"] ?>"
                                                >

                                                <button
                                                    type="submit"
                                                    name="excluir_usuario"
                                                    value="1"
                                                    class="btn btn-outline-danger btn-sm btn-excluir-usuario"
                                                >
                                                    Excluir
                                                </button>

                                            </form>

                                        <?php else: ?>

                                            <span class="text-muted">
                                                Você
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                </tr>

                            <?php endwhile; ?>

                        </tbody>

                    </table>

                </div>

                <p id="nenhumResultado" class="sem-usuario-msg" style="display: none;">
                    Nenhum usuário encontrado na pesquisa
                </p>

            <?php else: ?>

                <p class="sem-usuario-msg">
                    Ainda não existem usuários cadastrados
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