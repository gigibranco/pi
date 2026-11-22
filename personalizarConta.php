<?php
require_once "verificarLogin.php";
require_once "config/banco.php";

$usuario_id = (int) $_SESSION["usuario_id"];

$sql = "SELECT nome_completo, nome_usuario, email, foto_perfil
        FROM usuarios
        WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $usuario_id);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
$usuario = mysqli_fetch_assoc($resultado);

if (!$usuario) {
    header("Location: index.php");
    exit;
}

$foto = $usuario["foto_perfil"];

$fotoExiste = !empty($foto) && file_exists(__DIR__ . "/" . $foto);

function e($valor) {
    return htmlspecialchars($valor ?? "", ENT_QUOTES, "UTF-8");
}
?>

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
                    Cuide do seu cantinho e mantenha suas informações atualizadas
                </p>

                <div class="principal-divisor">
                    <span></span>
                    ❀
                    <span></span>
                </div>

            </header>

            <div class="card perfil-card mx-auto">

                <div class="card-body p-4 p-md-5">

                    <form action="salvarPerfil.php" method="POST" enctype="multipart/form-data">

                        <div class="text-center mb-4">

                            <div class="perfil-foto">

                                <?php if ($fotoExiste): ?>

                                    <img
                                        id="previewFoto"
                                        src="<?= e($foto) ?>"
                                        alt="Foto do usuário">

                                <?php else: ?>

                                    <div id="fotoPadrao" style="font-size: 65px;">
                                        🌷
                                    </div>

                                    <img
                                        id="previewFoto"
                                        src=""
                                        alt="Foto do usuário"
                                        style="display: none;">

                                <?php endif; ?>

                            </div>

                            <div class="mt-3">

                                <label for="foto_perfil" class="btn btn-alterar-foto btn-sm">
                                    Alterar foto
                                </label>

                                <input
                                    type="file"
                                    name="foto_perfil"
                                    id="foto_perfil"
                                    accept="image/jpeg,image/png,image/webp"
                                    hidden>

                            </div>

                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nome</label>

                            <input
                                type="text"
                                name="nome_completo"
                                class="form-control"
                                value="<?= e($usuario["nome_completo"]) ?>"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Usuário</label>

                            <input
                                type="text"
                                name="nome_usuario"
                                class="form-control"
                                value="<?= e($usuario["nome_usuario"]) ?>"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">E-mail</label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="<?= e($usuario["email"]) ?>"
                                required>
                        </div>

                        <div class="perfil-divisor"></div>

                        <h5 class="perfil-subtitulo">
                            Alterar senha ✿
                        </h5>

                        <div class="mb-3">
                            <label class="form-label">Nova senha</label>

                            <input
                                type="password"
                                name="nova_senha"
                                class="form-control"
                                placeholder="Digite uma nova senha">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Confirmar senha</label>

                            <input
                                type="password"
                                name="confirmar_senha"
                                class="form-control"
                                placeholder="Confirme sua nova senha">
                        </div>

                        <div class="d-grid gap-3">

                            <button type="submit" name="acao" value="salvar"
                                class="btn btn-rosa btn-perfil">
                                Salvar alterações
                            </button>

                        </div>

                    </form>

                    <form action="salvarPerfil.php" method="POST"
                        onsubmit="return confirm('Tem certeza de que deseja excluir sua conta? Essa ação não poderá ser desfeita.');">

                        <div class="d-grid mt-3">

                            <button type="submit" name="acao" value="excluir"
                                class="btn btn-excluir-conta">
                                Excluir conta
                            </button>

                        </div>

                    </form>

                </div>

            </div>

            <p class="perfil-frase text-center">
                "Floresça no seu próprio tempo" 🌸
            </p>

        </div>

    </main>

    <footer class="footer-florescer text-center py-4">

        <div class="footer-flor">❀</div>

        <small>
            Florescer © 2026
        </small>

    </footer>

    <script>

        document.getElementById("foto_perfil").addEventListener("change", function () {

            const arquivo = this.files[0];

            if (arquivo) {

                const imagem = document.getElementById("previewFoto");
                const fotoPadrao = document.getElementById("fotoPadrao");

                imagem.src = URL.createObjectURL(arquivo);
                imagem.style.display = "block";

                if (fotoPadrao) {
                    fotoPadrao.style.display = "none";
                }

            }

        });

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>