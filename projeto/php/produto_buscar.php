<?php
include_once('conexao.php');

$retorno =[
    'status' =>'',
    'mensagem' => '',
    'data' => []
];

$termo = trim($_GET['termo'] ?? '');

if($termo == ''){
    $retorno =[
        'status' => 'nok',
        'mensagem' => 'Informe um termo de busca.',
        'data' => []
    ];
}else{
    // o filtro opcional escolhe entre duas strings fixas, sem concatenar dados do usuário
    if(isset($_GET['somente_estoque']) && $_GET['somente_estoque'] == '1'){
        $sql = "SELECT id, nome, preco, estoque, ativo FROM produto
                WHERE ativo = 1 AND nome LIKE ? AND estoque > 0
                ORDER BY nome";
    }else{
        $sql = "SELECT id, nome, preco, estoque, ativo FROM produto
                WHERE ativo = 1 AND nome LIKE ?
                ORDER BY nome";
    }

    // o curinga % é montado no PHP e vai pelo bind
    $busca = '%' . $termo . '%';

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('s', $busca);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $tabela = [];
    while($linha = $resultado->fetch_assoc()){
        $linha['id']      = (int) $linha['id'];
        $linha['preco']   = (float) $linha['preco'];
        $linha['estoque'] = (int) $linha['estoque'];
        $linha['ativo']   = (int) $linha['ativo'];
        $tabela[] = $linha;
    }

    if(count($tabela) > 0){
        $retorno =[
            'status' => 'ok',
            'mensagem' => 'Produtos encontrados.',
            'data' => $tabela
        ];
    }else{
        $retorno =[
            'status' => 'nok',
            'mensagem' => 'Nenhum produto encontrado.',
            'data' => []
        ];
    }
    $stmt->close();
}

$conexao->close();

header('Content-type:application/json;charset=utf-8');
echo json_encode($retorno);
?>
