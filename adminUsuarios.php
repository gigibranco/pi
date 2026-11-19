<?php
require_once "verificarAdmin.php";
require_once "config/banco.php";


$sql = "SELECT id, nome_completo, nome_usuario, email, tipo
        FROM usuarios
        ORDER BY nome_completo ASC";

$resultado = mysqli_query($conn, $sql);

if (!$resultado) {
    die("Erro ao buscar os usuários.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Usuários - Florescer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark cor-principal shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="admin.php">🌸 Florescer | Administração</a>
            <div class="d-flex align-items-center gap-2">
                <span class="text-white me-2">Administrador</span>
                <a href="index.php" class="btn btn-light btn-sm">Sair</a>
            </div>
        </div>
    </nav>

    <main>
        <div class="container py-5">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <div>
                    <h2 class="titulo">👥 Gerenciamento de Usuários</h2>
                    <p class="text-muted mb-0">Consulte os usuários cadastrados no Florescer.</p>
                </div>

                <a href="admin.php" class="btn btn-outline-secondary">Voltar</a>
            </div>

            <div class="card border-0 shadow-sm p-3 mb-4">
                <label for="pesquisaUsuario" class="form-label">Pesquisar usuário</label>
                <input
                    id="pesquisaUsuario"
                    type="search"
                    class="form-control"
                    placeholder="Digite o nome, usuário ou e-mail">
            </div>

            <div class="card border-0 shadow-sm">
                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th>Usuário</th>
                                <th>E-mail</th>
                                <th>Tipo</th>
                            </tr>
                        </thead>

                        <tbody id="tabelaUsuarios">

                            <?php if (mysqli_num_rows($resultado) > 0): ?>

                                <?php while ($usuario = mysqli_fetch_assoc($resultado)): ?>

                                    <?php
                                    $nome = htmlspecialchars($usuario["nome_completo"]);
                                    $nomeUsuario = htmlspecialchars($usuario["nome_usuario"]);
                                    $email = htmlspecialchars($usuario["email"]);
                                    $tipo = $usuario["tipo"];

                                    $pesquisa = strtolower(
                                        $usuario["nome_completo"] . " " .
                                        $usuario["nome_usuario"] . " " .
                                        $usuario["email"] . " " .
                                        $tipo
                                    );
                                    ?>

                                    <tr data-pesquisa="<?= htmlspecialchars($pesquisa, ENT_QUOTES, 'UTF-8') ?>">

                                        <td><?= $nome ?></td>

                                        <td>@<?= $nomeUsuario ?></td>

                                        <td><?= $email ?></td>

                                        <td>
                                            <?php if ($tipo === "administrador"): ?>
                                                <span class="badge bg-pink">Administrador</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Usuário</span>
                                            <?php endif; ?>
                                        </td>

                                    </tr>

                                <?php endwhile; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        Nenhum usuário cadastrado.
                                    </td>
                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

                <p id="semUsuario" class="text-muted text-center p-3 mb-0 d-none">
                    Nenhum usuário encontrado.
                </p>

            </div>

        </div>
    </main>

    <footer class="text-center py-4 mt-5">
        <svg width="28" height="28" viewBox="0 0 64 64" class="mb-2" style="fill:#E86A92;">
            <circle cx="32" cy="18" r="10"/>
            <circle cx="32" cy="46" r="10"/>
            <circle cx="18" cy="32" r="10"/>
            <circle cx="46" cy="32" r="10"/>
            <circle cx="32" cy="32" r="9" style="fill:#FFDCE8;"/>
        </svg>
        <br>
        <small class="text-muted">Projeto Florescer © 2026</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('pesquisaUsuario').addEventListener('input', function() {

            const termo = this.value.toLowerCase().trim();
            const linhas = document.querySelectorAll('#tabelaUsuarios tr[data-pesquisa]');
            let encontrados = 0;

            linhas.forEach(function(linha) {

                const corresponde = linha.dataset.pesquisa.includes(termo);

                linha.classList.toggle('d-none', !corresponde);

                if (corresponde) {
                    encontrados++;
                }

            });

            document.getElementById('semUsuario').classList.toggle('d-none', encontrados > 0);
        });
    </script>

</body>
</html>

<?php
mysqli_close($conn);
?>
