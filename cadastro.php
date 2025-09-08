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

<form method="POST">
    Nickname: <input type="text" name="nickname" required><br>
    Senha: <input type="password" name="senha" required><br>
    Nome completo: <input type="text" name="nome" required><br>
    Email: <input type="email" name="email" required><br>
    Função: 
    <select name="funcao" required>
        <option value="gerente">Gerente</option>
        <option value="funcionario">Funcionário</option>
        <option value="repositor">Repositor</option>
    </select><br>
    <input type="submit" name="cadastrar" value="Cadastrar"><br><br>
     <a href="alterar_dados.php">Alterar dados</a>
    <p>Voltar para o <a href="login.php">Login</a></p>
</form>

<li><a href="dashboard.php">Voltar</a></li>