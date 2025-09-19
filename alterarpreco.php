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
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Open+Sans&display=swap" rel="stylesheet">

<style>
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

html, body {
  height: 100%;
  background-color: #f9e5e4;
  font-family: 'Open Sans', sans-serif;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Container centralizado */
.container {
  background-color: white;
  padding: 2.5rem 3rem;
  border-radius: 10px;
  box-shadow: 0 4px 15px rgba(217, 66, 63, 0.2);
  width: 90vw;
  min-width: 800px;
  max-width: 1000px;
}

/* Título */
h2 {
  font-family: 'Anton', sans-serif;
  color: #d9423f;
  text-align: center;
  margin-bottom: 2rem;
  font-size: 2.2rem;
}

/* Formulário */
form {
  display: flex;
  flex-direction: column;
}

label {
  margin-top: 1rem;
  margin-bottom: 0.3rem;
  font-weight: bold;
  color: #333;
  text-align: left;
}

input[type="text"],
input[type="password"],
input[type="email"],
select {
  padding: 0.6rem;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-family: 'Open Sans', sans-serif;
  font-size: 1rem;
  width: 100%;
}

/* Botão de envio */
input[type="submit"] {
  font-family: 'Anton', sans-serif;
  background-color: #d9423f;
  color: #f9e5e4;
  border: none;
  padding: 0.75rem;
  font-size: 1.1rem;
  cursor: pointer;
  border-radius: 6px;
  width: 100%;
  margin-top: 2rem;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

input[type="submit"]:hover {
  background-color: #b23431;
  transform: scale(1.02);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}

/* Botões extras alinhados */
.actions {
  display: flex;
  justify-content: center;
  gap: 1rem;
  margin-top: 2rem;
  flex-wrap: wrap;
}

.button-link {
  display: inline-block;
  font-family: 'Open Sans', sans-serif;
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

/* Link textual */
.text-link {
  text-align: center;
  margin-top: 1.5rem;
}

.text-link a {
  color: #d9423f;
  text-decoration: none;
  font-weight: bold;
}

.text-link a:hover {
  color: #b23431;
}

/* Estilo de mensagem */
p.mensagem {
  font-w

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


