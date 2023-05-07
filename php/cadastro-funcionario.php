<?php
    session_start();
    if (!isset($_SESSION['funcao']) || $_SESSION['funcao'] !== 'dono') {
        header('LOCATION: ../index.php');
    }
    include('../php/conn.php');

    //Cadastro Funcionario

    $nome = $_POST["NOME"];
    $email = $_POST["EMAIL"];
    $senha = $_POST["SENHA"];
    $senha = password_hash($senha, PASSWORD_DEFAULT);
    $dataa = $_POST["DATANASC"];
    $funcao = 'funcionario';

//Inserindo dados no Banco

    if (isset($nome) && isset($email) && isset($senha) && isset($dataa)) {

    $insere = "INSERT INTO cadastro (nome, email, senha, dataa, funcao) VALUES ('$nome', '$email', '$senha', '$dataa', '$funcao')";

    mysqli_query($conn, $insere) or die("Não foi possível executar a inserção");

    $_SESSION['confirmar'] = 'confirmado';
}


    header('Location: ../pages/cadastro-funcionario-dono.php');
?>