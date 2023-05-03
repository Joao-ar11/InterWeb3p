// Área das funções de cáculo com floats

/* tratarFloats(floatStr): transforma string de floats no formato necessário para as outras
                        funções.
                        Recebe: Uma string que contém APENAS um número de ponto flutuante.
                        Retorna: Um array com [string do float sem o ponto flutuante, quantidade
                                 de números depois da vírgula]*/
function tratarFloats(floatStr) {
    if (!/\./.test(floatStr)) return [floatStr, 0];
    const numerosDepoisDaVirgula = +(floatStr.length - 1 - floatStr.search(/\./));
    return [floatStr.replace(".", ""), numerosDepoisDaVirgula];
}

/* somarFloats(valor1, valor2): faz uma adição entre dois floats tratados(ver tratarFloats()).
                        Recebe: float tratado, float tratado.
                        Retorna: a soma precisa dos dois valores em uma string*/
function somarFloats(valor1, valor2) {
    let resultado = "";
    const maiorEspacoDecimal = valor1[1] >= valor2[1]? valor1 : valor2;
    const menorEspacoDecimal = valor2[1] <= valor1[1]? valor2 : valor1;
    if (valor1[1] > valor2[1] || valor2[1] > valor1[1]) {
        resultado += maiorEspacoDecimal[0].slice(-(maiorEspacoDecimal[1] - menorEspacoDecimal[1]));
        maiorEspacoDecimal[0] = maiorEspacoDecimal[0].slice(0, -(maiorEspacoDecimal[1] - menorEspacoDecimal[1]));
    }
    resultado = (+maiorEspacoDecimal[0] + +menorEspacoDecimal[0]) + resultado;
    if (valor1[1] !== 0 || valor2[1] !== 0) {
        resultado = resultado.slice(0, -(maiorEspacoDecimal[1])) + "." + resultado.slice(-(maiorEspacoDecimal[1]));
    }
    return resultado;
}

/* subtrairFloats(valor1, valor2): faz a subtração entre dois floats tratados(ver tratarFloats()).
                        OBS: Apenas utilizar com números positivos na ordem maior para menor.
                        Recebe: float tratado, float tratado.
                        Retorna: a subtração precisa dos dois valores em uma string*/
function subtrairFloats(valor1, valor2) {
    let resultado = "";
    const maiorEspacoDecimal = valor1[1] >= valor2[1]? valor1 : valor2;
    const menorEspacoDecimal = valor2[1] <= valor1[1]? valor2 : valor1;
    if (valor1[1] > valor2[1] || valor2[1] > valor1[1]) {
        if (valor1[1] > valor2[1]) {
            resultado += maiorEspacoDecimal[0].slice(-(maiorEspacoDecimal[1] - menorEspacoDecimal[1]));
            maiorEspacoDecimal[0] = maiorEspacoDecimal[0].slice(0, -(maiorEspacoDecimal[1] - menorEspacoDecimal[1]));
        } else {
            valor1[0] += "0".repeat(maiorEspacoDecimal[1] - menorEspacoDecimal[1]);
        }
    }
    resultado = (+valor1[0] - +valor2[0]) + resultado;
    if (valor1[1] !== 0 || valor2[1] !== 0) {
        resultado = resultado.slice(0, -(maiorEspacoDecimal[1])) + "." + resultado.slice(-(maiorEspacoDecimal[1]));
    }
    return resultado;
}

/* multiplicarFloats(valor1, valor2): faz a multiplicação entre dois floats tratados(ver tratarFloats()).
                        Recebe: float tratado, float tratado.
                        Retorna: a multiplicação precisa dos dois valores em uma string*/
function multiplicarFloats(valor1, valor2) {
    let resultado = (+valor1[0] * +valor2[0]).toString();
    if (valor1[1] !== 0 || valor2[1] !== 0) {
        resultado = resultado.slice(0, -(valor1[1] + valor2[1])) + "." + resultado.slice(-(valor1[1] + valor2[1]));
    }
    return resultado;
}

/*calcularFloats(valor1, operador, valor2): retorna resultado da operação requisitada com
                        precisão.
                        OBS: Apenas utilizar com números positivos na ordem maior para menor ao utilizar.
                        Recebe: String de um float, String de um operador, String de um float.
                        Retorna: resultado da operação requisitada com
                        precisão em String*/
