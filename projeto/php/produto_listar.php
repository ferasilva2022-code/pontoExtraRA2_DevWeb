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
$stmt = $conexao->prepare("SELECT id,nome,preco FROM produto WHERE ativo=1 ORDER BY preco ASC");
$stmt->execute();
$resultado = $stmt->get_result();

$tabela = [];
while($linha = $resultado->fetch_assoc()){
    $tabela[] = $linha;
}

if($resultado->num_rows > 0){
        $retorno =[
            'status' => 'ok',
            'mensagem' => 'Produtos disponíveis:',
            'data' => $tabela
        ];
    }else{
        $retorno =[
            'status' => 'nok',
            'mensagem' => 'Não ha produtos disponíveis',
            'data' => []
        ];
    }

$stmt->close();

$conexao->close();

header('Content-Type: application/json; charset=utf-8');
echo json_encode($retorno);
?>