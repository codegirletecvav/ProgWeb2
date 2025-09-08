<?php
session_start();
if (!isset($_SESSION['idFunc'])) {
    header("Location: login.php");
    exit;
}
?>

<h2>Bem-vindo(a) <?php echo htmlspecialchars($_SESSION['nome']); ?></p></h2>
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
    <?php endif; ?>
    
    <li><a href="logout.php">Sair</a></li>
</ul>