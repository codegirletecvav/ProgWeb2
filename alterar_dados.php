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

// Recebe o ID para buscar dados via POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = (int)$_POST['id'];

    $stmt = $conn->prepare("SELECT nickname, nome, email, funcao FROM funcionarios WHERE idFunc = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Bind dos resultados nas variáveis
    $stmt->bind_result($nickname, $nome, $email, $funcao);

    if ($stmt->fetch()) {
        // Dados carregados nas variáveis acima
    } else {
        die("Funcionário não encontrado.");
    }

    $stmt->close();
}

// Quando o formulário de atualização for enviado via POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['novoid'])) {
    $novoid = (int)$_POST['novoid'];
    $novonickname = $_POST['novonickname'];
    $novonome = $_POST['novonome'];
    $novoemail = $_POST['novoemail'];
    $novafuncao = $_POST['novafuncao'];

    $stmt = $conn->prepare("UPDATE funcionarios SET nickname=?, nome=?, email=?, funcao=? WHERE idFunc=?");
    $stmt->bind_param("ssssi", $novonickname, $novonome, $novoemail, $novafuncao, $novoid);

    if ($stmt->execute()) {
        echo "Atualização realizada com sucesso!";
    } else {
        echo "Erro ao atualizar: " . $stmt->error;
    }

  
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Alterar Dados</title>
</head>
<body>

<?php if (isset($nickname)): ?>
    <form method="POST" action="alterar_dados.php">
        <input type="hidden" name="novoid" value="<?= htmlspecialchars($id) ?>">

        Nickname: <input type="text" name="novonickname" value="<?= htmlspecialchars($nickname) ?>" required><br><br>

        Nome: <input type="text" name="novonome" value="<?= htmlspecialchars($nome) ?>" required><br><br>

        Email: <input type="email" name="novoemail" value="<?= htmlspecialchars($email) ?>" required><br><br>

        Função: 
        <select name="novafuncao" required>
            <option value="gerente" <?= ($funcao === 'gerente') ? 'selected' : '' ?>>Gerente</option>
            <option value="funcionario" <?= ($funcao === 'funcionario') ? 'selected' : '' ?>>Funcionário</option>
            <option value="repositor" <?= ($funcao === 'repositor') ? 'selected' : '' ?>>Repositor</option>
        </select><br><br>

        <input type="submit" value="Salvar">
    </form>
<?php else: ?>
    <form method="POST" action="alterar_dados.php">
        <label for="id">ID do Funcionário para editar:</label>
        <input type="number" name="id" id="id" required>
        <input type="submit" value="Carregar Dados">
    </form>
<?php endif; ?>

<form method="POST" action="login.php" style="margin-top:20px;">
    <input type="submit" value="Voltar para Login">
</form>

<li><a href="dashboard.php">Voltar</a></li>
</body>
</html>
