<?php
    include('../php/conn.php');
    //Cadastro Cliente

    $nome = $_POST["nome"];
    $cnpj = $_POST["cnpj"];
    $contato = $_POST["contato"];
    $endereco = $_POST["endereco"];
    $email = $_POST["email"];
    $bairro = $_POST["bairro"];
    $n_endereco = $_POST["n-endereco"];
    $complemento = $_POST["complemento"];
    $senha = $_POST["senha"];
    // $senhaconfirm = $_POST["confirmar-senha"];
    $funcao = 'cliente';

//Inserindo dados no Banco

    if (isset($nome) && isset($cnpj) && isset($contato) && isset($endereco) && isset($email) && isset($bairro) && isset($n_endereco) && isset($complemento) && isset($senha) && isset($funcao))  {

        $insere = "INSERT INTO cadastro (nome, cnpj, contato, email, bairro, n_endereco, complemento, senha, funcao) VALUES ('$nome', '$cnpj', '$contato', '$email', '$bairro', '$n_endereco', '$complemento', '$senha', '$funcao')";

        mysqli_query($conn, $insere) or die("Não foi possível executar a inserção");
    }
    
    header('Location: ../pages/cadastro-cliente-funcionario.php');
?>