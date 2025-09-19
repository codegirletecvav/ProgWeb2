<?php
session_start();

if (isset($_SESSION['idFunc'])) {
    header("Location: dashboard.php");
    exit;
}

function senha_valida($senha) {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,16}$/', $senha);
}

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conexao = new mysqli("localhost", "root", "", "empresaabd");
    if ($conexao->connect_error) {
        die("Erro na conexão: " . $conexao->connect_error);
    }

    $nickname = trim($_POST["nickname"]);
    $senha = $_POST["senha"];

    $stmt = $conexao->prepare("SELECT * FROM funcionarios WHERE nickname = ?");
    $stmt->bind_param("s", $nickname);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $dados = $resultado->fetch_object();

    if ($dados) {
        if (password_verify($senha, $dados->senha)) {
            $_SESSION['idFunc'] = $dados->idFunc;
            $_SESSION['nome'] = $dados->nome;
            $_SESSION['funcao'] = $dados->funcao;
            header("Location: dashboard.php");
            exit();
        } else {
            $erro = "Senha incorreta.";
        }
    } else {
        $erro = "Usuário não encontrado.";
    }
    $stmt->close();
    $conexao->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - AURA</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Playfair+Display&display=swap" rel="stylesheet" />
  <style>
    /* Reset básico */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body, html {
      height: 100%;
      font-family: 'Montserrat', sans-serif;
      background: linear-gradient(135deg, #fcefee 0%, #f9d6d5 100%);
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 1rem;
    }

    .login-container {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 8px 30px rgba(217, 66, 63, 0.25);
      max-width: 400px;
      width: 100%;
      padding: 2.5rem 3rem;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .login-container::before {
      content: "";
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle at center, #d9423f 0%, transparent 70%);
      opacity: 0.1;
      pointer-events: none;
      transform: rotate(25deg);
      z-index: 0;
    }

    h1 {
      font-family: 'Playfair Display', serif;
      color: #d9423f;
      font-size: 2.8rem;
      margin-bottom: 1rem;
      z-index: 1;
      position: relative;
    }

    p.subtitle {
      font-size: 1rem;
      color: #666;
      margin-bottom: 2rem;
      font-weight: 500;
      z-index: 1;
      position: relative;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 1.25rem;
      z-index: 1;
      position: relative;
    }

    label {
      text-align: left;
      font-weight: 600;
      color: #444;
      font-size: 0.9rem;
      margin-bottom: 0.3rem;
      user-select: none;
    }

    input[type="text"],
    input[type="password"] {
      padding: 0.75rem 1rem;
      border: 2px solid #ddd;
      border-radius: 8px;
      font-size: 1rem;
      transition: border-color 0.3s ease;
      font-family: 'Montserrat', sans-serif;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
      border-color: #d9423f;
      outline: none;
      box-shadow: 0 0 8px rgba(217, 66, 63, 0.3);
    }

    .btn-login {
      background-color: #d9423f;
      color: #fff;
      border: none;
      padding: 0.85rem 0;
      font-size: 1.2rem;
      font-weight: 700;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.15s ease;
      font-family: 'Montserrat', sans-serif;
      margin-top: 1rem;
    }

    .btn-login:hover {
      background-color: #b23431;
      transform: scale(1.05);
    }

    .error-msg {
      color: #b23431;
      font-weight: 600;
      margin-top: 1rem;
      font-size: 0.95rem;
      user-select: none;
    }

    .extra-links {
      margin-top: 2rem;
      display: flex;
      justify-content: space-between;
      font-size: 0.9rem;
      color: #d9423f;
      font-weight: 600;
      user-select: none;
    }

    .extra-links a {
      color: #d9423f;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .extra-links a:hover {
      color: #b23431;
      text-decoration: underline;
    }

    /* Ícone simples no input */
    .input-group {
      position: relative;
    }

    .input-group svg {
      position: absolute;
      top: 50%;
      left: 12px;
      transform: translateY(-50%);
      fill: #d9423f;
      width: 20px;
      height: 20px;
      pointer-events: none;
      opacity: 0.6;
    }

    input[type="text"].with-icon,
    input[type="password"].with-icon {
      padding-left: 40px;
    }

    /* Responsividade */
    @media (max-width: 450px) {
      .login-container {
        padding: 2rem 1.5rem;
      }
    }
  </style>
</head>
<body>

  <main class="login-container" role="main" aria-label="Formulário de login Makeup Glam">
    <h1>Makeup Glam</h1>
    <p class="subtitle">Entre para realçar sua beleza</p>

    <form method="post" action="" novalidate>
      <label for="nickname">Nickname</label>
      <div class="input-group">
        <svg aria-hidden="true" focusable="false" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
        <input type="text" id="nickname" name="nickname" class="with-icon" placeholder="Seu nickname" required autocomplete="username" />
      </div>

      <label for="senha">Senha</label>
      <div class="input-group">
        <svg aria-hidden="true" focusable="false" viewBox="0 0 24 24"><path d="M12 17a2 2 0 0 0 2-2v-3a2 2 0 0 0-4 0v3a2 2 0 0 0 2 2zm6-6h-1V7a5 5 0 0 0-10 0v4H6a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2z"/></svg>
        <input type="password" id="senha" name="senha" class="with-icon" placeholder="Sua senha" required autocomplete="current-password" />
      </div>

      <button type="submit" class="btn-login" aria-label="Entrar no sistema">Entrar</button>

      <?php if ($erro): ?>
        <p class="error-msg" role="alert"><?= htmlspecialchars($erro) ?></p>
      <?php endif; ?>
    </form>

    <nav class="extra-links" aria-label="Links adicionais">
      <a href="/trabalho_final/">Voltar para a Home</a>
      <a href="alterar_dados.php">Alterar dados</a>
    </nav>
  </main>

</body>
</html>

