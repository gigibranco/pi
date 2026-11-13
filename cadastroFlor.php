<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastro de Flor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark cor-principal shadow-sm">

        <div class="container">

            <a class="navbar-brand fw-bold" href="telaPrincipal.html">
                🌸 Florescer
            </a>

            <a href="telaPrincipal.html" class="btn btn-light btn-sm">
                Voltar
            </a>

        </div>

    </nav>

    <main>
        <div class="container py-5">
            <div class="card shadow caixa-formulario mx-auto">
                <div class="card-body p-5">
                    <h2 class="titulo text-center mb-4">
                        🌺 Cadastro de Flor
                    </h2>
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Nome da Flor</label>
                            <input type="text" class="form-control" placeholder="Ex.: Rosa">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nome Científico</label>
                            <input type="text" class="form-control" placeholder="Ex.: Rosa rubiginosa">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Categoria</label>
                            <select class="form-select">
                                <option selected disabled>Selecione...</option>
                                <option>Ornamental</option>
                                <option>Medicinal</option>
                                <option>Tropical</option>
                                <option>Silvestre</option>
                                <option>Outra</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cor Predominante</label>
                            <input type="text" class="form-control" placeholder="Ex.: Rosa">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea class="form-control" rows="4"
                                placeholder="Escreva informações sobre a flor..."></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Imagem da Flor</label>
                            <input type="file" class="form-control">
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-rosa">
                                Cadastrar Flor
                            </button>
                            <button type="reset" class="btn btn-outline-secondary">
                                Limpar Campos
                            </button>
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

        <small class="text-muted">
            Projeto Florescer © 2026
        </small>

    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>