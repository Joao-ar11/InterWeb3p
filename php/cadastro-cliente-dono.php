<?php
    session_start();
    if (!isset($_SESSION['funcao']) || $_SESSION['funcao'] !== 'dono') {
        header('LOCATION: ../index.php');
    }
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
    $senha_crip = password_hash($senha, PASSWORD_DEFAULT);
    // $senhaconfirm = $_POST["confirmar-senha"];
    $funcao = 'cliente';

//Inserindo dados no Banco

    if (isset($nome) && isset($cnpj) && isset($contato) && isset($endereco) && isset($email) && isset($bairro) && isset($n_endereco) && isset($complemento) && isset($senha) && isset($funcao))  {

        $insere = "INSERT INTO cadastro (contato, nome, cnpj, email, senha, n_endereco, bairro, complemento, funcao) VALUES ('$contato','$nome','$cnpj','$email','$senha_crip','$n_endereco','$bairro','$complemento','$funcao')";
        mysqli_query($conn, $insere) or die("Não foi possível executar a inserção");
        $_SESSION['confirmar'] = 'confirmado';
    }
    
    header('Location: ../pages/cadastro-cliente-dono.php');
?>