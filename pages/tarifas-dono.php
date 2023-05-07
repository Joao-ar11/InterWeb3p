<?php 
    session_start();
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
    <script src="https://kit.fontawesome.com/3bc1a873c3.js" crossorigin="anonymous"></script>
    <script src="../javascript/modal.js" defer></script>
    <script src="../javascript/modalSucesso.js" defer></script>
    <style>
        footer {
            position: absolute;
            right: 0;
            bottom: 20px;
            margin-right: 3em;
        }
        div#confirmacao {
            display: flex;
            align-items: center;
            background-color: #00FF7F;
            width: 300px;
            height: 50px;
            border-radius: 5px;
            justify-content: center;
            display: none;
            z-index: 10000;
            padding: 10px; /* adicionado */
        }

        div#confirmacao i {
            margin-right: 10px;
        }

        div#confirmacao p {
            padding-bottom: 1px;
            font-family: Arial, Helvetica, sans-serif;
            
        }

        button#botao-fechar {
            width: 28px;
            height: 28px;
            position: absolute;
            right: -10px;
            bottom: 35px;
            background-color: #D9D9D9;
            border: none; /* adicionado */
            cursor: pointer; /* adicionado */
            display: none;
        }

        button#botao-fechar:hover {
            transform: scale(1.08);
            transition: .2s;
            background-color: #A9A9A9;
        }
    </style>
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
                <li><i class="fas fa-user-plus"></i> Cadastrar Funcionário</li>
            </a>
            <a href="cadastro-cliente-dono.php">
                <li><i class="fas fa-user-plus"></i></i> Cadastrar Cliente</li>
            </a>
            <div class="atual"></div>
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
                <p>Usuário: Cliente</p>
            </div>
            <a href="../php/logout.php"><button>Logout</button></a>
        </div>
    </header>

    <section class="section-home">
        <h1>Tarifas</h1>
        <form action="../php/tarifas.php" method="post" id="formulario">
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
                       <button class="confirmar-modal" type="submit" name="confirmar">Confirmar</button>
                       <button type="button" class="fechar-modal" >Negar</button>
                   </div>
               </div>
           </div>
        </form>
    </section>

    <?php
        if (isset($_SESSION["confirmar"]) && $_SESSION['confirmar'] === 'confirmado') {
            echo '
            <!-- Modal Sucesso -->
            <footer>
                <div id="confirmacao">
                    <i class="fa-solid fa-circle-check"></i>
                    <p>Tarifas salvas com sucesso!</p>
                </div>
                <button type="button" id="botao-fechar">X</button>
            </footer>';
            $_SESSION['confirmar'] = '';
        };
    ?>
</body>
</html>