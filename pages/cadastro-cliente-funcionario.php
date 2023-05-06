<?php
    session_start();
    if (!isset($_SESSION['funcao']) || $_SESSION['funcao'] !== 'funcionario') {
        header('LOCATION: ../index.php');
    }
?>
<!DOCTYPE html>
<html class="home" lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/cadastro-cliente-funcionario.css">
    <link rel="stylesheet" href="../styles/modal.css">
    <script src="https://kit.fontawesome.com/3bc1a873c3.js" crossorigin="anonymous"></script>
    <title>Cadastrar cliente</title>
    <script src="../javascript/modal.js" defer></script>
<body class="home-body">    
    <header class="tabs-home"> <!-- BARRA LATERAL -->
        <div class="box-imagem">
            <img class="logo-home" src="../images/logo.png" alt="">
            <div class="fundo-logo"></div>
        </div>

        <ul class="navbar">
            <a href="home-funcionario.php">
                <li><i class="fas fa-home"></i> Home</li>
            </a>
            <div class="atual"></div>
            <a href="#">
                <li><i class="fas fa-user-plus"></i> Cadastrar Cliente</li>
            </a>
            <a href="preencherOrcamento-funcionario.php">
                <li><i class="fa-solid fa-file-signature"></i> Preencher Orçamento</li>
            </a>
            <a href="lista-orcamento-funcionario.php">
                <li><i class="fas fa-list"></i> Lista de orçamentos</li>
            </a>
        </ul>
        

        <div class="user">
            <div class="user-image">
            </div>
            <p>Usuário: Funcionário</p>
        </div>

    </header>

    <section class="section-home" > <!-- CONTEUDO PRINCIPAL -->
        <h1>Cadastrar Cliente</h1>
        
        <form action="../php/cadastro-cliente-funcionario.php" method="post" onsubmit="return valida()"> <!-- INPUTS - FORMULÁRIO -->

            <div class="input-grande" >
               <label for="NOME">Nome da empresa</label>
               <input type="text" name="nome" id="NOME" placeholder="Digite o nome da empresa" required>
            </div>

            <div class="campos-medios">
                <div>
                    <label for="CNPJ">CNPJ</label>
                    <input type="text" name="cnpj" id="CNPJ" required pattern="([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})" placeholder="Ex: 81434946000168" title="Faça igual ao exemplo: 81434946000168" minlength="14" maxlength="14"> <!--regex ok-->
                </div>
                <div>
                    <label for="CONTATO">Contato</label>
                    <input type="tel" name="contato" id="CONTATO" required pattern="(\([0-9]{2}\)\s?[0-9]{4,5}-?[0-9]{3,4})|([0-9]{10,11})|([0-9]{2}\s?[0-9]{8,9})" title="Faça igual ao exemplo: 8137420865 (fixo) 81980012855 (celular)" placeholder="Ex: 8137420865 (fixo) 81980012855 (celular)" minlength="10" maxlength="11"> <!--regex ok-->
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
               <button type="reset">Cancelar</button>
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
                       <button class="confirmar-modal" type="submit">Confirmar</button>
                       <button type="button" class="fechar-modal">Negar</button>
                   </div>
               </div>
           </div>
        </form>
        
    </section>
    <script type="text/javascript">
        function valida(){
            if(grecaptcha.getResponse() ==''){
                alert('VOCE PRECISA MARCAR A VALIDACAO');
                return false;
            }
        }
       </script>

</body>
</html>