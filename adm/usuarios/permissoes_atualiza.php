<?php
require_once '../../configRoot.php';
require_once ADMIN_PATH.'sessao_verifica.php';
require_once ADMIN_FUNC_PATH.'conexao.php';
$conexao = conexao(); # Função Implemantada
require_once ADMIN_FUNC_PATH.'ordenar.php';

$ordenado="";
//echo $ordenado;
//echo $ordenado;
//$_POST['Submit'] <> ""
if(($_POST['Submit'] <> ""))
{
	$ordenado = ordenar($_POST['tabelas']);
	
	/*	$tipo = $_POST['tipo'];*/
	$cod_user = $_POST['cod'];
	$ordenado = str_replace("  "," ",$ordenado);
	if($ordenado[0] == " ")
	{
		$ordenado = substr($ordenado,1,strlen($ordenado));
	}
	//echo $_POST['tabelas'];

	//echo $ordenado;
	//echo "<br>";
	//echo $cod_user;
	if($cod_user != "")
		$resultado = mysql_query("UPDATE usuarios SET permissoes = '".$ordenado."' WHERE cod = ".$cod_user);
	//echo mysql_error();
	if($resultado)
	{
		echo " <script language=\"JavaScript1.2\"> \n";
		echo " <!-- \n";
		echo " alert(\"Permissao atualizada com sucesso!!\");\n";
		echo " location.replace('http://".ADMIN_URL."/principal.php?id=1&subid=1'); \n";
		echo " //--> \n";
		echo " </script> \n";
	}
	else
	{

		echo " <script language=\"JavaScript1.2\"> \n";
		echo " <!-- \n";
		echo " alert(\"\tErro ao atualizar!!\n\n\");\n";
		echo " location.replace('http://".ADMIN_URL."/principal.php?id=1&subid=1'); \n";
		echo " //--> \n";
		echo " </script> \n";
		
	}
}	
?>
