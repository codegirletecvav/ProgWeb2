<?php
session_start();

if (!isset($_SESSION['idFunc'])) {
    header("Location: login.php");  
    exit;
}

$conn = new mysqli("localhost", "root", "", "empresaabd");

    function validaSenha($senha) {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,16}$/', $senha);
}


if (isset($_POST['alterar'])) {
    $novaSenha = $_POST['nova_senha'];

    if (!validaSenha($novaSenha)) {
        die("Senha inválida! Deve ter entre 8 e 16 caracteres, letras maiúsculas, minúsculas e números.");
    }
    


    $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
    $id = $_SESSION['idFunc'];

    $sql = "UPDATE funcionarios SET senha = '$senhaHash' WHERE idFunc = $id";

    if (mysqli_query($conn, $sql)) {
        echo "Senha alterada com sucesso!";
    } else {
        echo "Erro: " . mysqli_error($conn);
    }
}
?>


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

  input[type="password"] {
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
<h2>Alterar Senha</h2>

<form method="POST">
  <label>Nova senha:</label>
  <input type="password" name="nova_senha" required>

  <input type="submit" name="alterar" value="Alterar Senha">
</form>

<div class="actions">
  <a href="login.php" class="button-link">Voltar para a Home</a>
  <a href="dashboard.php" class="button-link">Voltar</a>
</div>
</div>

</body>
</html>
