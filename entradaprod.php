<?php session_start();

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
        echo "Entrada registrada com sucesso.";
    } else {
        echo "Erro: " . $conn->error;
    }
}

$res = $conn->query("SELECT * FROM produtos");
?>

<h2>Registrar Entrada de Produto</h2>
<form method="post">
    Produto:
    <select name="id" required>
        <?php while($p = $res->fetch_assoc()): ?>
            <option value="<?= $p['id'] ?>"><?= $p['nome'] ?></option>
        <?php endwhile; ?>
    </select><br>
    Quantidade de entrada: <input name="quantidade" type="number" required><br>
    <input type="submit" value="Registrar">
</form>

<li><a href="dashboard.php">Voltar</a></li>