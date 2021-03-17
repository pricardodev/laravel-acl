
// Função para sumir com a div de mensagens de alerta
document.addEventListener("DOMContentLoaded", function(){
 const div = document.querySelector('.message-alert');
    let timeout = 3000;
    if(div !== null) {
        setTimeout(() => {
            div.style.display = "none";
        }, timeout);
    }
});
 