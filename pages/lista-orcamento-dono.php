<?php
    include('../php/conn.php');

    $sql_code = "SELECT id, tipo_servico FROM calculo_orcamento";
    $sql_query = $conn->query($sql_code) or die ("Erro ao consultar!");
?>

<!DOCTYPE html>
<html class="home" lang="pt-BR">
<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista orçamento</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sua-integridade-aqui" crossorigin="anonymous"/>
    <link rel="stylesheet" href="../styles/lista-orcamento-dono.css">
    <style>
        h1#titulo {
            padding-top: 0;
            margin-bottom: 10px;
        }
        .section-home {
            margin-left: 21em;
        }
        div.container {
            display: flex;
            width: 100%;
            margin-top: 20px;
            padding: 0 5em 0 5em;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        div.campos label {
            display: block;
            color: black;
            margin-left: 5px;
            font-size: .7em;
            margin-bottom: 3px;
        }

        div.campos input {
            background-color: #D9D9D9;
            border: none;
            height: 35px;
            border-radius: 10px;
            font-size: .9em;
            padding-left: 5px; 
        }

        div.campo1 input {
            width: 65%;
            font-size: .8em;
            
        }

        div.campo2 {
            margin-left: 5px;
        }
        div.campo2 input {
            width: 33em;
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        } 
    </style>
</head>
<body class="home-body">
    <header class="tabs-home" style="position: fixed; width: 23.41%;">
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
                <a href="tarifas-dono.php">
                    <li><i class="fas fa-file-invoice"></i> Tarifas</li>
                </a>
                <a href="preencherOrcamento-dono.php">
                    <li><i class="fas fa-list-alt"></i> Preencher orçamento</li>
                </a>
                <div class="atual"></div>
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
        <h1 id="titulo">Lista de orçamentos</h1>

        <h1>
        <?php 
            if (($sql_query->num_rows == 0)) {
                echo ("Não há nenhum orçamento no banco de dados...");
        ?>
        </h1>

        <?php
            }
            else {
                while (($dados = $sql_query->fetch_assoc())) {
                    echo '
                    <div class="container">
                        <div class="campos campo1">
                            <label>Id</label>
                            <input type="number" name="id" value="'. $dados['id'] .'" readonly>
                        </div>
                        <div class="campos campo2">
                            <label>Tipo do serviço</label>
                            <input type="text" name="tipo_servico" value="' . $dados['tipo_servico'] . '" readonly>
                        </div>
                    </div>';
                }
            };
        ?>
        
        
        <!-- <div class="container">
            <div class="campos campo1">
                <label>Id</label>
                <input type="number" name="id">
            </div>
            <div class="campos campo2">
                <label>Tipo do serviço</label>
                <input type="text" name="tipo_servico">
            </div>
        </div> -->
       
    </section>
</body>
</html>