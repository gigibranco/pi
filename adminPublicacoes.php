<?php
require_once "verificarAdmin.php";
require_once "config/banco.php";

$sql = "SELECT 
            publicacoes.*,
            usuarios.nome_completo,
            usuarios.nome_usuario
        FROM publicacoes
        INNER JOIN usuarios ON publicacoes.usuario_id = usuarios.id
        ORDER BY publicacoes.data_cadastro DESC";

$resultado = mysqli_query($conn, $sql);

if (!$resultado) {
    die("Erro ao buscar as publicações.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gerenciamento de Publicações - Florescer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="pagina-admin-publicacoes">

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

    <main class="admin-publicacoes-conteudo">

        <div class="container">

            <header class="admin-publicacoes-cabecalho">

                <div class="cabecalho-admin-publicacoes">

                    <div class="admin-publicacoes-icone">
                        📝
                    </div>

                    <h1 class="titulo">
                        Gerenciamento de Publicações
                    </h1>

                    <p>
                        Consulte as publicações e verifique se as informações estão corretas
                    </p>

                    <div class="principal-divisor">
                        <span></span>
                        ❀
                        <span></span>
                    </div>

                </div>

                <a href="admin.php" class="btn btn-voltar-admin">
                    ← Voltar ao painel
                </a>

            </header>

            <!-- PESQUISA -->

            <div class="card pesquisa-admin-publicacoes">

                <div class="card-body">

                    <label for="pesquisaPublicacao" class="form-label">
                        🔎 Pesquisar publicação
                    </label>

                    <input
                        id="pesquisaPublicacao"
                        type="search"
                        class="form-control"
                        placeholder="Digite o nome da flor ou do autor">

                </div>

            </div>

            <!-- LISTA DE PUBLICAÇÕES -->

            <div class="row g-4" id="listaPublicacoes">

                <?php if (mysqli_num_rows($resultado) > 0): ?>

                    <?php while ($flor = mysqli_fetch_assoc($resultado)): ?>

                        <?php
                        $id = (int) $flor["id"];
                        $nomeFlor = htmlspecialchars($flor["nome_flor"]);
                        $categoria = htmlspecialchars($flor["categoria"]);
                        $autor = htmlspecialchars($flor["nome_completo"]);
                        $usuario = htmlspecialchars($flor["nome_usuario"]);

                        $pesquisa = strtolower(
                            $flor["nome_flor"] . " " .
                            $flor["nome_completo"] . " " .
                            $flor["nome_usuario"] . " " .
                            $flor["categoria"]
                        );
                        ?>

                        <div
                            class="col-md-6 col-lg-4 item-publicacao"
                            data-pesquisa="<?= htmlspecialchars($pesquisa, ENT_QUOTES, 'UTF-8') ?>">

                            <div class="card card-publicacao-admin h-100">

                                <?php if (
                                    !empty($flor["imagem"]) &&
                                    file_exists(__DIR__ . "/" . $flor["imagem"])
                                ): ?>

                                    <img
                                        src="<?= htmlspecialchars($flor["imagem"]) ?>"
                                        class="imagem-publicacao-admin"
                                        alt="<?= $nomeFlor ?>">

                                <?php else: ?>

                                    <div class="imagem-publicacao-vazia">
                                        <span>🌺</span>
                                    </div>

                                <?php endif; ?>

                                <div class="card-body">

                                    <span class="badge etiqueta-publicacao">
                                        Publicação
                                    </span>

                                    <h5><?= $nomeFlor ?></h5>

                                    <p class="categoria-publicacao">
                                        <strong>Categoria:</strong>
                                        <?= $categoria ?>
                                    </p>

                                    <div class="autor-publicacao">

                                        <span>Publicado por:</span>

                                        <strong><?= $autor ?></strong>

                                        <small>@<?= $usuario ?></small>

                                    </div>

                                    <div class="acoes-publicacao-admin">

                                        <a
                                            href="adminVisualizarPublicacao.php?id=<?= $id ?>"
                                            class="btn btn-rosa">
                                            Visualizar
                                        </a>

                                        <a
                                            href="adminEditarPublicacao.php?id=<?= $id ?>"
                                            class="btn btn-editar-admin">
                                            Editar
                                        </a>

                                        <a
                                            href="adminExcluirPublicacao.php?id=<?= $id ?>"
                                            class="btn btn-excluir-admin"
                                            onclick="return confirm('Deseja realmente excluir esta publicação?');">
                                            Excluir
                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    <?php endwhile; ?>

                <?php else: ?>

                    <div class="col-12 text-center publicacoes-vazias">

                        <div>🌷</div>

                        <h4>Nenhuma publicação cadastrada</h4>

                        <p>
                            Quando os usuários cadastrarem flores, elas aparecerão aqui
                        </p>

                    </div>

                <?php endif; ?>

                <div id="semResultado" class="col-12 text-center text-muted d-none">
                    <p>Nenhuma publicação encontrada</p>
                </div>

            </div>

        </div>

    </main>

    <footer class="footer-florescer text-center py-4">
        <small>Florescer © 2026</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function filtrarPublicacoes() {

            const termo = document
                .getElementById('pesquisaPublicacao')
                .value
                .toLowerCase()
                .trim();

            const itens = document.querySelectorAll('.item-publicacao');

            let encontrados = 0;

            itens.forEach(function(item) {

                const corresponde = item.dataset.pesquisa.includes(termo);

                item.classList.toggle('d-none', !corresponde);

                if (corresponde) {
                    encontrados++;
                }

            });

            const semResultado = document.getElementById('semResultado');

            if (semResultado) {
                semResultado.classList.toggle('d-none', encontrados > 0);
            }
        }

        document
            .getElementById('pesquisaPublicacao')
            .addEventListener('input', filtrarPublicacoes);
    </script>

</body>
</html>

<?php
mysqli_close($conn);
?>
