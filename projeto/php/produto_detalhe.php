<?php
include_once('conexao.php');

$retorno =[
    'status' =>'',
    'mensagem' => '',
    'data' => []
];

// com id: mostra só aquele produto; sem id: mostra todos, inclusive os inativos
if(!empty($_GET['id'])){
    $stmt = $conexao->prepare("SELECT * FROM produto WHERE id = ? ");
    $stmt->bind_param("i",$_GET['id']);
}else{
    $stmt = $conexao->prepare("SELECT * FROM produto ORDER BY ativo DESC, preco ASC");
}
$stmt -> execute();
$resultado = $stmt->get_result();

$tabela =[];
if($resultado->num_rows>0){
    while($linha = $resultado -> fetch_assoc()){
        $tabela[]=$linha;
    }
    
    $retorno =[
        'status' => 'ok',
        'mensagem' => 'Consulta realizada com sucesso!',
        'data' => $tabela
    ];
}else{
    $retorno =[
        'status' => 'nok',
        'mensagem' => 'Não existe registros',
        'data' => []
    ];
}
$stmt ->close();
$conexao->close();

header('Content-type:application/json;charset=utf-8');
echo json_encode($retorno);

?>