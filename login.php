<?php
session_start();

if (isset($_SESSION['idFunc'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<form method="post" action="">
    Nickname: <input type="text" name="nickname" required><br><br>
    Senha: <input type="password" name="senha" required><br><br>
    <input type="submit" value="Entrar">


</form>

<?php

function senha_valida($senha) {
    
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,16}$/', $senha);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conexao = new mysqli("localhost", "root", "", "empresaabd");
    if ($conexao->connect_error) {
        die("Erro na conexão: " . $conexao->connect_error);
    }

    $nickname = $_POST["nickname"];
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
                echo "Senha incorreta.";
            }
        } else {
            echo "Usuário não encontrado.";
        }
        $stmt->close();
        $conexao->close();
    }
?>

<li><a href="/trabalho_final/">Voltar para a Home</a></li>