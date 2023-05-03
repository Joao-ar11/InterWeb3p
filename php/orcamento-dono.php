<?php
    include('../php/conn.php');


//Informaçoes do Cliente

    $cliente = $_POST["cliente"];
    $setor = $_POST["setor"];
    $endereco = $_POST["endereco"];
    $cidade = $_POST["cidade"];
    $email = $_POST["email"];
    $whatsapp = $_POST["whatsapp"];

//Inserindo dados no Banco

    if (isset($cliente) && isset($setor) && isset($endereco) && isset($cidade) && isset($email) && isset($whatsapp)) {

        $insere = "INSERT INTO cliente (id, nome_cliente, setor, endereco, cidade, email, whatsapp) VALUES ('1', '$cliente', '$setor', '$endereco', '$cidade', '$email', '$whatsapp')";

        mysqli_query($conn, $insere) or die("Não foi possível executar a inserção");
    }

//Serviço

    $tipo_servico = $_POST["tipo-servico"];
    $descricao_servico = $_POST["descricao-servico"];
    $limitacao_servico = $_POST["limitacao-servico"];

//Inserindo dados no Banco

//Itens*

    $contador = 1;
    $valor_total_itens = 0;
    $valor_total = 0;
    while (isset($_POST["item" . $contador]) && isset($_POST["quant" . $contador]) && isset($_POST["material-servico" . $contador]) && isset($_POST["preco-unitario" . $contador])) {
        if ($_POST["material-servico" . $contador] !== "") {
            $item = $_POST["item" . $contador];
            $quant = $_POST["quant" . $contador];
            $material_servico = $_POST["material-servico" . $contador];
            $preco_unitario = str_replace('R$', '', $_POST["preco-unitario" . $contador]);
            $preco_final = intval($quant) * floatval($preco_unitario);
            $valor_total_itens += $preco_final;
            
            $insere = "INSERT INTO servicos (itens, quant, material_servico, preco_unitario, preco_final) VALUES ('$item', '$quant', '$material_servico', '$preco_unitario', '$preco_final')";

            // $inserir = "INSERT INTO calculo_orcamento (valor_total_itens) VALUES ('$valor_total_itens')";
            
            mysqli_query($conn, $insere) or die("Não foi possível executar a inserção");
            // mysqli_query($conn, $inserir) or die("Não foi possível executar a inserção");

        }
        $contador++;
    }
    $valor_total += $valor_total_itens;

    // colocando o valor_total_itens para fora do while para não repetir muitas vezes - Cristiano
    $inserir = "INSERT INTO calculo_orcamento (valor_total_itens) VALUES ('$valor_total_itens')";
    mysqli_query($conn, $inserir) or die("Não foi possível executar a inserção");

//Mão de obra

    $contador = 1;
    $valor_total_MO = 0;
    while (isset($_POST["profissional" . $contador]) && isset($_POST["pessoas" . $contador]) && isset($_POST["dias" . $contador]) && isset($_POST["preco-dia" . $contador]) && isset($_POST["horas" . $contador]) && isset($_POST["preco-horas" . $contador])) {
        if (!($_POST['profissional' .$contador] === "")) {
        $profissional = $_POST["profissional" . $contador];
        $pessoas = $_POST["pessoas" . $contador];
        $dias = $_POST["dias" . $contador];
        $preco_dia = $_POST["preco-dia" . $contador];
        $horas = $_POST["horas" . $contador];
        $preco_horas = $_POST["preco-horas" . $contador];
        $precoMO = intval($pessoas) * ((intval($dias) * floatval($preco_dia)) + (intval($horas) * floatval($preco_horas)));
        $valor_total_MO += $precoMO;

        $insere = "INSERT INTO mao_de_obra (profissional, pessoas, dias, preco_dias, horas, preco_horas) VALUES ('$profissional', '$pessoas', '$dias', '$preco_dia', '$horas', '$preco_horas')";

        mysqli_query($conn, $insere) or die("Não foi possível executar a inserção");
        }
        $contador++;

    }
    $valor_total += $valor_total_MO;

//Deslocamento
    $distancia = $_POST["distancia"];
    $distancia_valor = str_replace('R$', '', $_POST["distancia-valor"]);
    $valor_total_deslocamento = floatval($distancia) * floatval($distancia_valor);
    $valor_total += $valor_total_deslocamento;
    
