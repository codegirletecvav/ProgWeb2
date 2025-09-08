<?php
session_start();
$conn = new mysqli("localhost", "root", "", "empresaabd");

if (!isset($_SESSION['funcao']) || $_SESSION['funcao'] !== 'gerente') {
    echo "Acesso negado.";
    exit;
}

$res = $conn->query("SELECT * FROM produtos");
?>

<h2>Lista de Produtos</h2>

<?php while ($p = $res->fetch_assoc()): ?>
    <strong>Nome:</strong> <?= $p['nome'] ?><br>
    <strong>Preço:</strong> R$ <?= number_format($p['preco'], 2, ',', '.') ?><br>
    <strong>Quantidade:</strong> <?= $p['quantidade'] ?><br>
    <br>
<?php endwhile; ?>

<br>
<li><a href="alterarpreco.php">Alterar preço</a></li>
<li><a href="dashboard.php">Voltar</a></li>