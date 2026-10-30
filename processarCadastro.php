
<?php
require_once "config/banco.php";

// Verifica se o formulário foi enviado pelo método POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: cadastroUsuario.php");
    exit;
}

// Recebe os dados do formulário
$nome_completo = trim($_POST["nome_completo"] ?? "");
$nome_usuario = trim($_POST["nome_usuario"] ?? "");
$email = trim($_POST["email"] ?? "");
$senha = $_POST["senha"] ?? "";
$confirmar_senha = $_POST["confirmar_senha"] ?? "";

// Verifica se todos os campos foram preenchidos
if (
    $nome_completo === "" ||
    $nome_usuario === "" ||
    $email === "" ||
    $senha === "" ||
    $confirmar_senha === ""
) {
    die("Preencha todos os campos.");
}

// Verifica se o e-mail é válido
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Digite um e-mail válido.");
}

// Verifica se as senhas são iguais
if ($senha !== $confirmar_senha) {
    die("As senhas não coincidem. <a href='cadastroUsuario.php'>Voltar</a>");
}

// Verifica o tamanho mínimo da senha
if (strlen($senha) < 6) {
    die("A senha precisa ter pelo menos 6 caracteres. <a href='cadastroUsuario.php'>Voltar</a>");
}

// Verifica se o usuário ou e-mail já estão cadastrados
$sql_verificar = "SELECT id FROM usuarios
                  WHERE nome_usuario = ? OR email = ?";

$stmt = mysqli_prepare($conn, $sql_verificar);
mysqli_stmt_bind_param($stmt, "ss", $nome_usuario, $email);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) > 0) {
    mysqli_stmt_close($stmt);
    die("Este usuário ou e-mail já está cadastrado. <a href='cadastroUsuario.php'>Voltar</a>");
}

mysqli_stmt_close($stmt);

// Protege a senha usando hash
$senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

// Insere o usuário no banco de dados
$sql_inserir = "INSERT INTO usuarios
                (nome_completo, nome_usuario, email, senha)
                VALUES (?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql_inserir);
mysqli_stmt_bind_param(
    $stmt,
    "ssss",
    $nome_completo,
    $nome_usuario,
    $email,
    $senha_criptografada
);

if (mysqli_stmt_execute($stmt)) {
    echo "<h2>Cadastro realizado com sucesso! 🌸</h2>";
    echo "<p>Seu usuário foi cadastrado no Florescer.</p>";
    echo "<a href='index.html'>Voltar para o login</a>";
} else {
    echo "Não foi possível realizar o cadastro. Tente novamente.";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>