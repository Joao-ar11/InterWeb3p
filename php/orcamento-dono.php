<?php
    session_start();
    if (!isset($_SESSION['funcao']) || $_SESSION['funcao'] !== 'dono') {
        header('LOCATION: ../index.php');
    }
    include('../php/conn.php');


//Informacoes do Cliente

    $cliente = $_POST["cliente"];
    $setor = $_POST["setor"];
    $endereco = $_POST["endereco"];
    $cidade = $_POST["cidade"];
    $email = $_POST["email"];
    $whatsapp = $_POST["whatsapp"];

//Informacoes do Orcamento
    $id_cliente = 1;
    $query = 'SELECT id FROM cadastro WHERE email="' . $_POST['email'] . '";';
    $resultado = $conn->query($query);
    while ($row = $resultado->fetch_assoc()) {
        $id_cliente = $row["id"];
    }

    $conn->query('INSERT INTO orcamento_id (tipo_servico, descricao_servico, limitacao_servico, id_cliente, validacao) VALUES ("' . $_POST["tipo-servico"] . '", "' . $_POST["descricao-servico"] . '", "' . $_POST["limitacao-servico"] . '", "' . $id_cliente . '", "em validação");');

    $resultado = $conn->query("SELECT id FROM orcamento_id;");
    $id_orcamento = $resultado->num_rows;


    if (isset($cliente) && isset($setor) && isset($endereco) && isset($cidade) && isset($email) && isset($whatsapp)) {

        $insere = "INSERT INTO cliente (id, nome_cliente, setor, endereco, cidade, email, whatsapp) VALUES ('$id_cliente', '$cliente', '$setor', '$endereco', '$cidade', '$email', '$whatsapp')";

        mysqli_query($conn, $insere) or die("Não foi possível executar a inserção");
    }


//Itens

    $contador = 1;
    while (isset($_POST["item" . $contador]) && isset($_POST["quant" . $contador]) && isset($_POST["material-servico" . $contador]) && isset($_POST["preco-unitario" . $contador])) {
        if ($_POST["material-servico" . $contador] !== "") {
            $item = $_POST["item" . $contador];
            $quant = $_POST["quant" . $contador];
            $material_servico = $_POST["material-servico" . $contador];
            $preco_unitario = str_replace('R$', '', $_POST["preco-unitario" . $contador]);
            $preco_final = str_replace('R$', '', $_POST["preco-final" . $contador]);
            
            $insere = "INSERT INTO servicos (id_orcamento, itens, quant, material_servico, preco_unitario, preco_final) VALUES ('$id_orcamento', '$item', '$quant', '$material_servico', '$preco_unitario', '$preco_final')";
            
            mysqli_query($conn, $insere) or die("Não foi possível executar a inserção");
        }
        $contador++;
    }

//Mão de obra

    $contador = 1;
    while (isset($_POST["profissional" . $contador]) && isset($_POST["pessoas" . $contador]) && isset($_POST["dias" . $contador]) && isset($_POST["preco-dia" . $contador]) && isset($_POST["horas" . $contador]) && isset($_POST["preco-horas" . $contador])) {
        if (!($_POST['profissional' .$contador] === "")) {
        $profissional = $_POST["profissional" . $contador];
        $pessoas = $_POST["pessoas" . $contador];
        $dias = $_POST["dias" . $contador];
        $preco_dia = $_POST["preco-dia" . $contador];
        $horas = $_POST["horas" . $contador];
        $preco_horas = $_POST["preco-horas" . $contador];

        $insere = "INSERT INTO mao_de_obra (id_orcamento, profissional, pessoas, dias, preco_dias, horas, preco_horas) VALUES ('$id_orcamento', '$profissional', '$pessoas', '$dias', '$preco_dia', '$horas', '$preco_horas')";

        mysqli_query($conn, $insere) or die("Não foi possível executar a inserção");
        }
        $contador++;

    }

//Deslocamento

    $distancia = $_POST["distancia"];
    $distancia_valor = str_replace('R$', '', $_POST["distancia-valor"]);
    $valor_total_deslocamento = str_replace('R$', '', $_POST["deslocamento"]);
    
//Taxas

    $seguro_garantia = str_replace('R$', '', $_POST["seguro-garantia"]);

    $seguro_civil = str_replace('R$', '', $_POST["seguro-civil"]);
    
    $admin_valor = str_replace('R$', '', $_POST["admin-valor"]);

    $lucro_valor = str_replace('R$', '', $_POST["lucro-valor"]);

    $impostos_valor = str_replace('R$', '', $_POST["impostos-valor"]);

    $taxa_desconto = $_POST["taxa-desconto"];
    $desconto_valor = $_POST["desconto-valor"];

