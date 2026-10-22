// consulta_produtos.html?id=3 mostra só o produto 3; sem id, mostra todos
const parametros = new URLSearchParams(window.location.search);
const id = parametros.get('id');

consultar();

async function consultar(){
    let endereco = "../php/produto_detalhe.php";
    if(id){
        endereco = "../php/produto_detalhe.php?id=" + id;
    }

    const retorno = await fetch(endereco, {
        method: 'GET',
    });

    const resposta = await retorno.json();
    console.log(resposta);

    const tabela = document.getElementById('tabelaProdutos');
    tabela.innerHTML = '';
    document.getElementById('mensagem').innerText = resposta.mensagem;

    if(resposta.status == 'ok'){
        for(const produto of resposta.data){
            tabela.innerHTML += `
                <tr>
                    <td>${produto.id}</td>
                    <td>${produto.nome}</td>
                    <td>R$ ${Number(produto.preco).toFixed(2).replace('.', ',')}</td>
                    <td>${produto.estoque}</td>
                    <td>${produto.ativo == 1 ? 'Ativo' : 'Inativo'}</td>
                </tr>
            `;
        }
    }
}

document.getElementById("btnVoltar").addEventListener('click', () =>{
    window.location.href = "../home/lista_produtos.html";
});

document.getElementById("btnEditar").addEventListener('click', () =>{
    window.location.href = "../home/alterar_produtos.html";
});

document.getElementById("btnRemover").addEventListener('click', () =>{
    window.location.href = "../home/excluir_produtos.html";
});

document.getElementById("btnEstoque").addEventListener('click', () =>{
    consultarEstoque();
});

async function consultarEstoque(){
    const retorno = await fetch("../php/estoque_resumo.php", {
        method: 'GET',
    });

    const resposta = await retorno.json();
    console.log(resposta);

    const resumo = document.getElementById('resumoEstoque');

    if(resposta.status == 'ok'){
        const estoque = resposta.data[0];
        resumo.innerHTML = `
            Produtos ativos: ${estoque.total_produtos}<br>
            Unidades em estoque: ${estoque.total_unidades}<br>
            Valor total do estoque: R$ ${Number(estoque.valor_estoque).toFixed(2).replace('.', ',')}
        `;
    }else{
        // sem login o PHP responde "Acesso negado. Faca login."
        resumo.innerText = resposta.mensagem;
    }
}
