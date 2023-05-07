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
    <link rel="stylesheet" href="../styles/cadastro-cliente-dono.css">
    <link rel="stylesheet" href="../styles/modal.css">
    <script src="https://kit.fontawesome.com/3bc1a873c3.js" crossorigin="anonymous"></script>
    <script src="../javascript/modal.js" defer></script>
    <script src="../javascript/modalSucesso.js" defer></script>
    <title>Cadastrar cliente</title>
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
    <header class="tabs-home"> <!-- BARRA LATERAL -->
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
            <div class="atual"></div>
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

    <section class="section-home" > <!-- CONTEUDO PRINCIPAL -->
        <h1>Cadastrar Cliente</h1>
        
        <form action="../php/cadastro-cliente-dono.php" method="post" onsubmit="return valida()" id="formulario"> <!-- INPUTS - FORMULÁRIO -->

            <div class="input-grande" >
               <label for="NOME">Nome da empresa</label>
               <input type="text" name="nome" id="NOME" placeholder="Digite o nome da empresa" required>
            </div>

            <div class="campos-medios">
                <div>
                    <label for="CNPJ">CNPJ</label>
                    <input type="text" name="cnpj" id="CNPJ" required title="Faça igual ao exemplo: 81434946000168" placeholder="Ex: 81434946000168" minlength="14" maxlength="14" pattern="([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})"> <!-- Regex ok --> 
                </div>
                <div>
                    <label for="CONTATO">Contato</label>
                    <input type="tel" name="contato" id="CONTATO" required title="Faça igual ao exemplo: 8137420865 (fixo) 81980012855 (celular)" placeholder="Ex: 8137420865 (fixo) 81980012855 (celular)" minlength="10" maxlength="11" pattern="(\([0-9]{2}\)\s?[0-9]{4,5}-?[0-9]{3,4})|([0-9]{10,11})|([0-9]{2}\s?[0-9]{8,9})"> <!--Regex ok-->
                </div>
            </div>

            <div class="campos-medios">
                <div>
                    <label for="ENDERECO">Endereço</label>
                    <input type="text" name="endereco" id="ENDERECO" placeholder="Ex: Rua da Aurora" required>
                </div>
                <div>
                    <label for="EMAIL">Email</label>
                    <input type="email" name="email" id="EMAIL" placeholder="Digite o email" required>
                </div>
            </div>
            
            
            <div class="campos-segunda-fileira">
                <div class="campos-pequenos">
                    <div class="input-pequeno">
                        <label for="BAIRRO">Bairro</label>
                        <input type="text" name="bairro" id="BAIRRO" placeholder="Digite o bairro" required>
                    </div>
                
                    <div class="input-pequeno">
                        <label for="N-ENDERECO">Nº</label>
                        <input type="text" name="n-endereco" id="N-ENDERECO" required>
                    </div>
                </div>
                <div class="complemento">
                    <label for="COMPLEMENTO">Complemento</label>
                    <input type="text" name="complemento" id="COMPLEMENTO" required>
                </div>
            </div>

            <div class="campos-medios" style="margin-top: 10px;">
                <div>
                    <label for="SENHA">Senha</label>
                    <input type="password" name="senha" id="SENHA" minlength="8" maxlength="16" placeholder="Digite a senha" required>
                </div>
                <div>
                    <label for="CONFIRMAR-SENHA">Confirmar senha</label>
                    <input type="password" name="confirmar-senha" id="CONFIRMAR-SENHA" minlength="8" maxlength="16" placeholder="Confirme a senha" required>
                </div>
            </div>

           <div class="botoes" > <!-- BOTOES CANCELAR E CONFIRMAR -->
               <button type="reset">Limpar</button>
               
               <button type="button" id="open-modal">Confirmar</button>
               
           </div>
          
           

           <!--MODAL-->
           <div id="fade" class="hide"></div>
           <div id="modal" class="hide">
               <div class="modal-header">
                   <button type="button" id="close-modal">X</button>
               </div>
               <div class="modal-body">
                   <h2 class="texto">Você deseja confirmar o cadastro do cliente?</h2>
                   <div class="alinhando-buttons">
                       <button class="confirmar-modal" type="submit" style="background-color: rgb(0, 197, 0);" name="confirmar">Confirmar</button>
                       <button type="button" class="fechar-modal" >Negar</button>
                   </div>
               </div>
           </div>
        </form>
    </section>
    
    <?php
        if (isset($_POST["confirmar"])) {
            echo '
            <!-- Modal Sucesso -->
            <footer>
                <div id="confirmacao">
                    <i class="fa-solid fa-circle-check"></i>
                    <p>Cliente cadastrado com sucesso!</p>
                </div>
                <button type="button" id="botao-fechar">X</button>
            </footer>';
        };
    ?>
</body>
</html>