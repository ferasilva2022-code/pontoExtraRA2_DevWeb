<?php
include_once('conexao.php');

$retorno =[
    'status' =>'',
    'mensagem' => '',
    'data' => []
];

if(!isset($_GET['id'])){
    $retorno =[
        'status' => 'nok',
        'mensagem' => 'ID nao informado',
        'data' => []
    ];
}else{
    $id         = (int) $_GET['id'];
    $tipo       = $_POST['tipo'] ?? '';
    $quantidade = (int) ($_POST['quantidade'] ?? 0);

    if(!in_array($tipo, ['entrada', 'saida']) || $quantidade <= 0){
        $retorno =[
            'status' => 'nok',
            'mensagem' => 'Dados invalidos.',
            'data' => []
        ];
    }else{
        // a conta é feita dentro do SQL, assim duas movimentações ao mesmo tempo não se atrapalham
        if($tipo == 'entrada'){
            $stmt = $conexao->prepare("UPDATE produto SET estoque = estoque + ? WHERE id = ?");
            $stmt->bind_param('ii', $quantidade, $id);
        }else{
            // só baixa se houver saldo suficiente
            $stmt = $conexao->prepare("UPDATE produto SET estoque = estoque - ? WHERE id = ? AND estoque >= ?");
            $stmt->bind_param('iii', $quantidade, $id, $quantidade);
        }
        $stmt->execute();
        $alterou = $stmt->affected_rows > 0;
        $stmt->close();

        if(!$alterou){
            $retorno =[
                'status' => 'nok',
                'mensagem' => $tipo == 'saida' ? 'Estoque insuficiente.' : 'Produto nao encontrado.',
                'data' => []
            ];
        }else{
            // lê o estoque atualizado depois do UPDATE
            $stmt = $conexao->prepare("SELECT id, estoque FROM produto WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $linha = $stmt->get_result()->fetch_assoc();
            $linha['id']      = (int) $linha['id'];
            $linha['estoque'] = (int) $linha['estoque'];
            $stmt->close();

            $retorno =[
                'status' => 'ok',
                'mensagem' => 'Estoque atualizado.',
                'data' => [$linha]
            ];
        }
    }
}

$conexao->close();

header('Content-type:application/json;charset=utf-8');
echo json_encode($retorno);
?>
