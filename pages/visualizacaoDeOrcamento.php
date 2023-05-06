<?php
    include("../php/conn.php");
    $id = $_GET['id'];
    $tipo_servico = '';
    $descricao_servico = '';
    $limitacao_servico = '';
    $query = 'SELECT * FROM orcamento_id WHERE id=' . $id . ';';
    $resultado = $conn->query($query);
    while ($row = $resultado->fetch_assoc()) {
        $tipo_servico = $row['tipo_servico'];
        $descricao_servico = $row['descricao_servico'];
        $limitacao_servico = $row['limitacao_servico'];
    }
    $query = 'SELECT * FROM calculo_orcamento WHERE id=' . $id . ';';
    $resultado = $conn->query($query);
    $id_orcamento = '';
    $valor_total = '';
    $data = '';
    $valor_total_itens = '';
    $valor_total_MO = '';
    while ($row = $resultado->fetch_assoc()) {
        $id_orcamento = $row['id'];
        $valor_total = $row['resultado'];
        $data = $row['ddata'];
        $valor_total_itens = $row['valor_total_itens'];
        $valor_total_MO = $row['valor_total_MO'];
    }
    $query = 'SELECT * FROM frete WHERE id_orcamento=' . $id . ';';
    $resultado = $conn->query($query);
    $distancia = '';
    $distancia_valor = '';
    $valor_total_deslocamento = '';
    while ($row = $resultado->fetch_assoc()) {
        $distancia = $row['distancia'];
        $distancia_valor = $row['distancia_valor'];
        $valor_total_deslocamento = $row['valor_total_deslocamento'];
    }
    $query = 'SELECT * FROM prazos WHERE id_orcamento=' . $id . ';';
    $resultado = $conn->query($query);
    $validade_orcamento = '';
    $data_servico = '';
    $horario = '';
    while ($row = $resultado->fetch_assoc()) {
        $validade_orcamento = $row['validade_orcamento'];
        $data_servico = $row['data_servico'];
        $horario = $row['horario'];
    }
    $query = 'SELECT * FROM observacao WHERE id_orcamento=' . $id . ';';
    $resultado = $conn->query($query);
    $observacao1 = '';
    $observacao2 = '';
    $observacao3 = '';
    while ($row = $resultado->fetch_assoc()) {
        $observacao1 = $row['observacao1'];
        $observacao2 = $row['observacao2'];
        $observacao3 = $row['observacao3'];
    }
    $query = 'SELECT * FROM taxa WHERE id_orcamento=' . $id . ';';
    $resultado = $conn->query($query);
    $id_tarifa = '';
    $seguro_garantia = '';
    $seguro_civil = '';
    $admin_valor = '';
    $lucro_valor = '';
    $impostos_valor = '';
    $desconto_taxa = '';
    $desconto_valor = '';
    while ($row = $resultado->fetch_assoc()) {
        $id_tarifa = $row['id_tarifa'];
        $seguro_garantia = $row['seguro_garantia'];
        $seguro_civil = $row['seguro_civil'];
        $admin_valor = $row['admin_valor'];
        $lucro_valor = $row['lucro_valor'];
        $impostos_valor = $row['impostos_valor'];
        $desconto_taxa = $row['desconto_taxa'];
        $desconto_valor = $row['desconto_valor'];
    }
    $query = 'SELECT * FROM tarifa WHERE id_tarifa=' . $id_tarifa . ';';
    $resultado = $conn->query($query);
    $taxa_administrativa = '';
    $seguro_respon_civil = '';
    $seguro_garantia_taxa = '';
    $lucro = '';
    $imposto = '';
    while ($row = $resultado->fetch_assoc()) {
        $taxa_administrativa = $row['taxa_administrativa'];
        $seguro_respon_civil = $row['seguro_respon_civil'];
        $seguro_garantia_taxa = $row['seguro_garantia'];
        $lucro = $row['lucro'];
        $imposto = $row['imposto'];
    }
    $query = 'SELECT * FROM forma_pagamento WHERE id_orcamento=' . $id_orcamento . ';';
    $resultado = $conn->query($query);
    $email = '';
    $banco = '';
    $agencia = '';
    $conta_corrente = '';
    $pix = '';
    while ($row = $resultado->fetch_assoc()) {
        $email = $row['e_mail'];
        $banco = $row['banco'];
        $agencia = $row['agencia'];
        $conta_corrente = $row['conta_corrente'];
        $pix = $row['pix'];
    }
    $query = 'SELECT * FROM servicos WHERE id_orcamento=' . $id . ';';
    $servicos = $conn->query($query);
    $query = 'SELECT * FROM mao_de_obra WHERE id_orcamento=' . $id . ';';
    $mao_de_obra = $conn->query($query);
    $query = 'SELECT * FROM nome_dos_profissionais WHERE id_orcamento=' . $id . ';';
    $profissionais = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sua-integridade-aqui" crossorigin="anonymous" />
    <link rel="stylesheet" href="../styles/visualizacaoDeOrcamento.css">
    <title>Orcamento</title>
