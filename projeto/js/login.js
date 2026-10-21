document.getElementById("btnSendFormUser").addEventListener('click', () => {
    login();
});

async function login() {
    let user = document.getElementById('user_name').value;
    let password = document.getElementById("user_senha").value;

    const fd = new FormData();
    fd.append("usuario", user);
    fd.append('senha', password);

    const retorno = await fetch("../php/user_login.php",{
        method: 'POST',
        body: fd
    });

    const resposta = await retorno.json();
    console.log(resposta);

    if(resposta.status == 'ok'){
        window.location.href = "../home/user_logado.html";
    }else{
        alert("Credenciais invalidas.");
    }
}