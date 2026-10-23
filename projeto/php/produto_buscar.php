<?php
// Situação-problema: na tela de produtos, o atendente digita parte do nome (por exemplo, "cad") e,
// opcionalmente, marca "somente com estoque". O sistema deve devolver os produtos que combinam com a busca.
include_once('conexao.php');

$retorno =[
    'status' =>'',
    'mensagem' => '',
    'data' => []
];

$busca = '%';
$termo = '';

$stmt = $conexao->prepare("SELECT nome FROM produto WHERE nome LIKE ? ")


?>