function calcularFloats(valor1, operador, valor2) {
    const valor1tratado = tratarFloats(valor1);
    const valor2tratado = tratarFloats(valor2);
    switch (operador) {
        case "+":
            return somarFloats(valor1tratado, valor2tratado);
        case "-":
            return subtrairFloats(valor1tratado, valor2tratado);
        case "*":
            return multiplicarFloats(valor1tratado, valor2tratado);
        default:
            return "0";
    }
}

function calculoDeTaxas(soma) {
    let resultado = "0";
    const seguroGarantiaValor = (+calcularFloats(soma, "*", (+document.querySelector("#taxa-seguro-garantia").textContent.slice(0, -1) / 100).toFixed(2))).toFixed(2);
    document.querySelector("#seguro-garantia").value = "R$" + seguroGarantiaValor;
    resultado = calcularFloats(resultado, "+", seguroGarantiaValor);

    const seguroCivilValor = (+calcularFloats(soma, "*", (+document.querySelector("#taxa-seguro-civil").textContent.slice(0, -1) / 100).toFixed(2))).toFixed(2);
    document.querySelector("#seguro-civil").value = "R$" + seguroCivilValor;
    resultado = calcularFloats(resultado, "+", seguroCivilValor);

    const adminValor = (+calcularFloats(calcularFloats(soma, "+", resultado), "*", (+document.querySelector("#taxa-admin").textContent.slice(0, -1) / 100).toFixed(2))).toFixed(2);
    document.querySelector("#admin-valor").value = "R$" + adminValor;
    resultado = calcularFloats(resultado, "+", adminValor);

    const lucroValor = (+calcularFloats(calcularFloats(soma, "+", resultado), "*", (+document.querySelector("#taxa-lucro").textContent.slice(0, -1) / 100).toFixed(2))).toFixed(2);
    document.querySelector("#lucro-valor").value = "R$" + lucroValor;
    resultado = calcularFloats(resultado, "+", lucroValor);

    const impostosValor = (+calcularFloats(calcularFloats(soma, "+", resultado), "*", (+document.querySelector("#taxa-impostos").textContent.slice(0, -1) / 100).toFixed(2))).toFixed(2);
    document.querySelector("#impostos-valor").value = "R$" + impostosValor;
    resultado = calcularFloats(resultado, "+", impostosValor);

    const descontoValor = (+calcularFloats(calcularFloats(lucroValor, "+", calcularFloats(adminValor, "+", soma)), "*", (+document.querySelector("#taxa-desconto").value.slice(0, -1) / 100).toFixed(2))).toFixed(2);
    document.querySelector("#desconto-valor").value = "- R$" + descontoValor;
    resultado = calcularFloats(resultado, "-", descontoValor);

    document.querySelector("#valor-total").value = "R$" + (+calcularFloats(soma, "+", resultado)).toFixed(2);
}

function mudarPrecoTotal() {
    const valorItens = document.querySelector("#valor-total-itens").value.replace(/[R$]/g, "").replace(/(\.)\d{3}/, "").replace(",", ".");
    const valorMO = document.querySelector("#mo-total").value.replace(/[R$]/g, "").replace(/(\.)\d{3}/, "").replace(",", ".");
    const deslocamento = document.querySelector("#deslocamento").value.replace(/[R$]/g, "").replace(/(\.)\d{3}/, "").replace(",", ".");
    calculoDeTaxas(calcularFloats(valorItens, "+", calcularFloats(valorMO, "+", deslocamento)));
    document.querySelector("#observacao2").value = "R$" + (+calcularFloats(document.querySelector("#valor-total").value.replace(/[R$]/g, ""), "*", "0.20")).toFixed(2);
    document.querySelector("#observacao3").value = "R$" + (+calcularFloats(document.querySelector("#valor-total").value.replace(/[R$]/g, ""), "*", "0.30")).toFixed(2);
}

function mudarPrecoTotalItens() {
    const listaDePrecos = Array.from(document.querySelectorAll(".preco-final"));
    document.querySelector("#valor-total-itens").value = "R$" + (+listaDePrecos.reduce((total, item) => {
        return calcularFloats(total, "+", item.value.replace(/[R$]/g, "").replace(/(\.)\d{3}/, "").replace(",", "."));
    }, "0")).toFixed(2);
    mudarPrecoTotal();
}

