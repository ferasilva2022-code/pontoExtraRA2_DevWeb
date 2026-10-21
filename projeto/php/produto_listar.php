<?php
// Situação-problema: a vitrine do site da Boa Letra deve mostrar apenas os produtos disponíveis para venda, 
// do mais barato ao mais caro, para o cliente comparar preços.

include_once('conexao.php');

$retorno =[
    'status' =>'',
    'mensagem' => '',
    'data' => []
];

// SELECT id, nome, preco, estoque FROM produto WHERE ativo = 1 ORDER BY preco ASC
$stmt = $conexao->prepare("SELECT id,nome,preco,estoque FROM produto WHERE ativo=1 ORDER BY preco ASC");
$stmt->execute();
$resultado = $stmt->get_result();


if($stmt->affected_rows > 0){
        $retorno =[
            'status' => 'ok',
            'mensagem' => 'Produtos listados com sucesso!',
            'data' => []
        ];
    }else{
        $retorno =[
            'status' => 'nok',
            'mensagem' => 'Falha ao listar produto',
            'data' => []
        ];
    }

$stmt->close();

$conexao->close();

header('Content-Type: application/json; charset=utf-8');
echo json_encode($retorno);
?>