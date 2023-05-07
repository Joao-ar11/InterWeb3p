<?php
    session_start();
    if (!isset($_SESSION['funcao']) || $_SESSION['funcao'] !== 'funcionario') {
        header('LOCATION: ../index.php');
    }
    include('../php/conn.php');

    $sql_code = "SELECT id, tipo_servico FROM orcamento_id";
    $sql_query = $conn->query($sql_code) or die ("Erro ao consultar!");
?>

<!DOCTYPE html>
<html class="home" lang="pt-BR">
<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Orçamento</title>
    <script src="https://kit.fontawesome.com/3bc1a873c3.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../styles/lista-orcamento-funcionario.css">
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

        ul.navbar {
            height: 100%;
            margin-top: 4em;
        }
    </style>
</head>
<body class="home-body">
    <header class="tabs-home" style="position: fixed; width: 23.41%;">
        <div class="box-imagem">
            <img class="logo-home" src="../images/logo.png" alt="">
            <div class="fundo-logo"></div>
        </div>

        <ul class="navbar">
            <a href="home-funcionario.php">
                <li><i class="fas fa-home"></i> Home</li>
            </a>
            <a href="cadastro-cliente-funcionario.php">
                <li><i class="fas fa-user-plus"></i> Cadastrar Cliente</li>
            </a>
            <a href="preencherOrcamento-funcionario.php">
                <li><i class="fa-solid fa-file-signature"></i> Preencher Orçamento</li>
            </a>
            <div class="atual"></div>
            <a href="lista-orcamento-funcionario.php">
                <li><i class="fas fa-list"></i> Lista de orçamentos</li>
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
        <h1 id="titulo">Lista de Orçamentos</h1>

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
        
<!--         
        <div class="container">
            <div class="campos campo1">
                <label>Id</label>
                <input type="number" name="id">
            </div>
            <div class="campos campo2">
                <label>Tipo do serviço</label>
                <input type="text" name="tipo_servico">
            </div>
        </div>
        -->
    </section>
</body>
</html>