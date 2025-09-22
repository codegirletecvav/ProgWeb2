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
     <link href="https://fonts.googleapis.com/css2?family=Anton&family=Open+Sans&display=swap" rel="stylesheet">
    <title>Lista de Produtos</title>
    <style>
        * {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: 'Open Sans', sans-serif;
  background: linear-gradient(135deg, #f9e5e4 0%, #f9e5e4 100%);
  display: flex;
  justify-content: center;
  align-items: flex-start;
  padding: 40px 15px;
  min-height: 100vh;
}

.container {
  max-width: 700px;
  width: 100%;
  margin: 0 auto;
  background: #fff;
  padding: 2.5rem 3rem;
  border-radius: 15px;
  box-shadow: 0 0 15px rgba(217, 66, 63, 0.2);
  text-align: center;
  border: none;   
}

h2 {
  font-family: 'Anton', sans-serif;
  color: #d9423f;
  margin-bottom: 1.5rem;
  font-size: 2rem;
  position: relative;
}

.produto {
  border-bottom: 1px solid #f3a6c4;
  padding: 15px 0;
  text-align: left;
}

.produto:last-child {
  border-bottom: none;
}

.produto strong {
  color: #333;
  font-weight: 600;
  font-size: 1rem;
}

.links {
  margin-top: 2rem;
  display: flex;
  justify-content: space-around;
  gap: 1rem;
  flex-wrap: wrap;
}

.links a {
  flex: 1;
  text-align: center;
  background-color: #f9e5e4;
  color: #d9423f;
  font-weight: bold;
  padding: 0.75rem 0;
  border-radius: 6px;
  text-decoration: none;
  font-family: 'Open Sans', sans-serif;
  transition: background-color 0.3s ease, transform 0.2s ease;
  min-width: 120px;
}

.links a:hover {
  background-color: #d9423f;
  color: #fff;
  transform: scale(1.05);
}

@media (max-width: 450px) {
  .container {
    padding: 2rem 1.5rem;
  }

  .links {
    flex-direction: column;
  }

  .links a {
    width: 100%;
  }
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
