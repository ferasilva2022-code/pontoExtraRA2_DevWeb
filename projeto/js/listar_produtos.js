document.getElementById('btnListar').addEventListener('click', ()=>{
    listar();
});
async function listar(){
    const retorno = await fetch("../php/produto_listar.php", {
        method: 'GET',
    });

    const resposta = await retorno.json();
    console.log(resposta);

    const tabela = document.getElementById('tabelaProdutos');
    tabela.innerHTML = '';
    document.getElementById('mensagem').innerText = resposta.mensagem;

    if(resposta.status == 'ok'){
        let tabelaConsulta = document.getElementById('consulta');
        let btnListar= document.getElementById('btnListar');
        let btnVoltar = document.getElementById('btnVoltar');
        let btnConsultar = document.getElementById('btnConsultar');
        tabelaConsulta.style.display = 'table';
        btnVoltar.style.display = 'inline-block';
        btnConsultar.style.display = 'inline-block';
        btnListar.style.display = 'none';

        for(const produto of resposta.data){
            tabela.innerHTML += `
                <tr>
                    <td>${produto.nome}</td>
                    <td>R$ ${Number(produto.preco).toFixed(2).replace('.', ',')}</td>
                    <td><a href="consulta_produtos.html?id=${produto.id}">Detalhes</a></td>
                </tr>
            `;
        }
    }
}

document.getElementById("btnVoltar").addEventListener('click', () =>{
    voltar();
});

function voltar(){
    document.getElementById('consulta').style.display = 'none';
    document.getElementById('btnVoltar').style.display = 'none';
    document.getElementById('btnListar').style.display = 'inline-block';
    document.getElementById('tabelaProdutos').innerHTML = '';
    document.getElementById('mensagem').innerText = '';
}

document.getElementById('btnConsultar').addEventListener('click', ()=>{
    window.location.href = "../home/consulta_produtos.html";
});
