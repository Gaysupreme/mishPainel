<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

function consultaApi($url) {
    $response = file_get_contents($url);
    return json_decode($response, true);
}

if (isset($_POST['consulta'])) {
    $cpf = $_POST['cpf'];
    $placa = $_POST['placa'];

    if ($cpf) {
        $urlCpfData = "https://rvbuscas.tech/?token=01d0a7282-67c8-4548282-b685-5e6e1c2155f3&base=cpfData&con=" . $cpf;
        $cpfInfo = consultaApi($urlCpfData);
    }

    if ($placa) {
        $urlPlacaData = "https://diplomatasconsultasv1.squareweb.app/placa32.php?token=1&placa=" . $placa;
        $placaInfo = consultaApi($urlPlacaData);
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mishPainel - Consultas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="panel-container">
    <h1>Bem-vindo ao painel, <?= $_SESSION['username'] ?></h1>

    <form method="POST">
        <input type="text" name="cpf" placeholder="Informe o CPF" required>
        <input type="text" name="placa" placeholder="Informe a Placa" required>
        <button type="submit" name="consulta">Consultar</button>
    </form>

    <?php if (isset($cpfInfo)): ?>
        <div class="results">
            <h2>Resultados da Consulta de CPF</h2>
            <pre><?= print_r($cpfInfo, true) ?></pre>
        </div>
    <?php endif; ?>

    <?php if (isset($placaInfo)): ?>
        <div class="results">
            <h2>Resultados da Consulta de Placa</h2>
            <pre><?= print_r($placaInfo, true) ?></pre>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
