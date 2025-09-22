<?php
session_start();

if (!isset($_SESSION['idFunc'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "empresaabd");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$nickname = $nome = $email = $funcao = null;
$id = null;
$msg_feedback = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['id'])) {
      
        $id = (int)$_POST['id'];

        $stmt = $conn->prepare("SELECT nickname, nome, email, funcao FROM funcionarios WHERE idFunc = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($nickname, $nome, $email, $funcao);

        if (!$stmt->fetch()) {
            $msg_feedback = "Funcionário não encontrado.";
            $nickname = $nome = $email = $funcao = null;
            $id = null;
        }
        $stmt->close();

    } elseif (isset($_POST['novoid'])) {
      
        $novoid = (int)$_POST['novoid'];
        $novonickname = $_POST['novonickname'];
        $novonome = $_POST['novonome'];
        $novoemail = $_POST['novoemail'];
        $novafuncao = $_POST['novafuncao'];

        $stmt = $conn->prepare("UPDATE funcionarios SET nickname=?, nome=?, email=?, funcao=? WHERE idFunc=?");
        $stmt->bind_param("ssssi", $novonickname, $novonome, $novoemail, $novafuncao, $novoid);

        if ($stmt->execute()) {
            $msg_feedback = "Dados atualizados com sucesso!";
            $nickname = $novonickname;
            $nome = $novonome;
            $email = $novoemail;
            $funcao = $novafuncao;
        } else {
            $msg_feedback = "Erro ao atualizar: " . $stmt->error;
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Alterar Dados</title>
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
        justify-content: center;
        align-items: center;
      }

      .container {
        background-color: white;
        padding: 2.5rem 3rem;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(217, 66, 63, 0.2);
        width: 90vw;
        min-width: 600px;
        max-width: 800px;
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
        margin-bottom: 0.3rem;
        margin-top: 1rem;
      }

      input[type="text"],
      input[type="email"],
      input[type="number"],
      select {
        padding: 0.6rem;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 1rem;
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
        margin-top: 1rem;
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

      .feedback {
        text-align: center;
        margin-bottom: 1rem;
        color: #d9423f;
        font-weight: bold;
        font-family: 'Anton', sans-serif;
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
    <h2>Alterar Dados</h2>

    <?php if ($msg_feedback): ?>
        <div class="feedback"><?= htmlspecialchars($msg_feedback) ?></div>
    <?php endif; ?>

    <?php if (isset($nickname) && $nickname !== null): ?>
        <form method="POST" action="alterar_dados.php">
            <input type="hidden" name="novoid" value="<?= htmlspecialchars($id) ?>">

            <label>Nickname:</label>
            <input type="text" name="novonickname" value="<?= htmlspecialchars($nickname) ?>" required>

            <label>Nome:</label>
            <input type="text" name="novonome" value="<?= htmlspecialchars($nome) ?>" required>

            <label>Email:</label>
            <input type="email" name="novoemail" value="<?= htmlspecialchars($email) ?>" required>

            <label>Função:</label>
            <select name="novafuncao" required>
                <option value="gerente" <?= ($funcao === 'gerente') ? 'selected' : '' ?>>Gerente</option>
                <option value="funcionario" <?= ($funcao === 'funcionario') ? 'selected' : '' ?>>Funcionário</option>
                <option value="repositor" <?= ($funcao === 'repositor') ? 'selected' : '' ?>>Repositor</option>
            </select>

            <input type="submit" value="Salvar">
        </form>
    <?php else: ?>
        <form method="POST" action="alterar_dados.php">
            <label for="id">ID do Funcionário para editar:</label>
            <input type="number" name="id" id="id" required>

            <input type="submit" value="Carregar Dados">
        </form>
    <?php endif; ?>

    <div class="actions">
      <form method="POST" action="login.php">
          <input type="submit" value="Voltar">
      </form>
    </div>
</div>

</body>
</html>