function mudarPrecoTotalMO() {
    const listaDePrecos = Array.from(document.querySelectorAll(".precoMO"));
    document.querySelector("#mo-total").value = "R$" + (+listaDePrecos.reduce((total, item) => {
        return calcularFloats(total, "+", item.value);
    }, "0")).toFixed(2);
    mudarPrecoTotal();
}

function adicionarCampoDeItens(id) {
    const linha = document.createElement("div");
    linha.classList.add("linha-itens");

    const campoItem = document.createElement("div");
    campoItem.classList.add("campo");
    campoItem.classList.add("item");
    const inputItem = document.createElement("input");
    inputItem.name = `item${id}`;
    inputItem.type = "text";
    inputItem.readOnly = true;
    inputItem.value = id > 9 ? id : "0" + id;
    
    const campoQuant = document.createElement("div");
    campoQuant.classList.add("campo");
    campoQuant.classList.add("quant");
    const inputQuant = document.createElement("input");
    inputQuant.name = `quant${id}`;
    inputQuant.type = "text";

    const campoMaterialServico = document.createElement("div");
    campoMaterialServico.classList.add("campo");
    campoMaterialServico.classList.add("material-servico");
    const inputMaterialServico = document.createElement("input");
    inputMaterialServico.name = `material-servico${id}`;
    inputMaterialServico.type = "text";

    const campoPrecoUnitario = document.createElement("div");
    campoPrecoUnitario.classList.add("campo");
    campoPrecoUnitario.classList.add("preco-unitario");
    const inputPrecoUnitario = document.createElement("input");
    inputPrecoUnitario.name = `preco-unitario${id}`;
    inputPrecoUnitario.type = "text";

    const campoPrecoFinal = document.createElement("div");
    campoPrecoFinal.classList.add("campo");
    const inputPrecoFinal = document.createElement("input");
    inputPrecoFinal.classList.add("preco-final");
    inputPrecoFinal.name = `preco-final${id}`;
    inputPrecoFinal.type = "text";
    inputPrecoFinal.value = "R$0.00"
    inputPrecoFinal.readOnly = true;

    inputQuant.addEventListener("input", () => {
        const quant = inputQuant.value === ""? 0 : +inputQuant.value;
        const valorUnitarioStr = inputPrecoUnitario.value.replace(/[R$]/g, "").replace(/(\.)\d{3}/, "").replace(",", ".");
        inputPrecoFinal.value = "R$" + (+calcularFloats(quant, "*", valorUnitarioStr)).toFixed(2);
        mudarPrecoTotalItens();
    });

    inputPrecoUnitario.addEventListener("input", () => {
        const quant = inputQuant.value === ""? 0 : +inputQuant.value;
        const valorUnitarioStr = inputPrecoUnitario.value.replace(/[R$]/g, "").replace(/(\.)\d{3}/, "").replace(",", ".");
        inputPrecoFinal.value = "R$" + (+calcularFloats(quant, "*", valorUnitarioStr)).toFixed(2);
        inputPrecoUnitario.value = "R$" + valorUnitarioStr;
        mudarPrecoTotalItens();
    });
    
    campoItem.appendChild(inputItem);
    linha.appendChild(campoItem);
    campoQuant.appendChild(inputQuant);
    linha.appendChild(campoQuant);
    campoMaterialServico.appendChild(inputMaterialServico);
    linha.appendChild(campoMaterialServico);
    campoPrecoUnitario.appendChild(inputPrecoUnitario);
    linha.appendChild(campoPrecoUnitario);
    campoPrecoFinal.appendChild(inputPrecoFinal);
    linha.appendChild(campoPrecoFinal);
    document.querySelector(".itens").insertBefore(linha, document.querySelector(".itens .controle-campos"));
}

