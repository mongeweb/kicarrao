<?

function verifica_permissao($cod_user,$nivel, $menu)
{

	//// SAIDA
	//// 0 - nao tem permissao
	//// 1 - tem permissao
	//// 2 - registro inexistente 
	//// 3 - valores inválidos
	
	$saida = 0;
	//// verifica os valores recebidos na função
	if(is_numeric($cod_user) && is_numeric($nivel) && is_string($menu))
	{

		///// PERMISSOES PARA ACESSO /////
		if(is_numeric($cod_user))
		{
			$verifica = mysql_query("SELECT permissoes,cod FROM usuarios WHERE cod = ".$cod_user);
			if(mysql_num_rows($verifica) > 0)
			{
				$array_arquivo = mysql_fetch_array($verifica);
				$perms = explode(" ",$array_arquivo['permissoes']);
				$qtd = count($perms);
				
				for($i=0;$i<$qtd;$i++)
				{
					$perms[$i] = str_replace(" ","",$perms[$i]);
					
				}
				if(in_array($menu, $perms))
				{
					$saida = 1;
				}
			
				else
				{
					$saida = 0;
				}	 
			}
			else
				$saida = 0;
		}
	
	}
	if($cod_user == '1')
	{
		$saida = 1;
	}
	if($menu == "home")
		$saida = 1;

	 //if verifica dados
	//echo $saida;
	return $saida;
}
?>
