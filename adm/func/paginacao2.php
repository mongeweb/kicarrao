<?
//////////////////////////////////////////////////////////////////////////////////////////
///tabela///parametros_de_busca///tamanho_pagina///pagina_atual///
///endereco_da_pagina(ex.:principal.php?lista_coisas.php)///classe_ativo///classe_proxima

//by Mr.Quack
////exemplo de uso

/*include 'paginacao.php';

$resultado1 = paginacao('asdep_imprensa','WHERE '.$restrita.' ORDER BY cod DESC',20,$_GET['pagina'],'principal.php?id=imprensalista&','paginacaoativo','paginacao');*/

//////////////////////////////////////////////////////////////////////////////////////////
function paginacao2($tabela,$TAMANHO_PAGINA,$pagina,$endereco,$classe1,$classe2,$classe3)
{
//exminar a pagina

	if (!$pagina) {
	   $inicio = 0;
	   $pagina=1;
	}
	else {
	   $inicio = ($pagina - 1) * $TAMANHO_PAGINA;
	} 

	$sqlp = $tabela;
	$resultadop = mysql_query($sqlp);
	echo mysql_error();
	$linhasp = mysql_num_rows($resultadop);
	$totalPaginas = ceil($linhasp / $TAMANHO_PAGINA); 

	if ($totalPaginas > 1) {
		/** Define inicio e fim das paginas **/
		$ini = $pagina - 3;
		$fim = $pagina + 3;

		echo "<span class=\"".$classe1."\">PÁGINAS&nbsp;</span> ";
		echo "<span class=\"".$classe1."\">&lt;</span>";

		/** Testa se inicio é menor que 0
		 * se for começa com 1 e termina com 7
		 **/
		if ($ini <= 0) {
			$ini = 1;
			$fim = 7;
		}

		/** Testa se fim é maior que o total de paginas
		 * se for começa com total de paginas - 6 
		 * e termina com total de paginas.
		 **/
		if ($fim > $totalPaginas) {
			$fim = $totalPaginas;
			$ini = $totalPaginas - 6;
		}

		/** Testa novamente se inicio é menor que 0
		 * se for começa com 1 e termina com total de paginas.
		 **/
		if ($ini <= 0) {
			$ini = 1;
			$fim = $totalPaginas;
		}

		$paginas = array();
		/** Preenche o array com as páginas. **/
		for ($ini; $ini <= $fim; $ini++) {

			if ($pagina == $ini) 
				echo "<span class=\"".$classe2."\">&nbsp;".$pagina."&nbsp;</span>";
			else
				echo "<a class=\"".$classe3."\" href='".$endereco."pagina=" . $ini . "'>&nbsp;" . $ini . "&nbsp;</a>";

			if (($ini > 0) && ($ini != $fim))
				echo "<span class=\"".$classe1."\">&nbsp;&frasl;&nbsp;</span>";

		}

		echo "<span class=\"".$classe1."\">&gt;</span>";

	}

	$resultado1 = mysql_query($tabela." limit " . $inicio . "," . $TAMANHO_PAGINA);

	return $resultado1;
}
?>			
