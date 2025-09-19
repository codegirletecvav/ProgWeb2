<?php
session_start();
$conn = new mysqli("localhost", "root", "", "empresaabd");

if (!isset($_SESSION['funcao']) || $_SESSION['funcao'] !== 'gerente') {
    echo "Acesso negado.";
    exit;
}

$res = $conn->query("SELECT * FROM produtos");
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Lista de Produtos</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background: #fff0f6;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 700px;
        margin: 50px auto;
        background: #fff;
        padding: 30px;
        border: 2px solid #f3a6c4;
        border-radius: 4px;
        box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.08);
    }

    h2 {
        text-align: center;
        color: #d94c7b;
        margin-bottom: 25px;
    }

    .produto {
        border-bottom: 1px solid #f3a6c4;
        padding: 15px 0;
    }

    .produto:last-child {
        border-bottom: none;
    }

    .produto strong {
        color: #333;
    }

    .links {
        margin-top: 25px;
        text-align: center;
    }

    .links a {
        display: inline-block;
        margin: 0 15px;
        color: #d94c7b;
        text-decoration: none;
        font-weight: bold;
        border-bottom: 2px solid transparent;
        padding-bottom: 3px;
    }

    .links a:hover {
        border-bottom: 2px solid #d94c7b;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Lista de Produtos</h2>

        <?php while ($p = $res->fetch_assoc()): ?>
        <div class="produto">
            <p><strong>Nome:</strong> <?= htmlspecialchars($p['nome']) ?></p>
            <p><strong>Preço:</strong> R$ <?= number_format($p['preco'], 2, ',', '.') ?></p>
            <p><strong>Quantidade:</strong> <?= $p['quantidade'] ?></p>
        </div>
        <?php endwhile; ?>

        <div class="links">
            <a href="alterarpreco.php">Alterar preço</a>
            <a href="dashboard.php">Voltar</a>
        </div>
    </div>
</body>

</html>
