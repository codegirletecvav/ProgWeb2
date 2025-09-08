<?php
session_start();

if (!isset($_SESSION['idFunc'])) {
    header("Location: login.php");  
    exit;
}

$conn = new mysqli("localhost", "root", "", "empresaabd");

    function validaSenha($senha) {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,16}$/', $senha);
}


if (isset($_POST['alterar'])) {
    $novaSenha = $_POST['nova_senha'];

    if (!validaSenha($novaSenha)) {
        die("Senha inválida! Deve ter entre 8 e 16 caracteres, letras maiúsculas, minúsculas e números.");
    }
    


    $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
    $id = $_SESSION['idFunc'];

    $sql = "UPDATE funcionarios SET senha = '$senhaHash' WHERE idFunc = $id";

    if (mysqli_query($conn, $sql)) {
        echo "Senha alterada com sucesso!";
    } else {
        echo "Erro: " . mysqli_error($conn);
    }
}
?>

<form method="POST">
    Nova senha: <input type="password" name="nova_senha" required><br>
    <input type="submit" name="alterar" value="Alterar Senha">
     <p><a href="login.php">Voltar para a Home</a></p>
</form>

<li><a href="dashboard.php">Voltar</a></li>