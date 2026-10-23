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

// FILTER_VALIDATE_INT recusa "0", "-3", "2.5" e "abc" (devolve false)
$inteiro_positivo = ['options' => ['min_range' => 1]];
$produto_id = filter_var($_POST['produto_id'] ?? '', FILTER_VALIDATE_INT, $inteiro_positivo);
$quantidade = filter_var($_POST['quantidade'] ?? '', FILTER_VALIDATE_INT, $inteiro_positivo);

if($produto_id === false || $quantidade === false){
    $retorno =[
        'status' => 'nok',
        'mensagem' => 'Dados invalidos.',
        'data' => []
    ];
}else{
    $stmt = $conexao->prepare("SELECT id, preco, estoque FROM produto WHERE id = ? AND ativo = 1");
    $stmt->bind_param('i', $produto_id);
    $stmt->execute();
    $produto = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if(!$produto){
        $retorno =[
            'status' => 'nok',
            'mensagem' => 'Produto nao encontrado.',
            'data' => []
        ];
    }elseif($quantidade > (int) $produto['estoque']){
        $retorno =[
            'status' => 'nok',
            'mensagem' => 'Estoque insuficiente.',
            'data' => []
        ];
    }else{
        // o preço vem do banco, nunca do navegador
        $valor_total = round((float) $produto['preco'] * $quantidade, 2);
        $usuario_id  = (int) $_SESSION['usuario_id'];

        // baixa no estoque e INSERT da venda acontecem juntos ou nenhum
        $conexao->begin_transaction();
        try{
            // o AND estoque >= ? protege contra duas vendas ao mesmo tempo
            $stmt = $conexao->prepare("UPDATE produto SET estoque = estoque - ? WHERE id = ? AND estoque >= ?");
            $stmt->bind_param('iii', $quantidade, $produto_id, $quantidade);
            $stmt->execute();
            $baixou = $stmt->affected_rows > 0;
            $stmt->close();

            if(!$baixou){
                throw new Exception('Estoque insuficiente.');
            }

            $stmt = $conexao->prepare("INSERT INTO venda (produto_id, usuario_id, quantidade, valor_total) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('iiid', $produto_id, $usuario_id, $quantidade, $valor_total);
            $stmt->execute();
            $venda_id = $conexao->insert_id;
            $stmt->close();

            $conexao->commit();

            $retorno =[
                'status' => 'ok',
                'mensagem' => 'Venda registrada.',
                'data' => [[
                    'venda_id'         => $venda_id,
                    'valor_total'      => $valor_total,
                    'estoque_restante' => (int) $produto['estoque'] - $quantidade
                ]]
            ];
        }catch(Exception $e){
            $conexao->rollback();
            $retorno =[
                'status' => 'nok',
                'mensagem' => $e->getMessage(),
                'data' => []
            ];
        }
    }
}

$conexao->close();

header('Content-type:application/json;charset=utf-8');
echo json_encode($retorno);
?>
