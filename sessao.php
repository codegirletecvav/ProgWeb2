<?php
session_start();

function verificarLogin()
{
    if (!isset($_SESSION['usuario'])) {
        header("Location: login.php");
        exit();
    }
}

function apenasGerente()
{
    if ($_SESSION['funcao'] !== 'gerente') {
        echo "Acesso negado. Apenas gerentes podem acessar esta página.";
        exit();
    }
}

function gerenteOuRepositor()
{
    if ($_SESSION['funcao'] !== 'gerente' && $_SESSION['funcao'] !== 'repositor') {
        echo "Acesso negado. Apenas gerentes ou repositores podem acessar esta página.";
        exit();
    }
}