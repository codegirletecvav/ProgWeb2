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
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Alterar Preço</title>
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Open+Sans&display=swap" rel="stylesheet">

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body, html {
      height: 100%;
      font-family: 'Open Sans', sans-serif;
      background-color: #f9e5e4;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container {
      background-color: white;
      padding: 2.5rem 3rem;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(217, 66, 63, 0.2);
      width: 90vw;
      min-width: 500px;
      max-width: 700px;
    }

    h2 {
      font-family: 'Anton', sans-serif;
      color: #d9423f;
      text-align: center;
      margin-bottom: 2rem;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      font-weight: bold;
      margin-bottom: 0.5rem;
    }

    input[type="number"] {
      padding: 0.6rem;
      font-size: 1rem;
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-bottom: 1.5rem;
    }

    input[type="submit"] {
      font-family: 'Anton', sans-serif;
      background-color: #d9423f;
      color: #f9e5e4;
      border: none;
      padding: 0.75rem;
      font-size: 1.1rem;
      border-radius: 6px;
      width: 100%;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    input[type="submit"]:hover {
      background-color: #b23431;
      transform: scale(1.02);
    }

    .actions {
      display: flex;
      justify-content: center;
      gap: 1rem;
      margin-top: 2rem;
      flex-wrap: wrap;
    }

    .button-link {
      display: inline-block;
      font-family: 'Open sans', sans-serif;
      background-color: #d9423f;
      color: #f9e5e4;
      padding: 0.7rem 2rem;
      border-radius: 6px;
      text-decoration: none;
      font-size: 1rem;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .button-link:hover {
      background-color: #b23431;
      transform: scale(1.05);
    }

    .mensagem {
      margin-bottom: 1.5rem;
      text-align: center;
      color: #d9423f;
      font-weight: bold;
    }

    @media (max-width: 600px) {
      .container {
        min-width: unset;
        width: 95vw;
        padding: 2rem;
      }

      .actions {
        flex-direction: column;
        align-items: center;
      }

      .button-link {
        width: 100%;
        text-align: center;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Alterar Preço do Produto</h2>

  <?php if ($mensagem): ?>
    <div class="mensagem"><?= htmlspecialchars($mensagem) ?></div>
  <?php endif; ?>

  <form method="post">
    <label for="id">Digite o ID do produto:</label>
    <input name="id" type="number" required>
    <input type="submit" name="buscar" value="Buscar">
  </form>

  <?php if ($p): ?>
    <form method="post">
      <label>Produto:</label>
      <div style="margin-bottom: 1rem;"><?= htmlspecialchars($p['nome']) ?></div>

      <label for="preco">Novo preço:</label>
      <input name="preco" type="number" step="0.01" value="<?= htmlspecialchars($p['preco']) ?>" required>

      <input type="hidden" name="id" value="<?= $p['id'] ?>">
      <input type="submit" name="atualizar" value="Atualizar">
    </form>
  <?php endif; ?>

  <div class="actions">
    <a href="listarprod.php" class="button-link">Ver Produtos</a>
    <a href="dashboard.php" class="button-link">Voltar</a>
  </div>
</div>

</body>
</html>
