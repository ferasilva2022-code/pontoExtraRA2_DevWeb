document.getElementById('btnConsultar').addEventListener('click', ()=>{
    consultar();
});
async function consultar(){
    const retorno = await fetch("../php/produto_listar.php", {
        method: 'GET',
    });

    const resposta = await retorno.json();
    console.log(resposta);
}
