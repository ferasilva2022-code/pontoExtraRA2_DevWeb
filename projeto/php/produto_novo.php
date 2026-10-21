<?php
//Situação-problema: a papelaria Boa Letra precisa cadastrar novos produtos pelo sistema. 
//O formulário envia nome, preço, estoque inicial e se o produto está ativo.
// O sistema deve gravar o produto e avisar se deu certo.
include_once('conexao.php');

$retorno = [
    'status' => '',
    'mensagem' => '',
    'data' => []
];

$nome_produto= $_POST['nome'];
$preco = $_POST['preco'];
$estoque = !empty($_POST['estoque']) ? $_POST['estoque'] : 0;
$ativo = $_POST['ativo'];

if(empty($nome_produto) || empty($preco) ){
    $retorno =[
            'status' => 'nok',
            'mensagem' => 'Falha ao cadastrar novo produto',
            'data' => []
        ];
    
    }else{

        $stmt = $conexao->prepare("INSERT INTO produto(nome,preco,estoque,ativo) VALUES (?,?,?,?)");
        $stmt->bind_param(('sdii'),$nome_produto,$preco,$estoque,$ativo);

        $stmt->execute();


        if($stmt->affected_rows > 0){
                $retorno =[
                    'status' => 'ok',
                    'mensagem' => 'Produto cadastrado com sucesso!',
                    'data' => []
                ];
            }else{
                $retorno =[
                    'status' => 'nok',
                    'mensagem' => 'Falha ao cadastrar novo produto',
                    'data' => []
                ];
            }

        $stmt->close();
}
$conexao->close();

header('Content-Type: application/json; charset=utf-8');
echo json_encode($retorno);

?>