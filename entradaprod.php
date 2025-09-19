<?php
session_start();
$conn = new mysqli("localhost", "root", "", "empresaabd");

if (!isset($_SESSION['funcao']) || !in_array($_SESSION['funcao'], ['gerente', 'repositor'])) {
    echo "Acesso negado.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $quantidade = $_POST['quantidade'];

    $sql = "UPDATE produtos SET quantidade = quantidade + $quantidade WHERE id = $id";
    if ($conn->query($sql)) {
        $mensagem = "Entrada registrada com sucesso.";
    } else {
        $mensagem = "Erro: " . $conn->error;
    }
}

$res = $conn->query("SELECT * FROM produtos");
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Registrar Entrada</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background: #ffeaf4;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 600px;
        margin: 70px auto;
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        border: 2px solid #f5a5c2;
    }

    h2 {
        text-align: center;
        color: #d94c7b;
        margin-bottom: 25px;
    }

    .mensagem {
        text-align: center;
        font-weight: bold;
        margin-bottom: 20px;
        color: #d94c7b;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .form-group {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    label {
        flex: 1;
        font-weight: bold;
        color: #333;
    }

    select,
    input[type="number"] {
        flex: 2;
        padding: 10px;
        border: 1px solid #bbb;
        border-radius: 5px;
    }

    input[type="submit"] {
        padding: 12px;
        background: #d94c7b;
        color: #fff;
        border: none;
        cursor: pointer;
        border-radius: 6px;
        font-weight: bold;
        transition: 0.3s;
    }

    input[type="submit"]:hover {
        background: #b63a65;
    }

    .links {
        text-align: center;
        margin-top: 20px;
    }

    .links a {
        color: #d94c7b;
        text-decoration: none;
        font-weight: bold;
        margin: 0 10px;
    }

    .links a:hover {
        text-decoration: underline;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Registrar Entrada de Produto</h2>

        <?php if (!empty($mensagem)): ?>
        <p class="mensagem"><?= $mensagem ?></p>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="id">Produto:</label>
                <select name="id" id="id" required>
                    <?php while ($p = $res->fetch_assoc()): ?>
                    <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nome']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="quantidade">Quantidade:</label>
                <input name="quantidade" id="quantidade" type="number" required>
            </div>

            <input type="submit" value="Registrar">
        </form>

        <div class="links">
            <a href="dashboard.php">Voltar</a>
        </div>
    </div>
</body>

</html>
