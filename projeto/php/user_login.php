<?php
include_once('conexao.php');

$retorno =[
    'status' =>'',
    'mensagem' => '',
    'data' => []
];

$stmt = $conexao->prepare("SELECT * FROM cliente WHERE usuario = ? AND senha = ?");
$stmt->bind_param("ss",$_POST['usuario'],$_POST['senha']);

$stmt -> execute();
$resposta = $stmt -> get_result();

$tabela_usuario=[];
if($resposta->num_rows > 0){
    while($linha_tabela = $resposta -> fetch_assoc()){
        $tabela_usuario[]= $linha_tabela;
    }

    session_start();
    $_SESSION['usuario'] = $tabela_usuario;
    $_SESSION['usuario_id'] = $tabela_usuario[0]['id'];

    $retorno =[
        'status' => 'ok',
        'mensagem' => 'Usuário cadastrado com sucesso!',
        'data' => $tabela_usuario
    ];
}else{
    $retorno =[
        'status' => 'nok',
        'mensagem' => 'Não existe registros',
        'data' => []
    ];
}
$stmt->close();
$conexao->close();


header("Content-type:application/json;charset=utf-8");
echo json_encode($retorno);
?>