//Taxas
    $soma_valores = $valor_total_deslocamento + $valor_total_itens + $valor_total_MO;

    $taxas_tabela = $conn->query("SELECT * FROM tarifa where id_tarifa=(SELECT MAX(id_tarifa) FROM tarifa);");
    
    while ($taxas = $taxas_tabela->fetch_assoc()){
        $seguro_garantia_taxa = intval(str_replace('%', '', $taxas["seguro_garantia"]));
        $seguro_garantia = $soma_valores * $seguro_garantia_taxa / 100;

        $seguro_civil_taxa = intval(str_replace('%', '', $taxas['seguro_respon_civil']));
        $seguro_civil = $soma_valores * $seguro_civil_taxa / 100;
        
        $admin_taxa = intval(str_replace('%', '', $taxas["taxa_administrativa"]));
        $admin_valor = ($soma_valores + $seguro_garantia + $seguro_civil) * $admin_taxa / 100;

        $lucro_taxa = intval(str_replace('%', '', $taxas["lucro"]));
        $lucro_valor = ($soma_valores + $seguro_garantia + $seguro_civil + $admin_valor) * $lucro_taxa / 100;

        $impostos_taxa = intval(str_replace('%', '', $taxas['imposto']));
        $impostos_valor = ($soma_valores + $seguro_garantia + $seguro_civil + $admin_valor + $lucro_valor) * $impostos_taxa / 100;

        $taxa_desconto = $_POST["taxa-desconto"];
        $desconto_valor = ($soma_valores + $admin_valor + $lucro_taxa) * $taxa_desconto / 100 * -1;

        $valor_total += $seguro_garantia + $seguro_civil + $lucro_valor + $impostos_valor + $desconto_valor;
        $id_tarifa = $taxas['id_tarifa'];
    //Inserindo dados no Banco

        if (isset($seguro_garantia) && isset($seguro_civil) && isset($admin_valor) && isset($lucro_valor) && isset($impostos_valor) && isset($desconto_valor) && isset($valor_total)) {

        $insere = "INSERT INTO taxa (id_tarifa, seguro_garantia, seguro_civil, admin_valor, lucro_valor, impostos_valor, desconto_taxa, desconto_valor, valor_total) VALUES ('$id_tarifa', '$seguro_garantia', '$seguro_civil', '$admin_valor', '$lucro_valor', '$impostos_valor', '$taxa_desconto', '$desconto_valor', '$valor_total')";

        mysqli_query($conn, $insere) or die("Não foi possível executar a inserção"); 

    }}
//Nome dos Profissionais*
    $contador = 1;
    while(isset($_POST['nome-profissional' . $contador]) && isset($_POST['cft-crea' . $contador])) {
        $profissional = $_POST['profissional' . $contador];
        $cft_crea = $_POST['cft-crea' . $contador];

        $insere = "INSERT INTO nome_dos_profissionais (nome_profissional, cft_crea) VALUES ('$profissional', '$cft_crea')";

        mysqli_query($conn, $insere) or die("Não foi possível executar a inserção");
        $contador++;
    }


//Inserindo dados no Banco

    if (isset($distancia) && isset($distancia_valor)) {

        $insere = "INSERT INTO frete (distancia, distancia_valor) VALUES ('$distancia', '$distancia_valor')";

        mysqli_query($conn, $insere) or die("Não foi possível executar a inserção");
    }

//Observações**

    $observacao1 = $_POST["observacao1"];
    $observacao2 = number_format($valor_total * 20 / 100, 2, ".", "");
    $observacao3 = number_format($valor_total * 30 / 100, 2, ".", "");

//inserindo dados no Banco

    if (isset($observacao1) && isset($observacao2) && isset($observacao3)) {

        $insere = "INSERT INTO observacao (observacao1, observacao2, observacao3) VALUES ('$observacao1', '$observacao2', '$observacao3')";

        mysqli_query($conn, $insere) or die("Não foi possível executar a inserção");
    }

//Prazos

    $validade_orcamento = $_POST["validade-orcamento"];
    $data_servico = $_POST["data-servico"];
    $horario = $_POST["horario"];

//Inserindo dados no Banco

    if (isset($validade_orcamento) && isset($data_servico) && isset($horario)) {

        $insere = "INSERT INTO prazos (validade_orcamento, data_servico, horario) VALUES ('$validade_orcamento', '$data_servico', '$horario')";

        mysqli_query($conn, $insere) or die("Não foi possível executar a inserção");
    }

    $string = 'data';

    mysqli_query($conn, "INSERT INTO calculo_orcamento (resultado, ddata, valor_total_itens, valor_total_MO, tipo_servico, descricao_servico, limitacao_servico) VALUES ('$valor_total', '$_POST[$string]', '$valor_total_itens', '$valor_total_MO', '$tipo_servico', '$descricao_servico', '$limitacao_servico')");
    header('Location: ../pages/preencherOrcamento-dono.php');
?>