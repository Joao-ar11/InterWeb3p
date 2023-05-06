<?php
    include('../php/conn.php');
    session_start();
    if (!isset($_SESSION['funcao']) || $_SESSION['funcao'] !== 'cliente') {
        header('LOCATION: ../index.php');
    }
    $id_cliente = $_SESSION["id"];
    $orcamentos = $conn->query('SELECT id, validacao FROM orcamento_id WHERE id_cliente=' . $id_cliente . ';');
?>
<!DOCTYPE html>
<html class="home" lang="pt-BR">
<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar orçamento</title>
    <link rel="stylesheet" href="../styles/visualizarOrcamento-cliente.css">
    <script src="https://kit.fontawesome.com/3bc1a873c3.js" crossorigin="anonymous"></script>
</head>
<body class="home-body">
    <header class="tabs-home">
        <div class="box-imagem">
            <img class="logo-home" src="../images/logo.png" alt="">
            <div class="fundo-logo"></div>
        </div>

        <ul class="navbar">
            <a href="home-cliente.php"> 
                <li><i class="fas fa-home"></i> Home</li>
            </a>
            <div class="atual"></div>
            <a href="#">
                <li><i class="fa-solid fa-file-contract"></i> Visualizar Orçamento</li>
            </a>
            <a href="validarOrcamento-cliente.php">
                <li><i class="fa-solid fa-circle-check"></i> Validar Orçamento</li>
            </a>
        </ul>

        <div class="user">
            <div class="user-image">
            </div>
            <p>Usuário: Cliente</p>
        </div>
    </header>

    <section class="section-home">
        <h1>Início</h1>
        <h2>SERVIÇOS</h2>
        <ul>
            <?php
            $contador = 1;
                while($orcamento = $orcamentos->fetch_assoc()){
                    echo '<div>
                        <li>Serviço #000' . $contador . ' <a href="../pages/visualizacaoDeOrcamento.php?id=' . $orcamento["id"] . '" target="blank"><img src="../images/expandir.png"  width="30" height="30" alt=""></a></li>';
                    switch ($orcamento['validacao']) {
                        case 'em validação':
                            echo '<p class="status02">Em validação</p>';
                            break;
                        case 'confirmado':
                            echo '<p class="status03">Confirmado</p>';
                            break;
                        case 'negado':
                            echo '<p class="status01">Negado</p>';
                            break;
                    }
                    echo '</div>';
                    $contador++;
                }
            ?>
        </ul>
        <div style="display: flex; align-items: center;">
            <button id="more">Ver mais <img id="seta" src="../images/seta-para-baixo.png"></button>
        </div>
    </section>
</body>
</html>
