<?php
    session_start();
    if (!isset($_SESSION['funcao']) || $_SESSION['funcao'] !== 'funcionario') {
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
    <title>Home funcionário</title>
    <link rel="stylesheet" href="../styles/home-funcionario.css">
    <script src="https://kit.fontawesome.com/3bc1a873c3.js" crossorigin="anonymous"></script>
</head>
<body class="home-body">
    <header class="tabs-home">
        <div class="box-imagem">
            <img class="logo-home" src="../images/logo.png" alt="">
            <div class="fundo-logo"></div>
        </div>

        <ul class="navbar">
            <div class="atual"></div>
            <a href="#">
                <li><i class="fas fa-home"></i> Home</li>
            </a>
            <a href="cadastro-cliente-funcionario.php">
                <li><i class="fas fa-user-plus"></i> Cadastrar Cliente</li>
            </a>
            <a href="preencherOrcamento-funcionario.php">
                <li><i class="fa-solid fa-file-signature"></i> Preencher Orçamento</li>
            </a>
            <a href="lista-orcamento-funcionario.php">
                <li><i class="fas fa-list"></i> Lista de Orçamentos</li>
            </a>
        </ul>

        <div class="opcoes">
            <div class="user">
                <div class="user-image">
                </div>
                <p>Usuário: Cliente</p>
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