function adicionarCampoDeMO(id) {
    const linha = document.createElement("div");
    linha.classList.add("linha-mo");

    const campoProfissional = document.createElement("div");
    campoProfissional.classList.add("campo");
    campoProfissional.classList.add("mo");
    const inputProfissional = document.createElement("input");
    inputProfissional.type = "text";
    inputProfissional.name = `profissional${id}`;
    
    const campoPessoas = document.createElement("div");
    campoPessoas.classList.add("campo");
    campoPessoas.classList.add("mo");
    const inputPessoas = document.createElement("input");
    inputPessoas.type = "text";
    inputPessoas.name = `pessoas${id}`;
    
    const campoDias = document.createElement("div");
    campoDias.classList.add("campo");
    campoDias.classList.add("mo");
    const inputDias = document.createElement("input");
    inputDias.type = "text";
    inputDias.name = `dias${id}`;
    
    const campoPrecoDia = document.createElement("div");
    campoPrecoDia.classList.add("campo");
    campoPrecoDia.classList.add("mo");
    const inputPrecoDia = document.createElement("input");
    inputPrecoDia.type = "text";
    inputPrecoDia.name = `preco-dia${id}`;
    
    const campoHoras = document.createElement("div");
    campoHoras.classList.add("campo");
    campoHoras.classList.add("mo");
    const inputHoras = document.createElement("input");
    inputHoras.type = "text";
    inputHoras.name = `horas${id}`;
    
    const campoPrecoHoras = document.createElement("div");
    campoPrecoHoras.classList.add("campo");
    campoPrecoHoras.classList.add("mo");
    const inputPrecoHoras = document.createElement("input");
    inputPrecoHoras.type = "text";
    inputPrecoHoras.name = `preco-horas${id}`;
    
    const precoMO = document.createElement("input");
    precoMO.classList.add("precoMO");
    precoMO.id = `precoMO${id}`;
    precoMO.disabled = true;
    precoMO.style.display = "none";
    
    function mudarPrecoMO(pessoas, dias, precoDia, horas, precoHoras, precoMO) {
        const precoDiaNum = precoDia.value.replace(/[R$]/g, "").replace(/(\.)\d{3}/, "").replace(",", ".");
        const precoHorasNum = precoHoras.value.replace(/[R$]/g, "").replace(/(\.)\d{3}/, "").replace(",", ".");
        precoMO.value = (+calcularFloats(pessoas.value, "*", calcularFloats(calcularFloats(dias.value, "*", precoDiaNum), "+", calcularFloats(horas.value, "*", precoHorasNum)))).toFixed(2);
        mudarPrecoTotalMO();
    }

    inputPessoas.addEventListener("input", () => {mudarPrecoMO(inputPessoas, inputDias, inputPrecoDia, inputHoras, inputPrecoHoras, precoMO);});

    inputDias.addEventListener("input", () => {mudarPrecoMO(inputPessoas, inputDias, inputPrecoDia, inputHoras, inputPrecoHoras, precoMO);});
    
    inputPrecoDia.addEventListener("input", () => {mudarPrecoMO(inputPessoas, inputDias, inputPrecoDia, inputHoras, inputPrecoHoras, precoMO);});
    
    inputHoras.addEventListener("input", () => {mudarPrecoMO(inputPessoas, inputDias, inputPrecoDia, inputHoras, inputPrecoHoras, precoMO);});

    inputPrecoHoras.addEventListener("input", () => {mudarPrecoMO(inputPessoas, inputDias, inputPrecoDia, inputHoras, inputPrecoHoras, precoMO);});

    campoProfissional.appendChild(inputProfissional);
    linha.appendChild(campoProfissional);
    campoPessoas.appendChild(inputPessoas);
    linha.appendChild(campoPessoas);
    campoDias.appendChild(inputDias);
    linha.appendChild(campoDias);
    campoPrecoDia.appendChild(inputPrecoDia);
    linha.appendChild(campoPrecoDia);
    campoHoras.appendChild(inputHoras);
    linha.appendChild(campoHoras);
    campoPrecoHoras.appendChild(inputPrecoHoras);
    linha.appendChild(campoPrecoHoras);
    linha.appendChild(precoMO);
    document.querySelector(".mao-de-obra").insertBefore(linha, document.querySelector(".mao-de-obra .controle-campos"));
}

