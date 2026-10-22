<?php
include_once('conexao.php');

$retorno =[
    'status' =>'',
    'mensagem' => '',
    'data' => []
];

if(isset($_GET['id'])){
        // Simulando as informações que vem do front
        $nome       = $_POST['nome']; // $_POST['nome'];
        $preco      = $_POST['preco'];
        $ativo      = (int) $_POST['ativo'];
    
        // Preparando para inserção no banco de dados
        $stmt = $conexao->prepare("UPDATE produto SET nome = ?, preco = ?, ativo = ? WHERE id = ?");
        $stmt->bind_param("sdii",$nome, $preco, $ativo, $_GET['id']);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $retorno = [
                'status'    => 'ok',
                'mensagem'  => 'Registro alterado com sucesso.',
                'data'      => []
            ];
        }else{
            $retorno = [
                'status'    => 'nok',
                'mensagem'  => 'Não foi possível alterar um registro.'.json_encode($_GET),
                'data'      => []
            ];
        }
        $stmt->close();
    }else{
        $retorno = [
            'status'    => 'nok',
            'mensagem'  => 'Não foi possível alterar um registro sem um ID informado.',
            'data'      => []
        ];
    }
       
    $conexao->close();

    header("Content-type:application/json;charset=utf-8");
    echo json_encode($retorno);


?>