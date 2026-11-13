<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Minhas Publicações - Florescer</title>

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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="titulo">
                        📝 Minhas Publicações
                    </h2>
                    <p class="text-muted mb-0">
                        Flores cadastradas por você.
                    </p>
                </div>
                <a href="cadastroFlor.html" class="btn btn-rosa">
                    + Nova Flor
                </a>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card card-menu shadow-sm h-100">
                        <img src="imagens/carmelia.webp"
                             class="card-img-top"
                             alt="Camélia">
                        <div class="card-body">
                            <h5>🌺 Camélia</h5>
                            <p class="mb-2">
                                <strong>Categoria:</strong> Ornamental
                            </p>
                            <p class="text-muted small">
                                Publicada por você
                            </p>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-rosa flex-grow-1">
                                    Ver
                                </a>
                                <a href="#" class="btn btn-outline-secondary">
                                    Editar
                                </a>
                                <button class="btn btn-outline-danger">
                                    Excluir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card card-menu shadow-sm h-100">
                        <img src="imagens/margarida.webp"
                             class="card-img-top"
                             alt="Margarida">
                        <div class="card-body">
                            <h5>🌼 Margarida</h5>
                            <p class="mb-2">
                                <strong>Categoria:</strong> Ornamental
                            </p>
                            <p class="text-muted small">
                                Publicada por você
                            </p>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-rosa flex-grow-1">
                                    Ver
                                </a>
                                <a href="#" class="btn btn-outline-secondary">
                                    Editar
                                </a>
                                <button class="btn btn-outline-danger">
                                    Excluir
                                </button>
                            </div>
                        </div>
                    </div>
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
