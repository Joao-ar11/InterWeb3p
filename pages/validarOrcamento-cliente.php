<?php
    session_start();
    if (!isset($_SESSION['funcao']) || $_SESSION['funcao'] !== 'cliente') {
        header('LOCATION: ../index.php');
    }
    include '../php/conn.php';
    $query = 'SELECT id FROM orcamento_id WHERE validacao="em validação" AND id_cliente=' . $_SESSION['id'];
    $resposta = $conn->query($query);
?>
<!DOCTYPE html>
<html class="home" lang="pt-BR">
<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar orçamento</title>
    <link rel="stylesheet" href="../styles/validarOrcamento-cliente.css">
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
            <a href="visualizarOrcamento-cliente.php">
                <li><i class="fa-solid fa-file-contract"></i> Visualizar Orçamento</li>
            </a>
            <div class="atual"></div>
            <a href="validarOrcamento-cliente.php">
                <li><i class="fa-solid fa-circle-check"></i> Validar Orçamento</li>
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
            <div class="lista">
                <?php
                $contador =  1;
                    while ($orcamento = $resposta->fetch_assoc()){
                        echo '<div class="linha-servico">
                            <div class="servico">Serviço #' . $contador . ' <a href="./visualizacaoDeOrcamento.php?id=' . $orcamento["id"] . '"><img src="../images/expandir.png"  width="30" height="30" alt=""></a></div>
                            <div class="botoes">
                                <a href="../php/validarOrcamento.php?id=' . $orcamento["id"] . '&validacao=confirmado"><button class="btn-confirmar">Confirmar</button></a>
                                <a href="../php/validarOrcamento.php?id=' . $orcamento["id"] . '&validacao=negado"><button class="btn-negar">Negar</button></a>
                            </div>
                        </div>';
                        $contador++;
                    }
                ?>
            </div>
        <div style="display: flex; align-items: center;">
            <button id="more">Ver mais <img id="seta" src="../images/seta-para-baixo.png"></button>
        </div>
    </section>
</body>
</html>