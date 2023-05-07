<?php
    session_start();
    if (!isset($_SESSION['funcao']) || $_SESSION['funcao'] !== 'dono') {
        header('LOCATION: ../index.php');
    }
?>
<!DOCTYPE html>
<html class="home" lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/cadastro-funcionario-dono.css">
    <link rel="stylesheet" href="../styles/modal.css">
    <script src="https://kit.fontawesome.com/3bc1a873c3.js" crossorigin="anonymous"></script>
    <script src="../javascript/modal.js" defer></script>
    <script src="../javascript/modalSucesso.js" defer></script>
    <title>Cadastrar funcionário</title>
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
            width: 330px;
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
            border-radius: 50%;
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
<body class="home-body">    
    <header class="tabs-home">
        <div class="box-imagem">
            <img class="logo-home" src="../images/logo.png" alt="">
            <div class="fundo-logo"></div>
        </div>

        <ul>
            
            <a href="home-dono.php">
                <li><i class="fas fa-home"></i> Home</li>
            </a>
            <div class="atual"></div>
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
                <p>Usuário: Cliente</p>
            </div>
            <a href="../php/logout.php"><button>Logout</button></a>
        </div>
    </header>

    <section class="section-home">
        <h1>Cadastrar Funcionário</h1>

        <form action="../php/cadastro-funcionario.php" class="form-cadastro-funcionario" method="post" onsubmit="return valida()" id="formulario">
            <div class="inputs-grande">
                <label for="NOME">Nome Completo</label>
                <input type="text" name="NOME" id="NOME" placeholder="Nome completo do funcionário" required>
            </div>
            <div class="inputs-grande">
                <label for="EMAIL">Email</label>
                <input type="email" name="EMAIL" id="EMAIL" placeholder="Email do funcionário" required>
            </div>
            <div class="inputs-medio">
                <div class="input-medio">
                    <label for="SENHA">Senha</label>
                    <input  class="input-esquerdo" type="password" name="SENHA" id="SENHA" placeholder="Digite a senha" minlength="8" maxlength="16" required>
                </div>                
                <div class="input-medio">
                    <label for="DATANASC">Data de Nascimento</label>
                    <input class="input-direito" type="date" name="DATANASC" id="DATANASC" required>
                </div>
            </div>
            <div class="inputs-medio">
                <div class="input-medio">
                    <label for="SENHACONFIRM">Confirmar Senha</label>
                    <input  class="input-esquerdo" type="password" name="SENHACONFIRM" id="SENHACONFIRM"  placeholder="Confirme a senha" minlength="8" maxlength="16" required>
                </div>    
            
                <div class="input-medio">
                    <button type="button" id="open-modal">CADASTRAR</button>
                </div>
            
            </div>
            
            <!--MODAL-->
            <div id="fade" class="hide"></div>
            <div id="modal" class="hide">
                <div class="modal-header">
                    <button type="button" id="close-modal">X</button>
                </div>
                <div class="modal-body">
                    <h2 class="texto">Você deseja confirmar o cadastro do funcionário?</h2>
                    <div class="alinhando-buttons">
                        <button class="confirmar-modal" type="submit" name="confirmar">Confirmar</button>
                        <button type="button" class="fechar-modal">Negar</button>
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
                    <p>Funcionário cadastrado com sucesso!</p>
                </div>
                <button type="button" id="botao-fechar">X</button>
            </footer>';
            $_SESSION["confirmar"] = '';
        };
    ?>
</body>
</html>