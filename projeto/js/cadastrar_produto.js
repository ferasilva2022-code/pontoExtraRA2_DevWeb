document.getElementById("btnCadastrar").addEventListener('click',() =>{
    cadastrar();
});
async function cadastrar(){
    let nome = document.getElementById('nome').value;
    let preco = document.getElementById('preco').value;
    let estoque = document.getElementById('estoque').value;
    let ativo = document.getElementById('ativo').checked ? 1 : 0;
    
    const fd= new FormData();
    fd.append('nome', nome);
    fd.append('preco', preco);
    fd.append('estoque', estoque);
    fd.append('ativo', ativo);
    

    const retorno = await fetch("../php/produto_novo.php", {
        method: 'POST',
        body: fd
    });

    const resposta = await retorno.json();
    console.log(resposta);

    if(resposta.status=='ok'){
         window.location.href = "../home/consulta_produtos.html";
    }else{
        alert("Erro ao cadastrar produto. Tente novamente.");
    }
}