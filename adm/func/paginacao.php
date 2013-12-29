<?php
/**
 * @author Luis Fernando Gomes
 * @copyright 2009
 * 
 * paginacaoOo()
 * 
 * @param integer $pag
 * @param array $paginas
 * @param string $classeNormal
 * @param string $classeDaPagina
 * @return void
 */
function paginacao($pag, $regs_pp, $total_reg, $classeNormal = '', $classeDaPagina = '') {

    $maximoRegistros = $regs_pp;
    $qtdObjs = $total_reg;
    $pagina = $pag;
    /** Define o número de páguinas listadas, *usar número ímpar  **/
	$numeroDePaginas = 7;

	$inicio = ($pagina - 1) * $maximoRegistros;

	$totalPaginas = ceil($qtdObjs / $maximoRegistros);
	$paginas = array();

	if ($totalPaginas > 1) {
		/** Define inicio e fim das paginas **/
		$ini = $pagina - ceil($numeroDePaginas / 2);
		$fim = $pagina + ceil($numeroDePaginas / 2);

		/** Testa se inicio é menor que 0
		* se for começa com 1 e termina com $numeroDePaginas
		**/
		if ($ini <= 0) {
			$ini = 1;
			$fim = $numeroDePaginas;
		}

		/** Testa se fim é maior que o total de paginas
		* se for começa com total de paginas - $numeroDePaginas - 1
		* e termina com total de paginas.
		**/
		if ($fim > $totalPaginas) {
			$fim = $totalPaginas;
			$ini = $totalPaginas - $numeroDePaginas - 1;
		}

		/** Testa novamente se inicio é menor que 0
		* se for começa com 1 e termina com total de paginas.
		**/
		if ($ini <= 0) {
			$ini = 1;
			$fim = $totalPaginas;
		}

		/** Preenche o array com as páginas. **/
		for ($ini; $ini <= $fim; $ini++) {
			$paginas[] = $ini;
		}
	}

	if (count($paginas) > 0) {
	    $paginaUrl = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
        
        if (!function_exists('unSetQueryStringVar')) {
            /**
             * @author Luis Fernando Gomes
             * @copyright 2009
             * 
             * unSetQueryStringVar()
             * 
             * Função que retorna a $queryString
             * retirando varialvel enviada no 
             * parametro $variavel. 
             * 
             * @param string $variavel
             * @param string $queryString
             * @return string
             */
            function unSetQueryStringVar($variavel, $queryString)
            {
                $queryArray = array();
                parse_str($queryString, $queryArray);
                unset($queryArray[$variavel]);
                $queryString = http_build_query($queryArray);
                return $queryString;
            }
        }
	    $queryString = unSetQueryStringVar('pag', $_SERVER['QUERY_STRING']);
        
        $queryStringSeparator = '?';
	    if (!empty($queryString)) {
	        $paginaUrl .= '?' . $queryString;
            $queryStringSeparator = '&';
	    }
	
	    echo '<span class="' . $classeDaPagina . '">P&aacute;ginas:&nbsp;</span>';
	   	if (($pag - 1) > 0) {
	    	echo '<a href="' . $paginaUrl . $queryStringSeparator . 'pag=' . ($pag - 1) . '"><span class="' . $classeNormal . '">&nbsp;<<&nbsp;</span></a>&nbsp;';
	    } 			
	    for ($i = 0; $i < count($paginas); $i++) {
	        if ($pag == $paginas[$i]) {
	            echo '<span class="' . $classeDaPagina . '">&nbsp;' . $paginas[$i] . '&nbsp;</span>&nbsp;';
	        } else {
                echo '<a href="' . $paginaUrl . $queryStringSeparator . 'pag=' . $paginas[$i] . '"><span class="' . $classeNormal . '">&nbsp;' . $paginas[$i] . '&nbsp;</span></a>&nbsp;';
	        }
	    }
	   	if (($pag + 1) <= $paginas[count($paginas)-1]) {
	    	echo '<a href="' . $paginaUrl . $queryStringSeparator . 'pag=' . ($pag + 1) . '"><span class="' . $classeNormal . '">&nbsp;>>&nbsp;</span></a>&nbsp;';
	    }
	}
}

function escreve_paginacao($param,$pg,$regs_pp,$total_reg) {

	$param = str_replace("pg=$pg","",$param);

	$intervalo = 6;
	$anterior  = $pg - 1;
	$proximo   = $pg + 1;
	$tp        = $total_reg / $regs_pp; // verifica o número total de páginas
	
	$pi        = $pg-($intervalo/2);
	$pf        = ($pg+($intervalo/2));
	
	if ($pi<1) { $pi=1; }
	if ($pf<$intervalo) { $pf=$intervalo; }
	$tmp = $pf - $pi;
	if($tmp >=6)
		$pi = $pi + 1;
	
	//"Anterior"
	if ($pg > 1){echo '<a href=?pg='.$anterior.'&'.$param.'><b>&laquo;</b> </a> ';}
	
		//cria os botoes links numéricos
		for ($pi;$pi<$pf;$pi++) {
		// Se número da página for menor que total de páginas
		  if ($pi < $tp+1){
			// se página atual for igual a página selecionada
			if ($pg == $pi){ echo '<span>&nbsp;'.$pi.'&nbsp;</span>&nbsp;'; }else{ echo '<a href=?pg='.$pi.'&'.$param.'>';
			if(strlen($pi) == 1)
				echo '&nbsp;'.$pi.'&nbsp;</a>&nbsp;';
			else
				echo $pi.'</a>&nbsp;';}
		  }
		}
	
	
	//"Proximo"
	if ($pg < $tp){echo ' <a href=?pg='.$proximo.'&'.$param.'> <b>&raquo;</b></a>';} 
}
?>