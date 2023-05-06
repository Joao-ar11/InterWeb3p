<?php 
    include('../php/conn.php');
    session_start();
    if (!isset($_SESSION['funcao']) || $_SESSION['funcao'] !== 'funcionario') {
        header('LOCATION: ../index.php');
    }
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
    $query = 'SELECT id FROM orcamento_id';
    $numero_orcamento = $conn->query($query)->num_rows + 1;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/preencherOrcamento-funcionario.css">
    <link rel="stylesheet" href="../styles/modal.css">
    <script src="https://kit.fontawesome.com/3bc1a873c3.js" crossorigin="anonymous"></script>
    <script src="../javascript/preencherOrcamento.js" defer></script>
    <script src="../javascript/modal.js" defer></script>
    <title>Preencher Orçamento</title>
</head>
<body>
    <div class="pagina">
        <header class="tabs-home">
            <div class="menu">
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
                    <div class="atual"></div>
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
            </div>
        </header>
        <section>
            <h1>Orçamento</h1>
            <form action="../php/orcamento-funcionario.php" method="post">
                <div class="orcamento-meta">
                    <div class="campo">
                        <label for="data-atual">Data:</label>
                        <input type="date" name="data" placeholder="dd/mm/yyyy" id="data-atual" class="data-atual" value="">
                    </div>
                    <div class="ids">
                        <div class="campo">
                            <label for="orcamento-numero">Orçamento Nᵒ</label>
                            <input type="text" id="orcamento-numero" name="orcamento-numero" value="<?php echo $numero_orcamento;?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="informacoes">
                    <h2>Informações do Cliente</h2>
                    <div class="campo">
                        <label for="cliente">Cliente</label>
                        <input type="text" id="cliente" name="cliente">
                    </div>
                    <div class="campo">
                        <label for="setor">Setor</label>
                        <input type="text" id="setor" name="setor">
                    </div>
                    <div class="campo">
                        <label for="endereco">Endereço</label>
                        <input type="text" id="endereco" name="endereco">
                    </div>
                    <div class="campo">
                        <label for="cidade">Cidade</label>
                        <input type="text" id="cidade" name="cidade">
                    </div>
                    <div class="contato-cliente">
                        <div class="campo">
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email">
                        </div>
                        <div class="campo">
                            <label for="whatsapp">Whatsapp</label>
                            <input type="text" id="whatsapp" name="whatsapp">
                        </div>
                    </div>
                </div>
                <div class="servico">
                    <h2>Serviço</h2>
                    <div class="campo">
                        <label for="tipo-servico">Tipo de serviço</label>
                        <input type="text" id="tipo-servico" name="tipo-servico">
                    </div>
                    <div class="campo">
                        <label for="descricao-servico">Descrição detalhada do serviço</label>
                        <textarea name="descricao-servico" id="descricao-servico"></textarea>
                    </div>
                    <div class="campo">
                        <label for="limitacao-servico">Limitações do serviço</label>
                        <textarea name="limitacao-servico" id="limitacao-servico"></textarea>
                    </div>
                </div>
                <div class="itens">
                    <h2>Itens</h2>
                    <div id="linha-itens-nomes">
                        <div class="campo item">
                            <label>Item</label>
                        </div>
                        <div class="campo quant">
                            <label>Quant</label>
                        </div>
                        <div class="campo material-servico">
                            <label>Material - Serviço</label>
                        </div>
                        <div class="campo preco-unitario">
                            <label>Unidade</label>
                        </div>
                        <div class="campo">
                            <label>Preço final</label>
                        </div>
                    </div>
                    <div class="controle-campos">
                        <div class="adicionar-campos">
                            <button type="button" id="adicionar-campos-itens">+</button>
                            <label for="adicionar-campos-itens"> Adicionar mais campos</label>
                        </div>
                        <div class="remover-campos">
                            <button type="button" id="remover-campos-itens">-</button>
                            <label for="remover-campos-itens"> Remover último campo</label>
                        </div>
                    </div>
                    <div class="valor-total-itens">
                        <label for="valor-total-itens">Valor total dos Itens</label>
                        <input type="text" id="valor-total-itens" name="valor-total-itens" readonly>
                    </div>
                </div>
                <div class="mao-de-obra">
                    <h2>Mão de obra</h2>                    
                    <div id="linha-mo-nomes">
                        <div class="campo mo">
                            <label for="profissional">Profissional</label>
                        </div>
                        <div class="campo mo">
                            <label for="pessoas">Pessoas</label>
                        </div>
                        <div class="campo mo">
                            <label for="dias">Dias</label>
                        </div>
                        <div class="campo mo">
                            <label for="preco-dia">Dias R$</label>
                        </div>
                        <div class="campo mo">
                            <label for="horas">Horas</label>
                        </div>
                        <div class="campo mo">
                            <label for="preco-horas">Horas R$</label>
                        </div> 
                    </div>
                    <div class="controle-campos">
                        <div class="adicionar-campos">
                            <button type="button" id="adicionar-campos-mo">+</button>
                            <label for="adicionar-campos-mo"> Adicionar mais campos</label>
                        </div>
                        <div class="remover-campos">
                            <button type="button" id="remover-campos-mo">-</button>
                            <label for="remover-campos-mo"> Remover último campo</label>
                        </div>
                    </div>
                </div>
                <div class="taxas">
                    <h2>Taxas</h2>
                    <div class="linha-taxa">
                        <p class="valorFixo">Mão de Obra</p>
                        <input type="text" id="mo-total" name="mo-total" readonly>
                    </div>
                    <div class="linha-taxa">
                        <p class="valorFixo">Deslocamento</p>
                        <input type="text" id="deslocamento" name="deslocamento" readonly>
                    </div>
                    <div class="linha-taxa">
                        <p>Seguro Garantia</p>
                        <p id="taxa-seguro-garantia"><?php echo $seguro_garantia?></p>
                        <input type="text" id="seguro-garantia" class="taxa" name="seguro-garantia" value="R$0.00" readonly>
                    </div>
                    <div class="linha-taxa">
                        <p>Seguro Respon. Civil</p>
                        <p id="taxa-seguro-civil"><?php echo $seguro_civil?></p>
                        <input type="text" id="seguro-civil" class="taxa" name="seguro-civil" value="R$0.00" readonly>
                    </div>
                    <div class="linha-taxa">
                        <p>TX Administrativa</p>
                        <p id="taxa-admin"><?php echo $taxa_adm?></p>
                        <input type="text" id="admin-valor" class="taxa" name="admin-valor" value="R$0.00" readonly>
                    </div>
                    <div class="linha-taxa">
                        <p>Lucro</p>
                        <p id="taxa-lucro"><?php echo $lucro?></p>
                        <input type="text" id="lucro-valor" class="taxa" name="lucro-valor" value="R$0.00" readonly>
                    </div>
                    <div class="linha-taxa">
                        <p>Impostos</p>
                        <p id="taxa-impostos"><?php echo $imposto?></p>
                        <input type="text" id="impostos-valor" class="taxa" name="impostos-valor" value="R$0.00" readonly>
                    </div>
                    <div class="linha-taxa desconto">
                        <p>Desconto</p>
                        <input type="text" id="taxa-desconto" name="taxa-desconto">
                        <input type="text" id="desconto-valor" name="desconto-valor" value="- R0.00"readonly>
                    </div>
                </div>
                <div class="profissionais">
                    <h2>Nome dos Profissionais</h2>
                    <div class="linha-prof">
                        <p>Nome:</p>
                        <input type="text" name="nome-profissional1">
                        <p>CFT/CREA:</p>
                        <input type="text" name="cft-crea1">
                    </div>
                    <div class="linha-prof">
                        <p>Nome:</p>
                        <input type="text" name="nome-profissional2">
                        <p>CFT/CREA:</p>
                        <input type="text" name="cft-crea2">
                    </div>
                    <div class="controle-campos">
                        <div class="adicionar-campos">
                            <button type="button" id="adicionar-campos-prof">+</button>
                            <label for="adicionar-campos-prof"> Adicionar mais campos</label>
                        </div>
                        <div class="remover-campos">
                            <button type="button" id="remover-campos-prof">-</button>
                            <label for="remover-campos-prof"> Remover último campo</label>
                        </div>
                    </div>
                </div>
                <div class="pagamento">
                    <h2>Formas de Pagamento</h2>
                    <div class="banco">
                        <div class="campo2">
                            <label for="banco">Banco:</label>
                            <input type="text" id="banco" name="banco">
                        </div>
                        <div class="campo2">
                            <label for="agencia">Agência:</label>
                            <input type="text" id="agencia" name="agencia">
                        </div>
                        <div class="campo2">
                            <label for="conta-corrente">Conta Corrente</label>
                            <input type="text" id="conta-corrente" name="conta-corrente">
                        </div>
                    </div>
                    <div class="campo2">
                        <label for="pix">PIX:</label>
                        <input type="text" id="pix" name="pix">
                    </div>
                    <div class="campo2">
                        <label for="email-local">Email:</label>
                        <input type="email" id="email-local" name="email-local" value="placeservicos@gmail.com">
                    </div>
                </div>
                <div class="valor-total">
                    <h2>Deslocamento</h2>
                    <div class="campo2">
                        <label for="distancia">Distância</label>
                        <input type="number" id="distancia" name="distancia">
                    </div>
                    <div class="campo2">
                        <label for="distancia-valor">Valor / KM</label>
                        <input type="text" id="distancia-valor" name="distancia-valor">
                    </div>
                    <h2>Valor total</h2>
                    <input id="valor-total" type="text" name="valor-total" value="R$00.00" readonly>
                </div>
                <div class="observacoes">
                    <h2>Observações</h2>
                    <div class="campo-observacoes">
                        <label for="observacao1">1 - Se o serviço não por problemas estruturais do imóvel ou outro de responsabilidade do cliente, este deverá pagar o valor referente á visita técnica, frete e logística do serviço programado.</label>
                        <input type="text" id="observacao1" name="observacao1">
                    </div>
                    <div class="campo-observacoes">
                        <label for="observacao2">2 - Caso haja desistência e cancelamento do serviço, o cliente deverá pagar o valor da compra de material e insumos e multa de 20% do valor do serviço.
                        </label>
                        <input type="text" id="observacao2" name="observacao2" readonly>
                    </div>
                    <div class="campo-observacoes">
                        <label for="observacao3">3 - O Cliente pagará o valor antecipado como adiantamento e garantia da execuação do serviço, compra de materiais e insumos, no valor de:
                        </label>
                        <input type="text" id="observacao3" name="observacao3">
                    </div>
                </div>
                <div class="prazos">
                    <h2>Prazos</h2>
                    <label for="validade-orcamento">Quantidade de dias do Prazo de validade do Orçamento:</label>
                    <input type="date" id="validade-orcamento" name="validade-orcamento">
                    <label for="data-servico">Data do serviço:</label>
                    <input type="date" id="data-servico" name="data-servico">
                    <label for="horario">Horário:</label>
                    <input type="text" id="horario" name="horario">
                </div>
                <button class="submit" type="button" id="open-modal">Enviar Formulário</button>

                <!--MODAL-->
                <div id="fade" class="hide"></div>
                <div id="modal" class="hide">
                    <div class="modal-header">
                        <button type="button" id="close-modal">X</button>
                    </div>
                    <div class="modal-body">
                        <h2 class="texto">Você deseja confirmar o cadastro do orçamento?</h2>
                        <div class="alinhando-buttons">
                            <button class="confirmar-modal" type="submit">Confirmar</button>
                            <button type="button" class="fechar-modal">Negar</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</body>
</html>