</head>
<body>
    <main>
        <h1>Orçamento</h1>
        <div class="campo numero">
            <p class="label">Nᵒ do Orçamento</p>
            <p class="input"><?php echo $id_orcamento;?></p>
        </div>
        <div class="campo data">
            <p class="label">Data em que foi feito</p>
            <input type="date" class="input" value="<?php echo $data; ?>" readonly>
        </div>
        <div class="servico-informacoes">
            <h2>Informações do Serviço</h2>
            <div class="campo">
                <p class="label">Tipo de serviço</p>
                <p class="input"><?php echo $tipo_servico; ?></p>
            </div>
            <div class="campo">
                <p class="label">Descrição detalhada do serviço</p>
                <p class="input textarea"><?php echo $descricao_servico; ?></p>
            </div>
            <div class="campo">
                <p class="label">Limitações do serviço</p>
                <p class="input textarea"><?php echo $limitacao_servico; ?></p>
            </div>
        </div>
        <div class="servicos">
            <h2>Materiais / Serviços</h2>
            <div class="linha-servicos-nome">
                <p class="label">Item</p>
                <p class="label">Quant</p>
                <p class="label">Material / Serviço</p>
                <p class="label">Preço Unitário</p>
                <p class="label">Preço Final</p>
            
            </div>
            <?php
                while ($servico = $servicos->fetch_assoc()){
                    echo '<div class="linha-servicos">
                        <p class="input">' . $servico['itens'] . '</p>
                        <p class="input">' . $servico['quant'] . '</p>
                        <p class="input">' . $servico['material_servico'] . '</p>
                        <p class="input">R$' . $servico['preco_unitario'] . '</p>
                        <p class="input">R$' . $servico['preco_final'] . '</p>
                    </div>';
                }
            ?>
            <h2>Valor total dos serviços</h2>
            <p class="input" style="width: 500px; margin: 0 auto;">
                R$<?php echo $valor_total_itens?>
            </p>
        </div>
        <div class="mo">
            <h2>Mão de Obra</h2>
            <div class="linha-mo-nome">
                <p class="label">Função</p>
                <p class="label">Pessoas</p>
                <p class="label">Dias</p>
                <p class="label">Dias R$</p>
                <p class="label">Horas</p>
                <p class="label">Horas R$</p>
            </div>
            <?php
                while ($row = $mao_de_obra->fetch_assoc()){
                    echo'<div class="linha-mo">
                        <p class="input">' . $row['profissional'] . '</p>
                        <p class="input">' . $row['pessoas'] . '</p>
                        <p class="input">' . $row['dias'] . '</p>
                        <p class="input">' . $row['preco_dias'] . '</p>
                        <p class="input">' . $row['horas'] . '</p>
                        <p class="input">' . $row['preco_horas'] . '</p>
                    </div>';
                }
            ?>
        </div>
        <div class="taxas">
            <h2>Taxas</h2>
            <div class="linha-taxa">
                <p class="input taxa-mo"><b>Mão de obra</b></p>
                <p class="input"> <?php echo $valor_total_MO;?> </p>
            
            </div>
            <div class="linha-taxa">
                <p class="input taxa-deslocamento"><b>Deslocamento</b></p>
                <p class="input"> <?php echo $valor_total_deslocamento;?> </p>             
            </div>
            <div class="linha-taxa">
                <p class="input"><b>Seguro Garantia</b></p>
                <p class="input"><?php echo $seguro_garantia_taxa;?></p>
                <p class="input"><?php echo $seguro_garantia;?></p>
                
            </div>
            <div class="linha-taxa">
                <p class="input"><b>Seguro Respon. Civil</b></p>
                <p class="input"> <?php echo $seguro_respon_civil;?> </p>
                <p class="input"> <?php echo $seguro_civil;?></p>
            </div>
            <div class="linha-taxa">
                <p class="input"><b>TX ADMINISTRATIVA</b></p>
                <p class="input"> <?php echo $taxa_administrativa;?> </p>
                <p class="input"> <?php echo $admin_valor;?></p>
            </div>
            <div class="linha-taxa">
                <p class="input"><b>LUCRO</b></p>
                <p class="input"><?php echo $lucro;?></p>
                <p class="input"><?php echo $lucro_valor?> </p>
            </div>
            <div class="linha-taxa">
                <p class="input"><b>IMPOSTOS</b></p>
                <p class="input"><?php echo $imposto;?></p>
                <p class="input"><?php echo $impostos_valor?></p>
            </div>
            <div class="linha-taxa">
                <p class="input desconto"><b>DESCONTO à vista(%)</b></p>
                <p class="input desconto-taxa"> <?php echo $desconto_taxa;?></p>
                <p class="input desconto"> <?php echo $desconto_valor;?> </p>
            </div>
        </div>
        <div class="profissionais">
            <h2>Nome dos profissionais</h2>
            <div class="linha-profissionais-nome">
                <p class="label">Nome</p>
                <p class="label">CFT/CREA</p>
            </div>
            <?php
                while ($profissional = $profissionais->fetch_assoc()){
                    echo '<div class="linha-profissionais">
                        <p class="input">' . $profissional['nome_profissional'] . '</p>
                        <p class="input">' . $profissional['cft_crea'] . '</p>
                    </div>';
                }
            ?>
        </div>
        <div class="pagamento">
            <h2>Formas de Pagamento</h2>
            <div>
                <div class="campo">
                    <p class="label">Banco</p>
                    <p class="input"><?php echo $banco?></p>
                </div>
                <div class="campo">
                    <p class="label">Agência</p>
                    <p class="input"><?php echo $agencia?></p>
                </div>
                <div class="campo">
                    <p class="label">Conta Corrente</p>
                    <p class="input"><?php echo $conta_corrente?></p>
                </div>
            </div>
            <p class="input"><b>PIX:</b><span></span><?php echo $pix?></p>
            <p class="input"><b>Email:</b><span></span><?php echo $email?></p>
        </div>
        <div class="valor-total">
            <h2>Deslocamento</h2>
            <div class="campo">
                <p class="label">Distância</p>
                <p class="input"><?php echo $distancia;?></p>
            </div>
            <div class="campo">
                <p class="label">Valor / KM</p>
                <p class="input">R$<?php echo $distancia_valor;?></p>
            </div>
            <div class="campo">
                <h2>Valor Total</h2>
                <p class="input valor-total-preco">R$<?php echo $valor_total;?></p>
          </div>
        </div>
        <div class="observacao">
            <h2>Observações</h2>
            <div class="campo-observacoes">
                <p class="label">1 - Se o serviço não por problemas estruturais do imóvel ou outro de responsabilidade do
                    cliente, este deverá pagar o valor referente á visita técnica, frete e logística do serviço programado.</p>
                <p class="input"> R$<?php echo $observacao1;?> </p>
            </div>
            <div class="campo-observacoes">
                <p class="label">2 - Caso haja desistência e cancelamento do serviço, o cliente deverá pagar o valor da
                    compra de material e insumos e multa de 20% do valor do serviço.
                </p>
                <p class="input"> R$<?php echo $observacao2;?> </p>
            </div>
            <div class="campo-observacoes">
                <p class="label">3 - O Cliente pagará o valor antecipado como adiantamento e garantia da execuação do
                    serviço, compra de materiais e insumos, no valor de:
                </p>
                <p class="input"> R$<?php echo $observacao3;?> </p>
            </div>
        </div>
        <div class="prazos">
            <h2>Prazos</h2>
            <div class="campo">
                <p class="label">Quantidade de dias do prazo de validade do Orçamento</p>
                <p class="input"><?php echo $validade_orcamento;?></p>
            </div>
            <div class="campo">
                <p class="label">Data de Serviço</p>
                <p class="input"><?php echo $data_servico;?></p>
            </div>
            <div class="campo">
                <p class="label">Horário</p>
                <p class="input"><?php echo $horario;?></p>
            </div>
        </div>
    </main>
</body>
</html>