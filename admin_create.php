<?php
session_start();

// Verificar se o usuário é o administrador
if (!isset($_SESSION['loggedin']) || $_SESSION['username'] !== 'admin') {
    header("Location: login.php");
    exit();
}

function carregarUsuarios() {
    $usuarios = file_get_contents('usuarios.json');
    return json_decode($usuarios, true);
}

function salvarUsuarios($usuarios) {
    file_put_contents('usuarios.json', json_encode($usuarios, JSON_PRETTY_PRINT));
}

if (isset($_POST['create'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Carregar usuários existentes
    $usuarios = carregarUsuarios();

    // Adicionar o novo usuário
    $usuarios[$username] = $password;

    // Salvar os usuários no arquivo
    salvarUsuarios($usuarios);

    echo "Usuário criado com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Novo Usuário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="panel-container">
    <h1>Criar Novo Usuário</h1>

    <form method="POST">
        <label for="username">Nome de Usuário:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit" name="create">Criar Usuário</button>
    </form>
</div>

</body>
</html>
