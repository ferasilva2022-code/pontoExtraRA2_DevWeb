document.addEventListener('DOMContentLoaded', () => {
    validaSessao();
});

async function validaSessao() {
    const retorno = await fetch("../php/user_logado.php");
    const resposta = await retorno.json();
    console.log(resposta);

    if(resposta.status == 'ok'){
        document.getElementById('nome_usuario').textContent = resposta.data[0].nome;
    }else{
        window.location.href = "../login/";
    }
}