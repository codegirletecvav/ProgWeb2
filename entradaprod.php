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
     <link href="https://fonts.googleapis.com/css2?family=Anton&family=Open+Sans&display=swap" rel="stylesheet">
    <title>Registrar Entrada</title>
    <style>
   * {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: 'Open Sans', sans-serif;
  background: linear-gradient(135deg, #ffeaf4 0%, #fff 100%);
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  padding: 40px 15px;
}

.container {
  max-width: 700px;
  width: 100%;
  background: #fff;
  padding: 2.5rem 3rem;
  margin: 70px auto;
  border-radius: 15px;
  border: 2px solid #d9423f;
  box-shadow: 0 0 15px rgba(217, 66, 63, 0.2);
  text-align: center;

}

h2 {
  font-family: 'Anton', sans-serif;
  color: #d9423f;
  font-size: 2rem;
  margin-bottom: 1.5rem;
  position: relative;
  z-index: 1;
}

.mensagem {
  color: #d9423f;
  font-weight: bold;
  margin-bottom: 1.5rem;
  font-size: 1rem;
}


form {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
  position: relative;
  z-index: 1;
}

.form-group {
  display: flex;
  gap: 10px;
  align-items: center;
}

label {
  flex: 1;
  font-weight: 600;
  color: #444;
  font-size: 0.95rem;
  user-select: none;
  text-align: left;
}

select,
input[type="number"] {
  flex: 2;
  padding: 0.75rem 1rem;
  border: 2px solid #ddd;
  border-radius: 8px;
  font-size: 1rem;
  font-family: 'Open Sans', sans-serif;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

select:focus,
input[type="number"]:focus {
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
  background-color: #d9423f;;
  transform: scale(1.05);
}


.links {
  margin-top: 1.5rem;
  display: flex;
  justify-content: center;
  gap: 1rem;
  flex-wrap: wrap;
}

.links a {
  background-color: #ffeaf4;
  color: #d9423f;
  font-weight: bold;
  padding: 0.75rem 1rem;
  border-radius: 6px;
  text-decoration: none;
  transition: background-color 0.3s ease, transform 0.2s ease;
  font-family: 'Open Sans', sans-serif;
}

.links a:hover {
  background-color: #d9423f;
  color: #fff;
  transform: scale(1.05);
}

@media (max-width: 500px) {
  .container {
    padding: 2rem 1.5rem;
  }

  .form-group {
    flex-direction: column;
    align-items: stretch;
  }

  label {
    text-align: left;
    width: 100%;
  }

  select,
  input[type="number"] {
    width: 100%;
  }

  .links {
    flex-direction: column;
  }

  .links a {
    width: 100%;
    text-align: center;
  }
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
