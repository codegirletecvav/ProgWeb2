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
     <link href="https://fonts.googleapis.com/css2?family=Anton&family=Open+Sans&display=swap" rel="stylesheet">
    <title>Cadastrar Produto</title>
  
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
}


h2 {
  font-family: 'Anton', sans-serif;
  color: #d9423f;
  margin-bottom: 0.5rem;
  font-size: 2rem;
  position: relative;
  z-index: 1;
}

p.subtitle {
  font-family: 'Anton', sans-serif;
  font-size: 1rem;
  color: #d9423f;
  margin-bottom: 2rem;
  font-weight: 500;
  position: relative;
  z-index: 1;
}


form {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
  position: relative;
  z-index: 1;
}

label {
  text-align: left;
  font-weight: 600;
  color: #444;
  font-size: 0.95rem;
  margin-bottom: 0.3rem;
  user-select: none;
}

input,
select {
  width: 100%;
  padding: 0.75rem 1rem;
  border: 2px solid #ddd;
  border-radius: 8px;
  font-size: 1rem;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
  font-family: 'Open Sans', sans-serif;
}

input:focus,
select:focus {
  border-color: #d9423f;
  outline: none;
  box-shadow: 0 0 8px rgba(217, 66, 63, 0.3);
}


input[type="submit"] {
  background-color: #d9423f;
  color: #fff;
  border: none;
  padding: 0.85rem 0;
  font-size: 1.2rem;
  font-weight: 700;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease, transform 0.15s ease;
  font-family: 'Open Sans', sans-serif;
  margin-top: 1rem;
}

input[type="submit"]:hover {
  background-color: #b23431;
  transform: scale(1.05);
}


.actions {
  margin-top: 1.5rem;
  display: flex;
  justify-content: space-around;
  gap: 1rem;
}

.actions a {
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
}

.actions a:hover {
  background-color: #d9423f;
  color: #fff;
  transform: scale(1.05);
}


@media (max-width: 450px) {
  .container {
    padding: 2rem 1.5rem;
  }

  .actions {
    flex-direction: column;
  }

  .actions a {
    width: 100%;
  }
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
            <div class="actions">
      <a href="dashboard.php">Voltar</a>
        </form>

        
    </div>
</body>

</html>
