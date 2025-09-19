<?php
session_start();

if (!isset($_SESSION['idFunc'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "empresaabd");

if (!isset($_SESSION['funcao']) || $_SESSION['funcao'] !== 'gerente') {
    echo "Acesso negado.";
    exit;
}

$mensagem = "";
$p = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buscar'])) {
    $id = (int)$_POST['id'];
    $p = $conn->query("SELECT * FROM produtos WHERE id = $id")->fetch_assoc();

    if (!$p) {
        $mensagem = "Produto não encontrado.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['atualizar'])) {
    $id = (int)$_POST['id'];
    $preco = (float)$_POST['preco'];
    $sql = "UPDATE produtos SET preco = $preco WHERE id = $id";
    if ($conn->query($sql)) {
        $mensagem = "Preço atualizado com sucesso.";
    } else {
        $mensagem = "Erro ao atualizar: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Alterar Preço</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background: #ffeef4;
        margin: 0;
    }

    .container {
        max-width: 500px;
        margin: 70px auto;
        background: #fff;
        padding: 30px;
        border: 2px solid #f3a6c4;
        border-radius: 4px;
        box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.08);
        text-align: center;
    }

    h2 {
        color: #d94c7b;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    p.mensagem {
        font-weight: bold;
        margin-bottom: 15px;
        color: #d94c7b;
    }

    label {
        display: block;
        margin-top: 15px;
        font-weight: bold;
        color: #333;
        text-align: left;
    }

    input {
        width: 100%;
        padding: 10px;
        margin: 8px 0 15px;
        border: 1px solid #bbb;
        border-radius: 3px;
    }

    input[type="submit"] {
        background: #d94c7b;
        color: #fff;
        border: none;
        cursor: pointer;
        font-weight: bold;
        padding: 12px;
        border-radius: 3px;
        transition: 0.3s;
        width: 100%;
    }

    input[type="submit"]:hover {
        background: #b93b65;
    }

    .links {
        margin-top: 20px;
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
        <h2>Alterar Preço do Produto</h2>

        <?php if (!empty($mensagem)): ?>
        <p class="mensagem"><?= htmlspecialchars($mensagem) ?></p>
        <?php endif; ?>

        <form method="post">
            <label for="id">Digite o ID do produto:</label>
            <input name="id" type="number" id="id" required>
            <input type="submit" name="buscar" value="Buscar">
        </form>

        <?php if ($p): ?>
        <form method="post">
            <p><strong>Produto:</strong> <?= htmlspecialchars($p['nome']) ?></p>
            <label for="preco">Novo preço:</label>
            <input name="preco" id="preco" type="number" step="0.01" value="<?= htmlspecialchars($p['preco']) ?>"
                required>
            <input type="hidden" name="id" value="<?= $p['id'] ?>">
            <input type="submit" name="atualizar" value="Atualizar">
        </form>
        <?php endif; ?>

        <div class="links">
            <a href="listarprod.php">Produtos</a>
            <a href="dashboard.php">Voltar</a>
        </div>
    </div>
</body>

</html>
