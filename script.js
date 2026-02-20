const form = document.getElementById("oi");

form.addEventListener("submit",function(event){
    event.preventDefault()

const dados = {
    nome: document.getElementById("nome").value,
    email:document.getElementById("email").value,
    idade:document.getElementById("numero").value,
}
console.log(dados)
})