<?php
  
	require_once '../../configRoot.php';
	require_once ADMIN_FUNC_PATH.'conexao.php';
	$conexao = conexao(); # Função Implemantada
	$nome = isset($_POST['nome']) ? mysql_real_escape_string($_POST['nome']) : '';
    $email = isset($_POST['email']) ? mysql_real_escape_string($_POST['email']) : '';
    $codigoFipe = isset($_POST['codigoFipe']) ? mysql_real_escape_string($_POST['codigoFipe']) : '';
    $marca = isset($_POST['marca']) ? mysql_real_escape_string($_POST['marca']) : '';
    $modelo = isset($_POST['modelo']) ? mysql_real_escape_string($_POST['modelo']) : '';
    $anoModelo = isset($_POST['anoModelo']) ? mysql_real_escape_string($_POST['anoModelo']) : '';
    $valorMedio = isset($_POST['valorMedio']) ? mysql_real_escape_string($_POST['valorMedio']) : '';
    $modelo = array();
    $hoje = date('Y-m-d');
    $verifica = mysql_query("SELECT * FROM mailing WHERE email = '$email'");
    $numVerifica = mysql_num_rows($verifica);
    if($numVerifica == 0)
    {
        $sql = "INSERT INTO mailing (dataCadastro, nome, email) VALUES ('{$hoje}', '{$nome}', '{$email}')";
        for($x = 0;$x < 5;$x++)
        {
            $query = mysql_query($sql);
            if($query)
            {
                break;
            }
        }
    }
    mysql_close();
	echo json_encode($modelo);
?>