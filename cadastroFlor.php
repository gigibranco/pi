<?php
require_once "verificarLogin.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Flor - Florescer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="pagina-cadastro-flor">

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

    <main class="cadastro-flor-conteudo">

        <div class="container py-5">

            <div class="cadastro-flor-cabecalho text-center">
                <div class="cadastro-flor-icone">🌷</div>

                <h1>Compartilhe uma nova flor</h1>

                <p>
                    Cada flor tem uma história. Registre suas descobertas
                    e compartilhe conhecimento com a comunidade
                </p>

                <div class="principal-divisor">
                    <span></span>
                    ❀
                    <span></span>
                </div>
            </div>

            <div class="cadastro-flor-card mx-auto">

                <form action="processarFlor.php" method="POST" enctype="multipart/form-data">

                    <div class="mb-4">
                        <label class="form-label">Nome da flor</label>
                        <input type="text" name="nome_flor" class="form-control"
                            placeholder="Ex.: Rosa" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Nome científico</label>
                        <input type="text" name="nome_cientifico" class="form-control"
                            placeholder="Ex.: Rosa rubiginosa" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Categoria</label>
                        <select name="categoria" class="form-select" required>
                            <option value="" selected disabled>Selecione uma categoria...</option>
                            <option value="Ornamental">Ornamental</option>
                            <option value="Medicinal">Medicinal</option>
                            <option value="Tropical">Tropical</option>
                            <option value="Silvestre">Silvestre</option>
                            <option value="Outra">Outra</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Cor predominante</label>
                        <input type="text" name="cor" class="form-control"
                            placeholder="Ex.: Rosa, amarelo, branco..." required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="5"
                            placeholder="Conte um pouco sobre as características dessa flor..."
                            required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Imagem da flor</label>
                        <input type="file" name="imagem" class="form-control"
                            accept="image/jpeg,image/png,image/webp">
                        <small class="text-muted">
                            Formatos permitidos: JPG, PNG e WEBP.
                        </small>
                    </div>

                    <div class="d-grid gap-3">
                        <button type="submit" class="btn btn-rosa btn-cadastro-flor">
                            Cadastrar flor ✿
                        </button>

                        <button type="reset" class="btn btn-limpar-flor">
                            Limpar campos
                        </button>
                    </div>

                </form>

            </div>

            <div class="cadastro-flor-frase text-center">
                ✿ Compartilhe conhecimento e ajude novas descobertas a florescer ✿
            </div>

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
