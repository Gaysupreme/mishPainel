<?php
session_start();

// Função para carregar os usuários armazenados no arquivo JSON
function carregarUsuarios() {
    $usuarios = file_get_contents('usuarios.json');
    return json_decode($usuarios, true);
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Carregar os usuários
    $usuarios = carregarUsuarios();

    // Senha do administrador
    $adminPassword = "7Z@3t#BNsMgjxC@";

    // Verificar se é o login de um administrador
    if ($username == 'admin' && $password == $adminPassword) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = 'admin';
        header("Location: admin_create.php"); // Redireciona para a página de criação de usuários
        exit();
    }

    // Verificar se o usuário e senha existem para usuários normais
    if (isset($usuarios[$username]) && $usuarios[$username] === $password) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        $error = "Usuário ou senha incorretos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mishPainel - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-container">
    <h1>Bem-vindo ao mishPainel</h1>
    <h2>Por favor, entre com suas credenciais</h2>

    <?php if (isset($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Usuário" required>
        <input type="password" name="password" placeholder="Senha" required>
        <button type="submit" name="submit">Entrar</button>
    </form>
</div>

</body>
</html>
