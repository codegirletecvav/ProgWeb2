<?php
session_start();
$conn = new mysqli("localhost", "root", "", "empresaabd");

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}


function validaSenha($senha) {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,16}$/', $senha);
}

$consulta = $conn->query("SELECT COUNT(*) as total FROM funcionarios WHERE funcao = 'gerente'");
$dado = $consulta->fetch_assoc();
$temGerente = $dado['total'] > 0;


if ($temGerente) {
    if (!isset($_SESSION['idFunc']) || $_SESSION['funcao'] != 'gerente') {

        die("Acesso negado. Apenas gerentes podem acessar essa página.");
    }
}

if (isset($_POST['cadastrar'])) {
    $nickname = $_POST['nickname'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $funcao = $_POST['funcao'] ?? '';

    if (!validaSenha($senha)) {
        die("Senha inválida! Deve ter entre 8 e 16 caracteres, letras maiúsculas, minúsculas e números.");
    }

  
    $verifica = $conn->query("SELECT * FROM funcionarios WHERE nickname = '$nickname'");
    if ($verifica->num_rows > 0) {
        die("Nickname já cadastrado. Escolha outro.");
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO funcionarios (nickname, senha, nome, email, funcao) 
            VALUES ('$nickname', '$senhaHash', '$nome', '$email', '$funcao')";

    if (mysqli_query($conn, $sql)) {
        echo "Cadastro realizado com sucesso!";
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
    max-width: 500px;
    width: 100%;
  }

  h2 {
    font-family: 'Anton', sans-serif;
    color: #d9423f;
    text-align: center;
    margin-bottom: 1.5rem;
    font-size: 2rem;
  }

  form {
    display: flex;
    flex-direction: column;
  }

  label, input, select {
    font-size: 1rem;
    margin-bottom: 1rem;
    width: 100%;
  }

  input[type="text"],
  input[type="password"],
  input[type="email"],
  select {
    padding: 0.6rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-family: 'Open Sans', sans-serif;
  }

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
    transition: background-color 0.3s ease, transform 0.2s ease;
  }

  input[type="submit"]:hover {
    background-color: #b23431;
    transform: scale(1.02);
  }

  a {
    display: inline-block;
    text-align: center;
    text-decoration: none;
    color: #d9423f;
    font-weight: bold;
    margin-top: 1rem;
    transition: color 0.3s ease;
  }

  a:hover {
    color: #b23431;
  }

  li {
    list-style: none;
    text-align: center;
    margin-top: 1rem;
  }

  li a {
    display: inline-block;
    font-family: 'Anton', sans-serif;
    background-color: #d9423f;
    color: #f9e5e4;
    padding: 0.7rem 2rem;
    border-radius: 6px;
    text-decoration: none;
    font-size: 1rem;
    transition: background-color 0.3s ease, transform 0.2s ease;
  }

  li a:hover {
    background-color: #b23431;
    transform: scale(1.05);
  }
</style>
</head>
<body>

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

    .container {
      background-color: white;
      padding: 2.5rem 3rem;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(217, 66, 63, 0.2);
      width: 90vw;             /* Ocupa 90% da largura da tela */
      min-width: 800px;        /* Largura mínima garantida */
      max-width: 1000px;       /* Máximo para telas grandes */
    }

    h2 {
      font-family: 'Anton', sans-serif;
      color: #d9423f;
      text-align: center;
      margin-bottom: 2rem;
      font-size: 2.2rem;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      margin-top: 1rem;
      margin-bottom: 0.3rem;
      font-weight: bold;
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
    }

    /* Ações alinhadas horizontalmente */
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

    @media (max-width: 850px) {
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
  <h2>Cadastro de Usuário</h2>

  <form method="POST">
    <label>Nickname:</label>
    <input type="text" name="nickname" required>

    <label>Senha:</label>
    <input type="password" name="senha" required>

    <label>Nome completo:</label>
    <input type="text" name="nome" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Função:</label>
    <select name="funcao" required>
      <option value="gerente">Gerente</option>
      <option value="funcionario">Funcionário</option>
      <option value="repositor">Repositor</option>
    </select>

    <input type="submit" name="cadastrar" value="Cadastrar">

    <!-- Botões lado a lado -->
    <div class="actions">
      <a href="alterar_dados.php" class="button-link">Alterar dados</a>
      <a href="dashboard.php" class="button-link">Voltar</a>
    </div>


</body>
</html>
