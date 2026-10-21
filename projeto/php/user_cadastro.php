<?php
include_once("conexao.php");

$retorno = [
    'status' => '',
    'mensagem' => '',
    'data' => []
];

$stmt = $conexao->prepare("INSERT INTO cliente (nome, email, usuario, senha, instagram) VALUES (?,?,?,?,?)");
$stmt ->bind_param("sssss", $_POST['nome'],$_POST['email'],$_POST['usuario'],$_POST['senha'],$_POST['instagram']);
try{
    $stmt -> execute();

    if($stmt->affected_rows > 0){
        $retorno =[
            'status' => 'ok',
            'mensagem' => 'Usuário cadastrado com sucesso!',
            'data' => []
        ];
    }else{
        $retorno =[
            'status' => 'nok',
            'mensagem' => 'Falha ao cadastrar novo usuário',
            'data' => []
        ];
    }
}catch(Exception $e){
    // cai aqui, por exemplo, quando o usuário já existe (coluna UNIQUE)
    $retorno =[
        'status' => 'nok',
        'mensagem' => 'Falha ao cadastrar novo usuário. Verifique se o usuário já existe.',
        'data' => []
    ];
}
$stmt->close();
$conexao->close();


header("Content-type:application/json;charset=utf-8");
echo json_encode($retorno);

?>