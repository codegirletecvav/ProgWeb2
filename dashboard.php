<?php
session_start();
if (!isset($_SESSION['idFunc'])) {
    header("Location: login.php");
    exit;
}
?>

<link href="https://fonts.googleapis.com/css2?family=Anton&family=Open+Sans&display=swap" rel="stylesheet" />

<style>

  body, html {
    height: 100%;
    margin: 0;
    font-family: 'Open Sans', sans-serif;
    background-color: #f9e5e4;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .container {
    background: white;
    padding: 2rem 3rem;
    border-radius: 10px;
    max-width: 600px;
    width: 100%;
    box-shadow: 0 4px 15px rgba(217, 66, 63, 0.2);
    text-align: center;
  }

  h2 {
    font-family: 'Anton', sans-serif;
    color: #d9423f;
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
  }

  p {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    color: #555;
  }

  ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  ul li {
    margin-bottom: 1rem;
  }

  ul li a {
    display: inline-block;
    font-family: 'Open sans', sans-serif;
    background-color: #d9423f;
    color: #f9e5e4;
    padding: 0.75rem 2rem;
    border-radius: 6px;
    text-decoration: none;
    font-size: 1.1rem;
    font-weight: 700;
    letter-spacing: 1px;
    transition: background-color 0.3s ease, transform 0.2s ease;
    
  width: 220px;      
  text-align: center;
  }

  ul li a:hover {
    background-color: #b23431;
    transform: scale(1.05);
  }
</style>

</head>
<body>

<div class="container">
  <h2>Bem-vindo(a) <?php echo htmlspecialchars($_SESSION['nome']); ?></h2>
  <p>Função: <?php echo htmlspecialchars($_SESSION['funcao']); ?></p>

  <ul>
    <?php if ($_SESSION['funcao'] === 'gerente'): ?>
      <li><a href="cadastro.php">Cadastrar Funcionário</a></li>
      <li><a href="alterar_senha.php">Alterar senha</a></li>
      <li><a href="listarprod.php">Produtos</a></li>
      <li><a href="cadastroprod.php">Cadastrar produto</a></li>
      <li><a href="entradaprod.php">Entrada de produto</a></li>
      <li><a href="alterarpreco.php">Alterar preço</a></li>
    <?php elseif ($_SESSION['funcao'] === 'repositor'): ?>
      <li><a href="entradaprod.php">Entrada de produto</a></li>
    <?php endif ($_SESSION['funcao'] === 'funcionário'): ?>
      <li><a href="listarprod.php">Produtos</a></li>

    <li><a href="logout.php">Sair</a></li>
  </ul>
</div>

</body>
</html>


