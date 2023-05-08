<?php
    session_start();
    if (!isset($_SESSION['funcao']) || $_SESSION['funcao'] !== 'dono') {
        header('LOCATION: ../index.php');
    }
    include '../php/conn.php';
    $orcamentos = $conn->query('SELECT id, validacao FROM orcamento_id ORDER BY id DESC LIMIT 3');
?>
<!DOCTYPE html>
<html class="home" lang="pt-BR">
<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../styles/home-dono.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sua-integridade-aqui" crossorigin="anonymous"/>
</head>
<body class="home-body">
    <header class="tabs-home">
        <div class="box-imagem">
            <img class="logo-home" src="../images/logo.png" alt="">
            <div class="fundo-logo"></div>
        </div>

        <ul>
            <div class="atual"></div>
            <a href="home-dono.php">
                <li><i class="fas fa-home"></i> Home</li>
            </a>
            <a href="cadastro-funcionario-dono.php">
                <li><i class="fas fa-user-plus"></i> Cadastrar Funcionário</li>
            </a>
            <a href="cadastro-cliente-dono.php">
                <li><i class="fas fa-user-plus"></i></i> Cadastrar Cliente</li>
            </a>
            <a href="tarifas-dono.php">
                <li><i class="fas fa-file-invoice"></i> Tarifas</li>
            </a>
            <a href="preencherOrcamento-dono.php">
                <li><i class="fas fa-list-alt"></i> Preencher Orçamento</li>
            </a>
            <a href="lista-orcamento-dono.php">
                <li><i class="fas fa-check-circle"></i> Lista de Orçamentos</li>
            </a>
        </ul>

        <div class="opcoes">
            <div class="user">
                <div class="user-image">
                </div>
                <p>Usuário: Dono</p>
            </div>
            <a href="../php/logout.php"><button>Logout</button></a>
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
                        <li>Serviço #' . $contador . ' <a href="../pages/visualizacaoDeOrcamento.php?id=' . $orcamento["id"] . '" target="blank"><img src="../images/expandir.png"  width="30" height="30" alt=""></a></li>';
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