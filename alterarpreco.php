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

<h2>Alterar Preço do Produto</h2>

<form method="post">
    Digite o ID do produto: <input name="id" type="number" required>
    <input type="submit" name="buscar" value="Buscar">
</form>

<?php if ($p): ?>
    <form method="post">
        Produto: <?= htmlspecialchars($p['nome']) ?><br>
        Novo preço: <input name="preco" type="number" step="0.01" value="<?= htmlspecialchars($p['preco']) ?>" required><br>
        <input type="hidden" name="id" value="<?= $p['id'] ?>">
        <input type="submit" name="atualizar" value="Atualizar">
    </form>
<?php endif; ?>

<li><a href="listarprod.php">Produtos</a></li>
<li><a href="dashboard.php">Voltar</a></li>