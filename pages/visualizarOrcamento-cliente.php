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
            <div>
                <li>Serviço #0001 <a href="#"><img src="../images/expandir.png"  width="30" height="30" alt=""></a></li>
                <p class="status01">Em validação</p>
            </div>
            <div>
                <li>Serviço #0002 <a href="#"><img src="../images/expandir.png"  width="30" height="30" alt=""></a></li>
                <p class="status02">Em execução</p>
            </div>
            <div>
                <li>Serviço #0003 <a href="#"><img src="../images/expandir.png"  width="30" height="30" alt=""></a></li>
                <p class="status03">Finalizado</p>
            </div>
        </ul>
        <div style="display: flex; align-items: center;">
            <button id="more">Ver mais <img id="seta" src="../images/seta-para-baixo.png"></button>
        </div>
    </section>
</body>
</html>