function adicionarCampoDeProf(id) {
    const linha = document.createElement("div");
    linha.classList.add("linha-prof");

    const nomeP = document.createElement("p");
    nomeP.textContent = "Nome:";
    linha.appendChild(nomeP);

    const nomeInput = document.createElement("input");
    nomeInput.type = "text";
    nomeInput.name = `nome-profissional${id}`;
    linha.appendChild(nomeInput);

    const cftP = document.createElement("p");
    cftP.textContent = "CFT/CREA:";
    linha.appendChild(cftP);

    const cftInput = document.createElement("input");
    cftInput.type = "text";
    cftInput.name = `cft-crea${id}`;
    linha.appendChild(cftInput);
    document.querySelector(".profissionais").insertBefore(linha, document.querySelector(".profissionais .controle-campos"));
}

function removerCampos(nomeDoCampo) {
    const listaDeLinhas = Array.from(document.querySelectorAll(nomeDoCampo));
    if (listaDeLinhas.length > 0) {
        const campo = listaDeLinhas.pop();
        campo.remove();
    }
}

// Adicionar Campos em itens
adicionarCampoDeItens(document.querySelectorAll(".linha-itens").length + 1);
adicionarCampoDeItens(document.querySelectorAll(".linha-itens").length + 1);
adicionarCampoDeItens(document.querySelectorAll(".linha-itens").length + 1);
adicionarCampoDeItens(document.querySelectorAll(".linha-itens").length + 1);
document.querySelector("#adicionar-campos-itens").addEventListener("click", () => {
    adicionarCampoDeItens(document.querySelectorAll(".linha-itens").length + 1);
});

// Remover Campos em itens
document.querySelector("#remover-campos-itens").addEventListener("click", () => {
    removerCampos(".linha-itens");
    mudarPrecoTotalItens();
});

//Adicionar campos em mão de obra
adicionarCampoDeMO(document.querySelectorAll(".linha-mo").length + 1);
adicionarCampoDeMO(document.querySelectorAll(".linha-mo").length + 1);
const botaoAdicionarCampoMO = document.querySelector("#adicionar-campos-mo");
botaoAdicionarCampoMO.addEventListener("click", () => {
    adicionarCampoDeMO(document.querySelectorAll(".linha-mo").length + 1);
});

// Remover Campos em mão de obra
document.querySelector("#remover-campos-mo").addEventListener("click", () => {
    removerCampos(".linha-mo");
    mudarPrecoTotalMO();
});

//Adicionar campos em profissionais
const botaoAdicionarCampoProf = document.querySelector("#adicionar-campos-prof");
botaoAdicionarCampoProf.addEventListener("click", () => {
    adicionarCampoDeProf(document.querySelectorAll(".linha-prof").length + 1);
});

// Remover Campos em profissionais
document.querySelector("#remover-campos-prof").addEventListener("click", () => {
    removerCampos(".linha-prof");
});

//Data atual
const date = new Date();
const month = +date.getMonth() + 1 > 9 ? +date.geMonth() + 1 : "0" + (date.getMonth() + 1);
document.querySelector(".data-atual").value = `${date.getFullYear()}-${month}-${date.getDate()}`;

//Cálculo de deslocamnto 
const distancia = document.querySelector("#distancia");
const distanciaValor = document.querySelector("#distancia-valor");
distancia.addEventListener("input", () => {
    distanciaValor.value = "R$" + distanciaValor.value.replace(/[R$]/g, "").replace(/(\.)\d{3}/, "").replace(",", ".");
    document.querySelector("#deslocamento").value = "R$" + (+calcularFloats(distancia.value, "*", distanciaValor.value.replace(/[R$]/g, ""))).toFixed(2);
    mudarPrecoTotal();
});
distanciaValor.addEventListener("input", () => {
    distanciaValor.value = "R$" + distanciaValor.value.replace(/[R$]/g, "").replace(/(\.)\d{3}/, "").replace(",", ".");
    document.querySelector("#deslocamento").value = "R$" + (+calcularFloats(distancia.value, "*", distanciaValor.value.replace(/[R$]/g, ""))).toFixed(2);
    mudarPrecoTotal();
});

document.querySelector("#taxa-desconto").addEventListener("input", () => {
    const taxa = document.querySelector("#taxa-desconto");
    taxa.value = taxa.value.replace(/%/g, "") + "%";
    mudarPrecoTotal(); 
});