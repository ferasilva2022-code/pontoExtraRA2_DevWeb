<?php
// Situação-problema: a vitrine do site da Boa Letra deve mostrar apenas os produtos disponíveis para venda, 
// do mais barato ao mais caro, para o cliente comparar preços.

include_once('conexao.php');

$retorno =[
    'status' =>'',
    'mensagem' => '',
    'data' => []
];
?>