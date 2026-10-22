document.addEventListener("DOMContentLoaded", () => {
    // alterar_produtos.html?id=3 mostra só o produto 3; sem id, mostra todos
    const url = new URLSearchParams(window.location.search);
    const id = url.get("id");
    buscar(id);
});

async function buscar(id){
    let endereco = "../php/produto_detalhe.php";
    if(id){
        endereco = "../php/produto_detalhe.php?id=" + id;
    }

    const retorno = await fetch(endereco);
    const resposta = await retorno.json();

    const tabela = document.getElementById("tabelaProdutos");
    tabela.innerHTML = '';

    if(resposta.status == "ok"){
        for(const produto of resposta.data){
            tabela.innerHTML += `
                <tr>
                    <td><input type="text" id="nome-${produto.id}" value="${produto.nome}"></td>
                    <td><input type="number" id="preco-${produto.id}" value="${produto.preco}" step="0.01"></td>
                    <td><input type="checkbox" id="ativo-${produto.id}" ${produto.ativo == 1 ? 'checked' : ''}></td>
                    <td><button type="button" onclick="alterar(${produto.id}) ">Salvar</button></td>
                </tr>
            `;
        }
    }else{
        document.getElementById("mensagem").innerText = resposta.mensagem;
    }
}

async function alterar(id){
    let nome  = document.getElementById("nome-" + id).value;
    let preco = document.getElementById("preco-" + id).value;
    let ativo = document.getElementById("ativo-" + id).checked ? 1 : 0;

    const fd = new FormData();
    fd.append("nome", nome);
    fd.append("preco", preco);
    fd.append("ativo", ativo);

    const retorno = await fetch("../php/produto_alterar.php?id="+id,
        {
          method: 'POST',
          body: fd
        });
    const resposta = await retorno.json();
    document.getElementById("mensagem").innerText = resposta.mensagem;
}

document.getElementById("btnVoltar").addEventListener("click", () => {
    window.location.href = "../home/consulta_produtos.html";
});
