<?php session_start();

if (!isset($_SESSION['idFunc'])) {
    header("Location: login.php");  
    exit;
}

$conn = new mysqli("localhost", "root", "", "empresaabd");

if (!isset($_SESSION['funcao']) || $_SESSION['funcao'] !== 'gerente'){
    echo "Acesso negado.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $sql = "INSERT INTO produtos(nome, preco, quantidade) VALUES('$nome', '$preco', '$quantidade')";
    if($conn -> query($sql)) {
        echo "Produto cadastrado.";
    } else{
        echo "Erro: ".$conn -> error;
    }
}
?>

<h2>Cadastrar produto</h2>
<form method = "POST">
    Nome: <input name = "nome"><br>
    Preco: <input name = "preco" type = "number" step = "0.01"><br>
    Quantidade: <input name = "quantidade" type = "number"><br>
    <input type = "submit" value = "Cadastrar">
</form>

<li><a href="dashboard.php">Voltar</a></li>