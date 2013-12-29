<?php
require_once 'configRoot.php';
require_once ADMIN_FUNC_PATH."formatting.php";
$bloco = isset($_GET['bloco']) ? $_GET['bloco'] : '';
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : '';
$retorno = array();
if($bloco == 'superDestaque')
{
    $retorno['prev'] = '';
    $retorno['next'] = '';
    $retorno['nItens'] = 0;
    $codSuper = isset($_GET['codSuper']) ? $_GET['codSuper'] : 1;
    $num_por_pagina = 12; 
	if(empty($pagina))
	{
		$primeiro_registro = 0;
		$pagina = 1;
	}
	else
	{
		$primeiro_registro = ($pagina - 1) * $num_por_pagina;
	}
    
    if(isset($_SESSION['superDestaque'][$codSuper]) && count($_SESSION['superDestaque'][$codSuper]) > 0)
    {
        $acao = "slice";  
    }
    else
    {
        $acao = "new";
    }
    $retorno['acao'] = $acao;
    if($acao == "new")
    {
        $anunciosSuperDestaque = array();
        $dataHoje = date("Y-m-d");
        $filtroSuper = '';
        switch($codSuper)
        {
            case 3:
            {
                /** SUPER DESTAQUE - OUTROS **/
                $filtroSuper = 'AND ca.tipoVeiculo != 1 AND ca.tipoVeiculo != 2';
                /** SUPER DESTAQUE - OUTROS **/
                break;
            }
            case 2:
            {
                /** SUPER DESTAQUE - MOTO **/
                $filtroSuper = 'AND ca.tipoVeiculo = 2';
                /** SUPER DESTAQUE - MOTO **/
                break;
            }
            case 1:
            default:
            {
                /** SUPER DESTAQUE - CARROS **/
                $filtroSuper = 'AND ca.tipoVeiculo = 1';
                /** SUPER DESTAQUE - CARROS **/
                break;
            }
        }
        $conexao = conexao();
        $qSuperPart = mysql_query("SELECT ca.cod, ca.cor, ca.combustivel, ca.anoFabricacao, c.cleanTitulo, c.estado, c.cidade, ca.km, vm.marca, ca.valor, vv.versao, vmd.modelo,
                                (SELECT a.arquivo FROM arquivos AS a WHERE a.codReferencia = ca.cod
                                AND a.referencia = 'clientesAnuncios' AND a.tipo = 1 ORDER BY a.capa DESC LIMIT 1) AS arquivo
                                FROM clientesAnuncios AS ca
                                INNER JOIN clientes AS c ON c.cod = ca.codCliente
                                INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
                                INNER JOIN veiculosModelos AS vmd ON vmd.cod = ca.modelo
                                LEFT JOIN veiculosVersoes AS vv ON vv.cod = ca.versao
                                WHERE c.tipoAnuncio = 1 AND c.situacao = 1 $filtroSuper AND ca.codPlanoParticular = 4
                                AND ca.status = 1 AND '$dataHoje' BETWEEN ca.dataLiberacaoAnuncio AND ca.dataValidadeAnuncio");
                                //echo mysql_error();
        $nSuperPart = mysql_num_rows($qSuperPart);
        if($nSuperPart > 0)
        {
            for($a=0;$a<$nSuperPart;$a++)
            {
                $tpSuperPart = mysql_fetch_assoc($qSuperPart);
                $anunciosSuperDestaque[] = array(
                                                    'cod' => $tpSuperPart['cod'],
                                                    'cor' => $tpSuperPart['cor'],
                                                    'combustivel' => combustivel($tpSuperPart['combustivel']),
                                                    'anoFabricacao' => $tpSuperPart['anoFabricacao'],
                                                    'marca' => $tpSuperPart['marca'],
                                                    'versao' => $tpSuperPart['versao'],
                                                    'modelo' => $tpSuperPart['modelo'],
                                                    'cidade' => $tpSuperPart['cidade'],
                                                    'estado' => $tpSuperPart['estado'],
                                                    'km' => $tpSuperPart['km'],
                                                    'valor' => "R$ ".number_format((float)$tpSuperPart['valor'],2,',','.'),
                                                    'arquivo' => $tpSuperPart['arquivo'],
                                                    'anunciante' => 'Particular',
                                                    'cleanTitulo' => $tpSuperPart['cleanTitulo'],
                                                    'tipoAnuncio' => 1,
                                                );
            }
            
        }
        
        $qSuperRev = mysql_query("SELECT ca.cod, ca.cor, ca.combustivel, ca.anoFabricacao, c.estado, c.cidade, ca.km, vm.marca, c.nomeFantasia, c.cleanTitulo, c.tipoRevenda, ca.valor, vv.versao, vmd.modelo,
                                (SELECT a.arquivo FROM arquivos AS a WHERE a.codReferencia = ca.cod
                                AND a.referencia = 'clientesAnuncios' AND a.tipo = 1 ORDER BY a.capa DESC LIMIT 1) AS arquivo
                                FROM clientesAnuncios AS ca 
                                INNER JOIN clientes AS c ON c.cod = ca.codCliente
                                INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
                                INNER JOIN veiculosModelos AS vmd ON vmd.cod = ca.modelo
                                LEFT JOIN veiculosVersoes AS vv ON vv.cod = ca.versao
                                WHERE c.tipoAnuncio = 2 AND c.situacao = 1 $filtroSuper AND ca.superDestaqueHome = '1' AND ca.destaqueHome = '0' AND ca.status = 1
                                ORDER BY RAND()");
                                //echo mysql_error();
        $nSuperRev = mysql_num_rows($qSuperRev);
        if($nSuperRev > 0)
        {
            for($a=0;$a<$nSuperRev;$a++)
            {
                $tpSuperRev = mysql_fetch_assoc($qSuperRev);
                $anunciosSuperDestaque[] = array(
                                                    'cod' => $tpSuperRev['cod'],
                                                    'cor' => $tpSuperRev['cor'],
                                                    'combustivel' => combustivel($tpSuperRev['combustivel']),
                                                    'anoFabricacao' => $tpSuperRev['anoFabricacao'],
                                                    'marca' => $tpSuperRev['marca'],
                                                    'versao' => $tpSuperRev['versao'],
                                                    'modelo' => $tpSuperRev['modelo'],
                                                    'cidade' => $tpSuperRev['cidade'],
                                                    'estado' => $tpSuperRev['estado'],
                                                    'km' => $tpSuperRev['km'],
                                                    'valor' => "R$ ".number_format((float)$tpSuperRev['valor'],2,',','.'),
                                                    'arquivo' => $tpSuperRev['arquivo'],
                                                    'anunciante' => $tpSuperRev['nomeFantasia'],
                                                    'cleanTitulo' => $tpSuperRev['cleanTitulo'], 
                                                    'tipoAnuncio' => 2,
                                                );
            }
            
        }
        mysql_close();
        shuffle($anunciosSuperDestaque);
        
        $_SESSION['superDestaque'][$codSuper] = $anunciosSuperDestaque;
        
        $lisSuperDestaque = array();
        if(count($anunciosSuperDestaque) > 0)
        {
            $array = array_slice($anunciosSuperDestaque,$primeiro_registro,$num_por_pagina);
            $nArray = count($array);
            $retorno['nItens'] = $nArray;
            if($nArray > 0)
            {
                foreach($array as $k => $anuncioSuperDestaque)
                {
                    $urlMarcaModelo = ($anuncioSuperDestaque['marca'] != '' ? $anuncioSuperDestaque['marca'] : '').($anuncioSuperDestaque['modelo'] ? ' '.$anuncioSuperDestaque['modelo'] : '');
                    $urlMarcaModelo = mg_substituirEspacosPorTreacos($urlMarcaModelo);
                    if($anuncioSuperDestaque['tipoAnuncio'] == 1)
                    {
                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/particular/'.($anuncioSuperDestaque['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$anuncioSuperDestaque['cod'].($anuncioSuperDestaque['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioSuperDestaque['estado']) : '').($anuncioSuperDestaque['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioSuperDestaque['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$anuncioSuperDestaque['cod'];
                    }
                    else
                    {
                        
                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/revenda/'.$anuncioSuperDestaque['cleanTitulo'].'/'.($anuncioSuperDestaque['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$anuncioSuperDestaque['cod'].($anuncioSuperDestaque['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioSuperDestaque['estado']) : '').($anuncioSuperDestaque['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioSuperDestaque['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$anuncioSuperDestaque['cod'];
                    }
                    $lisSuperDestaque[] = "
                            <div class='ofertalistamedio'>
                                <div class='ofertalistaimgwrap'>
                                    <div class='ofertalistaimg'><a href='".$link."'><img src='".($anuncioSuperDestaque['arquivo'] != '' ? ssl().PROJECT_URL.'/arquivos/clientesAnuncios/'.$anuncioSuperDestaque['arquivo'] : ssl().PROJECT_URL.'/img/placeholderHome1.jpg')."' alt='Ofertas' /></a></div>
                                </div>
                                <div class='ofertalistatexto'>
                                    <div class='ofertalistapreco'>{$anuncioSuperDestaque['valor']} </div>
                                    <p class='ofertalistatitulo'><span>{$anuncioSuperDestaque['marca']} {$anuncioSuperDestaque['versao']}</span></p>
                                    <p><b>{$anuncioSuperDestaque['anunciante']}</b></p>
                                </div>
                            </div>";
							// linha retirada por solicitação do Rafael em 2013/12/06
							//<p>{$anuncioSuperDestaque['combustivel']} | {$anuncioSuperDestaque['cor']} | {$anuncioSuperDestaque['anoFabricacao']}</p>
    						// variável retirada por solicitação do cliente pois estava repetindo nome do veículo
    						//{$anuncioSuperDestaque['marca']}
                    
                }
                $super = implode("",$lisSuperDestaque);
                $retorno['html'] = $super;
                
                $total_paginas = (count($anunciosSuperDestaque)/$num_por_pagina);
                $total_paginas = ceil($total_paginas);
                $prev = ($pagina-1);
                $next = ($pagina+1);
                $painel = "";  
                if ($pagina > 1)
                {
                    $retorno['prev'] = $prev;
                }
                else 
                { 
                    $retorno['prev'] = $total_paginas > 1 ? $total_paginas : '';
                }
                
                if ($total_paginas > 1 && $pagina < $total_paginas )
                {
                    $retorno['next'] = $next;
                }
                else 
                { 
                    $retorno['next'] = $total_paginas > 1 ? 1 : '';
                }
            }
        }
        else
        {
            $retorno['html'] = "<span style='margin-top: 119px;float: left; width: 100%;'>Nenhum anúncio nesta categoria!</span>";
        }
    }
    elseif($acao == "slice")
    {
        $array = array_slice($_SESSION['superDestaque'][$codSuper],$primeiro_registro,$num_por_pagina);
        $nArray = count($array);
        $retorno['nItens'] = $nArray;
        if($nArray > 0)
        {
            foreach($array as $k => $anuncioSuperDestaque)
            {
                $urlMarcaModelo = ($anuncioSuperDestaque['marca'] != '' ? $anuncioSuperDestaque['marca'] : '').($anuncioSuperDestaque['modelo'] ? ' '.$anuncioSuperDestaque['modelo'] : '');
                $urlMarcaModelo = mg_substituirEspacosPorTreacos($urlMarcaModelo);
                    
                if($anuncioSuperDestaque['tipoAnuncio'] == 1)
                {
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/particular/'.($anuncioSuperDestaque['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$anuncioSuperDestaque['cod'].($anuncioSuperDestaque['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioSuperDestaque['estado']) : '').($anuncioSuperDestaque['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioSuperDestaque['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$anuncioSuperDestaque['cod'];
                }
                else
                {
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/revenda/'.$anuncioSuperDestaque['cleanTitulo'].'/'.($anuncioSuperDestaque['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$anuncioSuperDestaque['cod'].($anuncioSuperDestaque['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioSuperDestaque['estado']) : '').($anuncioSuperDestaque['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioSuperDestaque['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$anuncioSuperDestaque['cod'];
                }
                $lisSuperDestaque[] = "
                        <div class='ofertalistamedio'>
                            <div class='ofertalistaimgwrap'>
                                <div class='ofertalistaimg'><a href='".$link."'><img src='".($anuncioSuperDestaque['arquivo'] != '' ? ssl().PROJECT_URL.'/arquivos/clientesAnuncios/'.$anuncioSuperDestaque['arquivo'] : ssl().PROJECT_URL.'/img/placeholderHome1.jpg')."' alt='Ofertas' /></a></div>
                            </div>
                            <div class='ofertalistatexto'>
                                <div class='ofertalistapreco'>{$anuncioSuperDestaque['valor']} </div>
                                <p class='ofertalistatitulo'><span>{$anuncioSuperDestaque['marca']} {$anuncioSuperDestaque['versao']}</span></p>
                                <p><b>{$anuncioSuperDestaque['anunciante']}</b></p>
                            </div>
                        </div>";
						// linha retirada a pedido do Rafael em 2013/12/06
						//<p>{$anuncioSuperDestaque['combustivel']} | {$anuncioSuperDestaque['cor']} | {$anuncioSuperDestaque['anoFabricacao']}</p>
						
    		}
            $super = implode("",$lisSuperDestaque);
            $retorno['html'] = $super;
            
            $total_paginas = (count($_SESSION['superDestaque'][$codSuper])/$num_por_pagina);
            $total_paginas = ceil($total_paginas);
            $prev = ($pagina-1);
            $next = ($pagina+1);
            $painel = "";  
            if ($pagina > 1)
            {
                $retorno['prev'] = $prev;
            }
            else 
            { 
                $retorno['prev'] = $total_paginas > 1 ? $total_paginas : '';
            }
            
            if ($total_paginas > 1 && $pagina < $total_paginas )
            {
                $retorno['next'] = $next;
            }
            else 
            { 
                $retorno['next'] = $total_paginas > 1 ? 1 : '';
            }
        }
    }
    die(json_encode($retorno));
}
elseif($bloco == 'destaque')
{
    $retorno['prev'] = '';
    $retorno['next'] = '';
    $retorno['nItens'] = 0;
    $codDestaque = isset($_GET['codDestaque']) ? $_GET['codDestaque'] : $codDestaque;
    $num_por_pagina = 12; 
	if(empty($pagina))
	{
		$primeiro_registro = 0;
		$pagina = 1;
	}
	else
	{
		$primeiro_registro = ($pagina - 1) * $num_por_pagina;
	}
    
    if(isset($_SESSION['destaque'][$codDestaque]) && count($_SESSION['destaque'][$codDestaque]) > 0)
    {
        $acao = "slice";  
    }
    else
    {
        $acao = "new";
    }
    $retorno['acao'] = $acao;
    if($acao == "new")
    {
        $dataHoje = date("Y-m-d");
        $anunciosDestaque = array();
        $filtroDest = '';
        switch($codDestaque)
        {
            case 3:
            {
                /** DESTAQUE - OUTROS **/
                $filtroDest = 'AND ca.tipoVeiculo != 1 AND ca.tipoVeiculo != 2';
                /** DESTAQUE - OUTROS **/
                break;
            }
            case 2:
            {
                /** DESTAQUE - MOTO **/
                $filtroDest = 'AND ca.tipoVeiculo = 2';
                /** DESTAQUE - MOTO **/
                break;
            }
            case 1:
            default:
            {
                /** DESTAQUE - CARROS **/
                $filtroDest = 'AND ca.tipoVeiculo = 1';
                /** DESTAQUE - CARROS **/
                break;
            }
        }
        $conexao = conexao();
        $qDestPart = mysql_query("SELECT ca.cod, ca.cor, ca.combustivel, c.estado, c.cidade, ca.km, ca.anoFabricacao, c.cleanTitulo, ca.valor, vm.marca, vv.versao, vmd.modelo,
                                (SELECT a.arquivo FROM arquivos AS a WHERE a.codReferencia = ca.cod
                                AND a.referencia = 'clientesAnuncios' AND a.tipo = 1 ORDER BY a.capa DESC LIMIT 1) AS arquivo
                                FROM clientesAnuncios AS ca
                                INNER JOIN clientes AS c ON c.cod = ca.codCliente
                                INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
                                INNER JOIN veiculosModelos AS vmd ON vmd.cod = ca.modelo
                                LEFT JOIN veiculosVersoes AS vv ON vv.cod = ca.versao
                                WHERE c.tipoAnuncio = 1 AND c.situacao = 1 $filtroDest 
                                AND ca.codPlanoParticular = 3 AND ca.status = 1 AND '$dataHoje' BETWEEN ca.dataLiberacaoAnuncio AND ca.dataValidadeAnuncio");
                                //echo mysql_error();
        $nDestPart = mysql_num_rows($qDestPart);
        if($nDestPart > 0)
        {
            for($a=0;$a<$nDestPart;$a++)
            {
                $tpDestPart = mysql_fetch_assoc($qDestPart);
                $anunciosDestaque[] = array(
                                                'cod' => $tpDestPart['cod'],
                                                'cor' => $tpDestPart['cor'],
                                                'combustivel' => combustivel($tpDestPart['combustivel']),
                                                'anoFabricacao' => $tpDestPart['anoFabricacao'],
                                                'marca' => $tpDestPart['marca'],
                                                'versao' => $tpDestPart['versao'],
                                                'modelo' => $tpDestPart['modelo'],
                                                'cidade' => $tpDestPart['cidade'],
                                                'estado' => $tpDestPart['estado'],
                                                'km' => $tpDestPart['km'],
                                                'valor' => "R$ ".number_format((float)$tpDestPart['valor'],2,',','.'),
                                                'arquivo' => $tpDestPart['arquivo'], 
                                                'anunciante' => 'Particular',
                                                'cleanTitulo' => $tpDestPart['cleanTitulo'],
                                                'tipoAnuncio' => 1,
                                           );
            }
            
        }
        
        $qDestRev = mysql_query("SELECT ca.cod, ca.cor, ca.combustivel, ca.anoFabricacao, c.estado, c.cidade, ca.km, c.cleanTitulo, ca.valor, vm.marca, c.nomeFantasia, vv.versao, vmd.modelo,
                                (SELECT a.arquivo FROM arquivos AS a WHERE a.codReferencia = ca.cod
                                AND a.referencia = 'clientesAnuncios' AND a.tipo = 1 ORDER BY a.capa DESC LIMIT 1) AS arquivo
                                FROM clientesAnuncios AS ca 
                                INNER JOIN clientes AS c ON c.cod = ca.codCliente
                                INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
                                INNER JOIN veiculosModelos AS vmd ON vmd.cod = ca.modelo
                                LEFT JOIN veiculosVersoes AS vv ON vv.cod = ca.versao
                                WHERE c.tipoAnuncio = 2 AND c.situacao = 1 $filtroDest
                                AND ca.destaqueHome = '1' AND ca.superDestaqueHome = '0' AND ca.status = 1
                                ORDER BY RAND()");
                                //echo mysql_error();
        $nDestRev = mysql_num_rows($qDestRev);
        if($nDestRev > 0)
        {
            for($a=0;$a<$nDestRev;$a++)
            {
                $tpDestRev = mysql_fetch_assoc($qDestRev);
                $anunciosDestaque[] = array(
                                                'cod' => $tpDestRev['cod'],
                                                'cor' => $tpDestRev['cor'],
                                                'combustivel' => combustivel($tpDestRev['combustivel']),
                                                'anoFabricacao' => $tpDestRev['anoFabricacao'],
                                                'marca' => $tpDestRev['marca'],
                                                'versao' => $tpDestRev['versao'],
                                                'modelo' => $tpDestRev['modelo'],
                                                'cidade' => $tpDestRev['cidade'],
                                                'estado' => $tpDestRev['estado'],
                                                'km' => $tpDestRev['km'],
                                                'valor' => "R$ ".number_format((float)$tpDestRev['valor'],2,',','.'),
                                                'arquivo' => $tpDestRev['arquivo'],
                                                'anunciante' => $tpDestRev['nomeFantasia'],
                                                'cleanTitulo' => $tpDestRev['cleanTitulo'], 
                                                'tipoAnuncio' => 2,
                                           );
            }
            
        }
        mysql_close();
        shuffle($anunciosDestaque);
        $_SESSION['destaque'][$codDestaque] = $anunciosDestaque;
        $lisDestaque = array();
        if(count($anunciosDestaque) > 0)
        {
            $array = array_slice($anunciosDestaque,$primeiro_registro,$num_por_pagina);
            $nArray = count($array);
            $retorno['nItens'] = $nArray;
            if($nArray > 0)
            {
                foreach($array as $k => $anuncioDestaque)
                {
                    $urlMarcaModelo = ($anuncioDestaque['marca'] != '' ? $anuncioDestaque['marca'] : '').($anuncioDestaque['modelo'] ? ' '.$anuncioDestaque['modelo'] : '');
                    $urlMarcaModelo = mg_substituirEspacosPorTreacos($urlMarcaModelo);
                        
                    if($anuncioDestaque['tipoAnuncio'] == 1)
                    {
                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/particular/'.($anuncioDestaque['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$anuncioDestaque['cod'].($anuncioDestaque['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioDestaque['estado']) : '').($anuncioDestaque['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioDestaque['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$anuncioDestaque['cod'];
                    }
                    else
                    {
                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/revenda/'.$anuncioDestaque['cleanTitulo'].'/'.($anuncioDestaque['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$anuncioDestaque['cod'].($anuncioDestaque['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioDestaque['estado']) : '').($anuncioDestaque['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioDestaque['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$anuncioDestaque['cod'];
                    }
                    $lisDestaque[] = "
                            <div class='ofertalistamini'>
                                <div class='ofertalistaimgwrap'>
                                    <div class='ofertalistaimg'>
    									<a href='".$link."'>
    										<img src='".($anuncioDestaque['arquivo'] != '' ? ssl().PROJECT_URL.'/arquivos/clientesAnuncios/'.$anuncioDestaque['arquivo'] : ssl().PROJECT_URL.'/img/placeholderHome1.jpg')."' alt='Ofertas' width='122px' />
    									</a>
    								</div>
                                </div>
                                <div class='ofertalistatexto'>
                                    <div class='ofertalistaprecomenor'>{$anuncioDestaque['valor']}</div>
                                    <p class='ofertalistatitulo'><span>{$anuncioDestaque['marca']} {$anuncioDestaque['versao']}</span></p>
                                    <p><b>{$anuncioDestaque['anunciante']}</b></p>
                                </div>
                            </div>";
							//linha retirada a pedido do Rafael em 2013/12/06
							//<p>{$anuncioDestaque['combustivel']} | {$anuncioDestaque['cor']} | {$anuncioDestaque['anoFabricacao']}</p>
                }
                $destaque = implode("",$lisDestaque);
                $retorno['html'] = $destaque;
                
                $total_paginas = (count($anunciosDestaque)/$num_por_pagina);
                $total_paginas = ceil($total_paginas);
                $prev = ($pagina-1);
                $next = ($pagina+1);
                $painel = "";  
                if ($pagina > 1)
                {
                    $retorno['prev'] = $prev;
                }
                else 
                { 
                    $retorno['prev'] = $total_paginas > 1 ? $total_paginas : '';
                }
                
                if ($total_paginas > 1 && $pagina < $total_paginas )
                {
                    $retorno['next'] = $next;
                }
                else 
                { 
                    $retorno['next'] = $total_paginas > 1 ? 1 : '';
                }
            }
        }
        else
        {
            $retorno['html'] = "<span style='margin-top: 119px;float: left; width: 100%;'>Nenhum anúncio nesta categoria!</span>";
        }
    }
    elseif($acao == "slice")
    {
        $array = array_slice($_SESSION['destaque'][$codDestaque],$primeiro_registro,$num_por_pagina);
        $nArray = count($array);
        $retorno['nItens'] = $nArray;
        if($nArray > 0)
        {
            foreach($array as $k => $anuncioDestaque)
            {
                $urlMarcaModelo = ($anuncioDestaque['marca'] != '' ? $anuncioDestaque['marca'] : '').($anuncioDestaque['modelo'] ? ' '.$anuncioDestaque['modelo'] : '');
                $urlMarcaModelo = mg_substituirEspacosPorTreacos($urlMarcaModelo);
                if($anuncioDestaque['tipoAnuncio'] == 1)
                {
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/particular/'.($anuncioDestaque['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$anuncioDestaque['cod'].($anuncioDestaque['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioDestaque['estado']) : '').($anuncioDestaque['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioDestaque['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$anuncioDestaque['cod'];
                }
                else
                {
                    
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/revenda/'.$anuncioDestaque['cleanTitulo'].'/'.($anuncioDestaque['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$anuncioDestaque['cod'].($anuncioDestaque['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioDestaque['estado']) : '').($anuncioDestaque['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioDestaque['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$anuncioDestaque['cod'];
                }
                $lisDestaque[] = "
                        <div class='ofertalistamini'>
                            <div class='ofertalistaimgwrap'>
                                <div class='ofertalistaimg'>
									<a href='".$link."'>
										<img src='".($anuncioDestaque['arquivo'] != '' ? ssl().PROJECT_URL.'/arquivos/clientesAnuncios/'.$anuncioDestaque['arquivo'] : ssl().PROJECT_URL.'/img/placeholderHome1.jpg')."' alt='Ofertas' width='122px' />
									</a>
								</div>
                            </div>
                            <div class='ofertalistatexto'>
                                <div class='ofertalistaprecomenor'>{$anuncioDestaque['valor']}</div>
                                <p class='ofertalistatitulo'><span>{$anuncioDestaque['marca']} {$anuncioDestaque['versao']}</span></p>
                                
                                <p><b>{$anuncioDestaque['anunciante']}</b></p>
                            </div>
                        </div>";
						//linha retirada a pedido do Rafael em 2013/12/06
						//<p>{$anuncioDestaque['combustivel']} | {$anuncioDestaque['cor']} | {$anuncioDestaque['anoFabricacao']}</p>
            }
            $destaque = implode("",$lisDestaque);
            $retorno['html'] = $destaque;
            
            $total_paginas = (count($_SESSION['destaque'][$codDestaque])/$num_por_pagina);
            $total_paginas = ceil($total_paginas);
            $prev = ($pagina-1);
            $next = ($pagina+1);
            $painel = "";  
            if ($pagina > 1)
            {
                $retorno['prev'] = $prev;
            }
            else 
            { 
                $retorno['prev'] = $total_paginas > 1 ? $total_paginas : '';
            }
            
            if ($total_paginas > 1 && $pagina < $total_paginas )
            {
                $retorno['next'] = $next;
            }
            else 
            { 
                $retorno['next'] = $total_paginas > 1 ? 1 : '';
            }
        }
        
    }
    die(json_encode($retorno));
}
?>