<?php
require_once "verificarAdmin.php";
require_once "config/banco.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: adminPublicacoes.php");
    exit;
}

$id = (int) $_GET["id"];

$sql = "SELECT * FROM publicacoes WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
$flor = mysqli_fetch_assoc($resultado);

mysqli_stmt_close($stmt);

if (!$flor) {
    mysqli_close($conn);
    header("Location: adminPublicacoes.php");
    exit;
}

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome_flor = trim($_POST["nomeFlor"] ?? "");
    $nome_cientifico = trim($_POST["nomeCientifico"] ?? "");
    $categoria = trim($_POST["categoria"] ?? "");
    $cor = trim($_POST["corFlor"] ?? "");
    $descricao = trim($_POST["descricaoFlor"] ?? "");

    if (
        $nome_flor === "" ||
        $nome_cientifico === "" ||
        $categoria === "" ||
        $cor === "" ||
        $descricao === ""
    ) {
        $erro = "Preencha todos os campos.";
    } else {

        $sql = "UPDATE publicacoes
                SET nome_flor = ?,
                    nome_cientifico = ?,
                    categoria = ?,
                    cor = ?,
                    descricao = ?
                WHERE id = ?";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "sssssi",
            $nome_flor,
            $nome_cientifico,
            $categoria,
            $cor,
            $descricao,
            $id
        );

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);

            header("Location: adminVisualizarPublicacao.php?id=" . $id);
            exit;
        } else {
            $erro = "Não foi possível salvar as alterações.";
        }

        mysqli_stmt_close($stmt);
    }

    // Atualiza os dados exibidos no formulário
    $flor["nome_flor"] = $nome_flor;
    $flor["nome_cientifico"] = $nome_cientifico;
    $flor["categoria"] = $categoria;
    $flor["cor"] = $cor;
    $flor["descricao"] = $descricao;
}

function e($valor) {
    return htmlspecialchars($valor ?? "", ENT_QUOTES, "UTF-8");
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edição de Publicação - Florescer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="pagina-edicao-admin">

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

    <main class="edicao-conteudo">

        <div class="container">

            <div class="card caixa-edicao-admin">

                <div class="card-body p-4 p-md-5">

                    <div class="edicao-cabecalho">

                        <div>
                            <div class="edicao-icone">✏️</div>
                            <h2 class="titulo">Edição de Publicação</h2>
                            <p>Atualize as informações da publicação.</p>
                        </div>

                        <a href="adminVisualizarPublicacao.php?id=<?= $id ?>" class="btn btn-voltar-admin">
                            Voltar
                        </a>

                    </div>

                    <div class="alerta-edicao">
                        <span>🌷</span>
                        Altere somente as informações que precisam de correção.
                    </div>

                    <?php if ($erro !== ""): ?>
                        <div class="alert alert-danger">
                            <?= e($erro) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label for="nomeFlor" class="form-label">Nome da flor</label>
                            <input
                                type="text"
                                name="nomeFlor"
                                id="nomeFlor"
                                class="form-control"
                                value="<?= e($flor["nome_flor"]) ?>"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="nomeCientifico" class="form-label">Nome científico</label>
                            <input
                                type="text"
                                name="nomeCientifico"
                                id="nomeCientifico"
                                class="form-control"
                                value="<?= e($flor["nome_cientifico"]) ?>"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoria</label>
                            <select name="categoria" id="categoria" class="form-select" required>

                                <?php
                                $categorias = ["Ornamental", "Medicinal", "Tropical", "Silvestre", "Outra"];
                                ?>

                                <?php foreach ($categorias as $categoria): ?>
                                    <option
                                        value="<?= e($categoria) ?>"
                                        <?= $flor["categoria"] === $categoria ? "selected" : "" ?>>
                                        <?= e($categoria) ?>
                                    </option>
                                <?php endforeach; ?>

                                <?php if (!in_array($flor["categoria"], $categorias)): ?>
                                    <option value="<?= e($flor["categoria"]) ?>" selected>
                                        <?= e($flor["categoria"]) ?>
                                    </option>
                                <?php endif; ?>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="corFlor" class="form-label">Cor predominante</label>
                            <input
                                type="text"
                                name="corFlor"
                                id="corFlor"
                                class="form-control"
                                value="<?= e($flor["cor"]) ?>"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="descricaoFlor" class="form-label">Descrição</label>
                            <textarea
                                name="descricaoFlor"
                                id="descricaoFlor"
                                class="form-control"
                                rows="5"
                                required><?= e($flor["descricao"]) ?></textarea>
                        </div>

                        <div class="d-flex flex-wrap gap-2">

                            <button type="submit" class="btn btn-rosa">
                                Salvar alterações
                            </button>

                            <a href="adminVisualizarPublicacao.php?id=<?= $id ?>" class="btn btn-cancelar-edicao">
                                Cancelar
                            </a>

                        </div>

                    </form>

                </div>
            </div>

        </div>

    </main>

    <footer class="footer-florescer text-center">
        <span>🌸</span>
        <small>Florescer © 2026</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
