document.getElementById("btnCadastrar").addEventListener('click',() =>{
    cadastrar();
});
async function cadastrar(){
    let nome = document.getElementById('nome').value;
    let email = document.getElementById('email').value;
    let usuario = document.getElementById('usuario').value;
    let senha = document.getElementById('senha').value;
    let instagram = document.getElementById('instagram').value;

    const fd= new FormData();
    fd.append('nome', nome);
    fd.append('email', email);
    fd.append('usuario', usuario);
    fd.append('senha', senha);
    fd.append('instagram', instagram);

    const retorno = await fetch("../php/user_cadastro.php", {
        method: 'POST',
        body: fd
    });

    const resposta = await retorno.json();
    console.log(resposta);

    if(resposta.status=='ok'){
         window.location.href = "../login/index.html";
    }else{
        alert("Erro ao cadastrar. Tente novamente.");
    }
}