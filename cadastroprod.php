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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $sql = "INSERT INTO produtos(nome, preco, quantidade) VALUES('$nome', '$preco', '$quantidade')";
    if ($conn->query($sql)) {
        echo "<p style='color:#e83e8c; text-align:center;'>Produto cadastrado com sucesso!</p>";
    } else {
        echo "<p style='color:red; text-align:center;'>Erro: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Produto</title>
    <style>
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background: #ffeef5;
        margin: 0;
    }

    .container {
        max-width: 420px;
        margin: 60px auto;
        background: #fff;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    h2 {
        color: #d63384;
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-top: 10px;
        font-weight: bold;
        color: #555;
        text-align: left;
    }

    input {
        width: 100%;
        padding: 10px;
        margin: 8px 0;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    input[type="submit"] {
        background: #d63384;
        color: #fff;
        border: none;
        cursor: pointer;
        font-weight: bold;
        transition: 0.3s;
    }

    input[type="submit"]:hover {
        background: #ad276a;
    }

    .links {
        margin-top: 20px;
    }

    .links a {
        color: #d63384;
        text-decoration: none;
        font-weight: bold;
    }

    .links a:hover {
        text-decoration: underline;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Cadastrar Produto</h2>
        <form method="POST">
            <label>Nome:</label>
            <input name="nome" required>

            <label>Preço:</label>
            <input name="preco" type="number" step="0.01" required>

            <label>Quantidade:</label>
            <input name="quantidade" type="number" required>

            <input type="submit" value="Cadastrar">
        </form>

        <div class="links">
            <a href="dashboard.php">Voltar</a>
        </div>
    </div>
</body>

</html>
