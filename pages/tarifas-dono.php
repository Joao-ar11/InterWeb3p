<?php 
    session_start();
    if (!isset($_SESSION['funcao']) || $_SESSION['funcao'] !== 'dono') {
        header('LOCATION: ../index.php');
    }
    include('../php/conn.php');
    if (isset($_POST["taxaAdm"]) && isset($_POST["lucro"]) && isset($_POST["seguro-civil"]) && isset($_POST["imposto"]) && isset($_POST["seguro-garantia"])) {
        $query = 'INSERT INTO tarifa (taxa_administrativa, seguro_respon_civil, seguro_garantia, lucro, imposto) VALUES ("' . $_POST['taxaAdm'] . '", "' . $_POST['seguro-civil'] . '", "' . $_POST['seguro-garantia'] . '", "' . $_POST['lucro'] . '", "' . $_POST['imposto'] . '")';
        $conn->query($query);
    }
    $query = 'SELECT * FROM tarifa WHERE (SELECT MAX(id_tarifa) FROM tarifa);';
    $resultado = $conn->query($query);
    $taxa_adm = '0%';
    $lucro = '0%';
    $seguro_civil = '0%';
    $imposto = '0%';
    $seguro_garantia = '0%';
    while ($tarifas_atuais = $resultado->fetch_assoc()) {
        $taxa_adm = $tarifas_atuais['taxa_administrativa'];
        $lucro = $tarifas_atuais['lucro'];
        $seguro_civil = $tarifas_atuais['seguro_respon_civil'];
        $imposto = $tarifas_atuais['imposto'];
        $seguro_garantia = $tarifas_atuais['seguro_garantia'];
    }
?>
<!DOCTYPE html>
<html class="home" lang="pt-BR">
<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarifas</title>
    <link rel="stylesheet" href="../styles/tarifas-dono.css">
    <link rel="stylesheet" href="../styles/modal.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sua-integridade-aqui" crossorigin="anonymous"/>
    <script src="../javascript/modal.js" defer></script>
</head>
<body class="tarifas-body">
    <header class="tabs-home">
        <div class="box-imagem">
            <img class="logo-home" src="../images/logo.png" alt="">
            <div class="fundo-logo"></div>
        </div>

        <ul>
            <a href="home-dono.php">
                <li><i class="fas fa-home"></i> Home</li>
            </a>
            <a href="cadastro-funcionario-dono.php">
                <li><i class="fas fa-user-plus"></i> Cadastrar funcionário</li>
            </a>
            <a href="cadastro-cliente-dono.php">
                <li><i class="fas fa-user-plus"></i></i> Cadastrar cliente</li>
            </a>
            <div class="atual"></div>
            <a href="tarifas-dono.php">
                <li><i class="fas fa-file-invoice"></i> Tarifas</li>
            </a>
            <a href="preencherOrcamento-dono.php">
                <li><i class="fas fa-list-alt"></i> Preencher orçamento</li>
            </a>
            <a href="lista-orcamento-dono.php">
                <li><i class="fas fa-check-circle"></i> Lista de orçamentos</li>
            </a>
        </ul>
        
        <div class="user">
            <div class="user-image">
                
            </div>
            <p>Usuário: Dono</p>
        </div>
    </header>

    <section class="section-home">
        <h1>Tarifas</h1>
        <form action="#" method="post">
            <div class="grid-input">
                <div class="campo">
                    <label for="taxataxaAdm">Taxa Adminstrativa:</label>
                    <input type="text" id="taxa" name="taxaAdm" pattern="\d+%" value=<?php echo '"' . $taxa_adm . '"'?> placeholder="Insira a taxa" required>
                </div>
    
                <div class="campo">
                    <label for="lucro">Lucro:</label>
                    <input type="text" id="lucro" name="lucro" value=<?php echo '"' . $lucro . '"'?> placeholder="Insira o lucro previsto" pattern="\d+%" required>
                </div>
                
                <div class="campo">
                    <label for="seguro-civil">Seguro Respon. Civil:</label>
                    <input type="text" id="seguro-civil" name="seguro-civil" value=<?php echo '"' . $seguro_civil . '"'?> placeholder="Insira a taxa" pattern="\d+%" required>
                </div>
    
                <div class="campo">
                    <label for="impostos">Impostos:</label>
                    <input type="text" id="impostos" name="imposto" value=<?php echo '"' . $imposto . '"'?> placeholder="Insira o Imposto" pattern="\d+%" required>
                </div>

                <div class="campo">
                    <label for="seguro-garantia">Seguro Garantia:</label>
                    <input type="text" id="seguro-garantia" placeholder="Insira a taxa" value=<?php echo '"' . $seguro_garantia . '"'?> name="seguro-garantia" pattern="\d+%" required>
                </div>
    
                <button type="button" id="open-modal">Salvar Fórmula</button>
        </div>

            <!--MODAL-->
           <div id="fade" class="hide"></div>
           <div id="modal" class="hide">
               <div class="modal-header">
                   <button type="button" id="close-modal">X</button>
               </div>
               <div class="modal-body">
                   <h2 class="texto">Você deseja confirmar o cadastro das tarifas?</h2>
                   <div class="alinhando-buttons">
                       <button class="confirmar-modal" type="submit">Confirmar</button>
                       <button type="button" class="fechar-modal" >Negar</button>
                   </div>
               </div>
           </div>
        </form>
    </section>
</body>
</html>