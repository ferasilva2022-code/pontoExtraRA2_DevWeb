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
header('Content-Type: application/json; charset=utf-8');

$nome_produto= $_POST['nome_produto'];
$preco = $_POST['preco'];
$estoque = $_POST['estoque'];
$ativo = isset($_POST['ativo']) ? 1 : 0;

// if(isset($nome_produto))
echo json_encode($retorno);
?>