var formulario = document.getElementById('formulario')
var botaoModalSucessoFechar = document.getElementById('botao-fechar')

formulario.addEventListener('submit', event =>{
    event.preventDefault()

    var elementoFade = document.getElementById('fade')
    elementoFade.classList.toggle("hide")

    var elementoModal = document.getElementById('modal')
    elementoModal.classList.toggle("hide")

    var divSucesso = document.getElementById('confirmacao')
    divSucesso.style.display = "flex"
    botaoModalSucessoFechar.style.display = "inline-block"

    
    botaoModalSucessoFechar.addEventListener('click', ()=> {
        divSucesso.style.display = "none"
        botaoModalSucessoFechar.style.display = "none"
    })

    setTimeout(function() {
        divSucesso.style.display = "none"
    }, 3000)

    setTimeout(function() {
        botaoModalSucessoFechar.style.display = "none"
    }, 3000)

    formulario.submit()
})