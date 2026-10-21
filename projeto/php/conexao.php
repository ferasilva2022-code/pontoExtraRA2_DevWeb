<?php
$sevidor= 'localhost:3306'; // lembrar de verificar qual porta esta sendo utilizada no XAMPP
$usuario= 'root';
$senha= '';
$nome_banco= 'projeto';

$conexão = new mysqli($servidor,$usuario,$senha,$nome_banco);
if($conexao -> conect_error){
    echo $conexao-> conect_error;
}
?>