<?php
// a sessão é verificada antes de abrir o banco: sem login, nem chega a conectar
session_start();

if(!isset($_SESSION['usuario_id'])){
    $retorno =[
        'status' => 'nok',
        'mensagem' => 'Acesso negado. Faca login.',
        'data' => []
    ];
    header('Content-type:application/json;charset=utf-8');
    echo json_encode($retorno);
    exit;
}

include_once('conexao.php');

$retorno =[
    'status' =>'',
    'mensagem' => '',
    'data' => []
];

$stmt = $conexao->prepare("SELECT COUNT(*) AS total_produtos,
                                  COALESCE(SUM(estoque), 0) AS total_unidades,
                                  COALESCE(SUM(preco * estoque), 0) AS valor_estoque
                           FROM produto
                           WHERE ativo = 1");
$stmt->execute();
$resultado = $stmt->get_result();

// essa consulta sempre devolve 1 linha, mesmo sem produtos (com os valores zerados)
$linha = $resultado->fetch_assoc();
$linha['total_produtos'] = (int) $linha['total_produtos'];
$linha['total_unidades'] = (int) $linha['total_unidades'];
$linha['valor_estoque']  = (float) $linha['valor_estoque'];

$retorno =[
    'status' => 'ok',
    'mensagem' => 'Resumo do estoque',
    'data' => [$linha]
];

$stmt->close();
$conexao->close();

header('Content-type:application/json;charset=utf-8');
echo json_encode($retorno);
?>
