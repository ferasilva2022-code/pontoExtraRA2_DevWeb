document.getElementById("btnVoltar").addEventListener('click', () =>{
    window.location.href = "../home/consulta_produtos.html";
});

document.addEventListener("DOMContentLoaded", () => {
    // excluir_produtos.html?id=3 mostra só o produto 3; sem id, mostra todos
    const url = new URLSearchParams(window.location.search);
    const id = url.get("id");
    buscar(id);
});

// só lista os produtos (usa o produto_detalhe.php, que não apaga nada)
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
                    <td>${produto.nome}</td>
                    <td><button type="button" onclick="excluir(${produto.id})">Excluir</button></td>
                </tr>
            `;
        }
    }else{
        document.getElementById("mensagem").innerText = resposta.mensagem;
    }
}

async function excluir(id){
    if(!confirm("Tem certeza que deseja excluir este produto?")){
        return;
    }

    const retorno = await fetch("../php/produto_excluir.php?id=" + id);
    const resposta = await retorno.json();
    document.getElementById("mensagem").innerText = resposta.mensagem;

    // recarrega a tabela para o produto excluído sumir
    buscar();
}