//Inserindo dados no Banco

    $resultado = $conn->query("SELECT * FROM tarifa WHERE (SELECT MAX(id_tarifa) FROM tarifa);");
    $id_tarifa = 0;
    while ($row = $resultado->fetch_assoc()) {
        $id_tarifa = $row["id_tarifa"];
    }

    if (isset($seguro_garantia) && isset($seguro_civil) && isset($admin_valor) && isset($lucro_valor) && isset($impostos_valor) && isset($desconto_valor)) {

    $insere = "INSERT INTO taxa (id_orcamento, id_tarifa, seguro_garantia, seguro_civil, admin_valor, lucro_valor, impostos_valor, desconto_taxa, desconto_valor) VALUES ('$id_orcamento', '$id_tarifa', '$seguro_garantia', '$seguro_civil', '$admin_valor', '$lucro_valor', '$impostos_valor', '$taxa_desconto', '$desconto_valor')";

    mysqli_query($conn, $insere) or die("Não foi possível executar a inserção"); 

}

//Nome dos Profissionais

    $contador = 1;
    while(isset($_POST['nome-profissional' . $contador]) && isset($_POST['cft-crea' . $contador])) {
        $nome_profissional = $_POST['profissional' . $contador];
        $cft_crea = $_POST['cft-crea' . $contador];

        $insere = "INSERT INTO nome_dos_profissionais (id_orcamento, nome_profissional, cft_crea) VALUES ('$id_orcamento','$nome_profissional', '$cft_crea')";

        mysqli_query($conn, $insere) or die("Não foi possível executar a inserção");
        $contador++;
    }


//Inserindo dados no Banco sobre Deslocamento

    if (isset($distancia) && isset($distancia_valor)) {

        $insere = "INSERT INTO frete (id_orcamento, distancia, distancia_valor, valor_total_deslocamento) VALUES ('$id_orcamento', '$distancia', '$distancia_valor', '$valor_total_deslocamento')";

        mysqli_query($conn, $insere) or die("Não foi possível executar a inserção");
    }

//Observacoes

    $observacao1 = str_replace('R$', '', $_POST["observacao1"]);
    $observacao2 = str_replace('R$', '', $_POST["observacao2"]);
    $observacao3 = str_replace('R$', '', $_POST["observacao3"]);

//inserindo dados no Banco sobre Observacoes

    if (isset($observacao1) && isset($observacao2) && isset($observacao3)) {

        $insere = "INSERT INTO observacao (id_orcamento, observacao1, observacao2, observacao3) VALUES ('$id_orcamento', '$observacao1', '$observacao2', '$observacao3')";

        mysqli_query($conn, $insere) or die("Não foi possível executar a inserção");
    }

//Prazos

    $validade_orcamento = $_POST["validade-orcamento"];
    $data_servico = $_POST["data-servico"];
    $horario = $_POST["horario"];

//Inserindo dados no Banco sobre Prazos

    if (isset($validade_orcamento) && isset($data_servico) && isset($horario)) {

        $insere = "INSERT INTO prazos (id_orcamento, validade_orcamento, data_servico, horario) VALUES ('$id_orcamento', '$validade_orcamento', '$data_servico', '$horario')";

        mysqli_query($conn, $insere) or die("Não foi possível executar a inserção");
    }

//Forma de pagamento

    $insere = 'INSERT INTO forma_pagamento (id_orcamento, e_mail, banco, agencia, conta_corrente, pix) VALUES ('. $id_orcamento . ', "' . $_POST['email-local'] . '", "' . $_POST['banco'] . '", "' . $_POST['agencia'] . '", "' . $_POST['conta-corrente'] . '", "' . $_POST['pix'] . '");';
    mysqli_query($conn, $insere) or die("Não foi possível executar a inserção");

    $data = $_POST['data'];
    $valor_total = str_replace('R$', '', $_POST['valor-total']);
    $valor_total_itens = str_replace('R$', '', $_POST['valor-total-itens']);
    $valor_total_MO = str_replace('R$', '', $_POST['mo-total']);

    mysqli_query($conn, "INSERT INTO calculo_orcamento (id, resultado, ddata, valor_total_itens, valor_total_MO) VALUES ('$id_orcamento', '$valor_total', '$data', '$valor_total_itens', '$valor_total_MO')");
    $_SESSION['confirmar'] = 'confirmado';
    header('Location: ../pages/preencherOrcamento-dono.php');
?>