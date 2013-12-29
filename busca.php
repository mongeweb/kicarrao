<?php require_once 'configRoot.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
    require_once PROJECT_INC_PATH.'head.php';
    require_once PROJECT_INC_PATH."publicidade.php";
    require_once ADMIN_FUNC_PATH."formatting.php";
    $gets = array();
    $get = $_GET;
    foreach($get as $kkk => $vvv)
    {
        if($kkk != 'pagina')
        {
            if($kkk == 'q')
            {
                $gets[] = "$kkk=".str_replace(" ","+",$vvv);
            }
            else
            {
                $gets[] = "$kkk=$vvv";
            }
        }
    }
    ?>
    <script type="text/javascript">
        
        function verificaNumero(e)
        {
            var tecla=(window.event)?event.keyCode:e.which;   
            if((tecla>47 && tecla<58)) return true;
            else{
            	if (tecla==8 || tecla==0) return true;
        	else  return false;
            }
        }
        $(document).ready(function(){
            $("div.buscamarca").each(function()
            {
                _marcaheight = $(this).height();
                _anoheight = $(this).siblings("div.buscaano").height();
                _kmheight = $(this).siblings("div.buscakm").height();
                _anoheight = _kmheight = _marcaheight;
                $(this).siblings("div.buscaano").css({'height':_anoheight});
                $(this).siblings("div.buscakm").css({'height':_kmheight});
            })
            
            
            $("div.buscafavorito").click(function()
            {
                _src = $(this).find("img").attr("src");
                _val = $(this).attr('rel');
                _marca = 0;
                if(_src == "<?=ssl().PROJECT_URL;?>/img/favorito.png")
                { 
                    $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/favoritohover.png");
                    _marca = 1;
                    _favAtual = $('.selecionados').find('b').text();
                    _favAtual = parseInt(_favAtual) + 1;
                    $('.selecionados').find('b').text(_favAtual);
                    $('.selecionados').show();
                }
                if(_src == "<?=ssl().PROJECT_URL;?>/img/favoritohover.png")
                {
                    $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/favorito.png");
                    _marca = 0;
                    _favAtual = $('.selecionados').find('b').text();
                    _favAtual = parseInt(_favAtual) - 1;
                    $('.selecionados').find('b').text(_favAtual);
                    if(_favAtual == 0)
                        $('.selecionados').hide();
                }
                $.ajax(
                {
                    type: "POST",
                    url: "<?=ssl().PROJECT_URL;?>/adm/ajax/ajaxCookie.php",
                    data:
                    {
                        codFavorito: _val,
                        marca: _marca
                    
                    },
                    dataType: "json", 
                    success: function(j)
                    { 
                        
                    }
                }); 
            })
            
            $(".irPagina").click(function(){
                
                _pagina = $("#digitaPagina").val();
                _totalPaginas = $('#totaDePagina').attr('rel');
                console.log(_pagina);
                console.log(_totalPaginas);
                if(_pagina != '' && _pagina != 0)
                {
                    _pagina = parseInt(_pagina) > parseInt(_totalPaginas) ? _totalPaginas : _pagina;
                    _redireciona = "<?=sslRedir().PROJECT_URL;?>/busca/?pagina="+_pagina+"<?=count($gets) > 0 ? '&'.implode('&',$gets) : '';?>";
    		        location.replace(_redireciona);
                }
            })
            
            $("div.paginaAnterior").mouseover(function(){
                $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/paginacaoesqhover.png");
                $(this).mouseout(function(){
                    $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/paginacaoesq.png");    
                })
            })
            $("div.paginaSeguinte").mouseover(function(){
                $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/paginacaodirhover.png");
                $(this).mouseout(function(){
                    $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/paginacaodir.png");    
                })
            })
        })
    </script>
</head>

<body>
<div class="mestre">
	<?php
    require_once PROJECT_INC_PATH.'topo.php';
    
    $order = isset($_GET['order']) ? $_GET['order'] : '';
    $orderSql = '';
    if($order != '')
    {
        $exOrder = explode('-',$order);
        $ordem = array_key_exists(0,$exOrder) ? $exOrder[0] : '';
        $ascDesc = array_key_exists(1,$exOrder) ? $exOrder[1] : '';
        
        switch($ordem)
        {
            case 'marca' :
                $orderSql .= ' ORDER BY vm.marca ';
                break;
            case 'ano' :
                $orderSql .= ' ORDER BY ca.anoFabricacao ';
                break;
            case 'km' :
                $orderSql .= ' ORDER BY ca.km ';
                break;
            case 'preco' :
                $orderSql .= ' ORDER BY ca.valor ';
                break;
        }
        if($ascDesc == 'asc')
        {
            $orderSql .= ' ASC';
            $seta = 'setabuscacima';
        }
        elseif($ascDesc == 'desc')
        {
            $orderSql .= ' DESC';
            $seta = 'setabuscabaixo';
        }
    }
    else
    {
         $ordem = '';
         $ascDesc = '';
    }
    
    $num_por_pagina = 30; 
	$pagina = isset($pagina) ? $pagina : '';
	$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : $pagina;
    if(empty($pagina))
	{
		$primeiro_registro = 0;
		$pagina = 1;
	}
	else
	{
		$primeiro_registro = ($pagina-1)*$num_por_pagina;
	}
    
    $anuncios = array();
    $anunciosAux = array();
    $anunciosSlice = array();
    
    $dataHoje = date("Y-m-d");
    $filtros = array();
    $filtros[] = "c.situacao = 1";
    $filtros[] = "ca.status = 1";
    if(!empty($codigoTopo))
    {
        $filtros[] = "ca.cod = '$codigoTopo'";
    }
    else
    {
        if(!empty($filtroBuscaTopo))
        {
            if($filtroBuscaTopo == 1 || $filtroBuscaTopo == 2)
            {
                $filtros[] = "c.tipoAnuncio = '$filtroBuscaTopo'";
            
                if($filtroBuscaTopo == 1)
                {
                    //$filtros[] = "ca.dataValidadeAnuncio >= '$dataHoje'";
                    $filtros[] = "'$dataHoje' BETWEEN ca.dataLiberacaoAnuncio AND ca.dataValidadeAnuncio";
                }
            }
        }
        if(!empty($tipoTopo))
        {
            $filtros[] = "ca.tipoVeiculo = '$tipoTopo'";
        }
        if(!empty($marcaTopo))
        {
            $filtros[] = "ca.marca = '$marcaTopo'";
        }
        if(!empty($modeloTopo))
        {
            $filtros[] = "ca.modelo = '$modeloTopo'";
        }
        if(!empty($versaoTopo))
        {
            $filtros[] = "ca.versao = '$versaoTopo'";
        }
        if(!empty($kmTopo))
        {
            $filtros[] = "ca.km <= '$kmTopo'";
        }
        if(!empty($combustivelTopo))
        {
            $filtros[] = "ca.combustivel = '$combustivelTopo'";
        }
        if(!empty($portasTopo))
        {
            $filtros[] = "ca.nPortas = '$portasTopo'";
        }
        if(!empty($corTopo))
        {
            $filtros[] = "ca.cor = '$corTopo'";
        }
        if(!empty($estadoTopo))
        {
            $filtros[] = "c.estado = '$estadoTopo'";
        }
        if(!empty($cidadeTopo))
        {
            $filtros[] = "c.cidade = '$cidadeTopo'";
        }
        if(!empty($anoInicialTopo))
        {
            $filtros[] = "ca.anoFabricacao BETWEEN '$anoInicialTopo' AND '$anoFinalTopo'";
        }
        if(!empty($precoInicialTopo))
        {
            $filtros[] = "ca.valor >= '$precoInicialTopo'";
        }
        if(!empty($precoFinalTopo))
        {
            $filtros[] = "ca.valor <= '$precoFinalTopo'";
        }
        if(!empty($placaTopo))
        {
            $filtros[] = "ca.placa LIKE '%$placaTopo%'";
        }
        ## Campo Busca Topo
        if(!empty($qTopo))
        {
            $qExplode = explode(" ",$qTopo);
            if(count($qExplode) > 0)
            {
                $filtrosTextoBuscaCor = array();
                $filtrosTextoBuscaMarca = array();
                $filtrosTextoBuscaModelo = array();
                $filtrosTextoBuscaVersao = array();
                $filtrosTextoBuscaAnoModelo = '';
                $filtrosTextoBuscaCidade = array();
                $filtrosTextoBuscaEstado = array();
                $valor = array();
                $guardaTabelasBusca = array();
                $arrayCores = array('amarelo', 'amarela', 'azul', 'bege', 'branco', 'branca', 'bronze', 'cinza', 'dourado', 'dourada', 'indefinida', 'laranja', 'marrom', 'prata', 'preto', 'preta', 'rosa', 'roxo', 'roxa', 'verde', 'vermelho', 'vermelha', 'vinho');
                
                ## Verifica quais colunas estão sendo buscadas (Marca, Versão e Cor)
                $conexao = conexao();
                foreach($qExplode as $pos => $val)
                {
                    if(in_array(strtolower($val),$arrayCores))
                    {
                        $guardaTabelasBusca[] = 'cor';
                        if(strtolower($val) == 'amarelo' || strtolower($val) == 'amarela')
                        {
                            $filtrosTextoBuscaCor[] = " ca.cor LIKE '%amarelo%' ";
                            $filtrosTextoBuscaCor[] = " ca.cor LIKE '%amarela%' ";
                        }
                        elseif(strtolower($val) == 'branco' || strtolower($val) == 'branca')
                        {
                            $filtrosTextoBuscaCor[] = " ca.cor LIKE '%branco%' ";
                            $filtrosTextoBuscaCor[] = " ca.cor LIKE '%branca%' ";
                        }
                        elseif(strtolower($val) == 'dourado' || strtolower($val) == 'dourada')
                        {
                            $filtrosTextoBuscaCor[] = " ca.cor LIKE '%dourado%' ";
                            $filtrosTextoBuscaCor[] = " ca.cor LIKE '%dourada%' ";
                        }
                        elseif(strtolower($val) == 'preto' || strtolower($val) == 'preta')
                        {
                            $filtrosTextoBuscaCor[] = " ca.cor LIKE '%preto%' ";
                            $filtrosTextoBuscaCor[] = " ca.cor LIKE '%preta%' ";
                        }
                        elseif(strtolower($val) == 'roxo' || strtolower($val) == 'roxa')
                        {
                            $filtrosTextoBuscaCor[] = " ca.cor LIKE '%roxo%' ";
                            $filtrosTextoBuscaCor[] = " ca.cor LIKE '%roxa%' ";
                        }
                        elseif(strtolower($val) == 'vermelho' || strtolower($val) == 'vermelha')
                        {
                            $filtrosTextoBuscaCor[] = " ca.cor LIKE '%vermelho%' ";
                            $filtrosTextoBuscaCor[] = " ca.cor LIKE '%vermelha%' ";
                        }
                        else
                        {
                            $filtrosTextoBuscaCor[] = " ca.cor LIKE '%$val%' ";
                        }
                    }
                    else
                    {
                        $sqlBuscaAnoModelo = mysql_query("SELECT anoModelo FROM clientesAnuncios WHERE anoModelo = '$val'");
                        $numBuscaAnoModelo = mysql_num_rows($sqlBuscaAnoModelo);
                        if($numBuscaAnoModelo > 0)
                        {
                            $guardaTabelasBusca[] = 'anoModelo';
                            $filtrosTextoBuscaAnoModelo = " ca.anoModelo = '$val' ";
                        }
                        else
                        {
                            $sqlBuscaEstado = mysql_query("SELECT estado FROM clientes WHERE estado LIKE '%$val%'");
                            $numBuscaEstado = mysql_num_rows($sqlBuscaEstado);
                            if($numBuscaEstado > 0)
                            {
                                $guardaTabelasBusca[] = 'estado';
                                $filtrosTextoBuscaEstado[] = " c.estado LIKE '%$val%' ";
                            }
                            else
                            {
                                
                                $sqlBuscaModelo = mysql_query("SELECT modelo FROM veiculosModelos WHERE modelo LIKE '%$val%'");
                                $numBuscaModelo = mysql_num_rows($sqlBuscaModelo);
                                if($numBuscaModelo > 0)
                                {
                                    $guardaTabelasBusca[] = 'modelo';
                                    $filtrosTextoBuscaModelo[] = " vmd.modelo LIKE '%$val%' ";
                                }
                                else
                                { 
                                    $sqlBuscaVersao = mysql_query("SELECT versao FROM veiculosVersoes WHERE versao LIKE '%$val%'");
                                    $numBuscaVersao = mysql_num_rows($sqlBuscaVersao);
                                    if($numBuscaVersao > 0)
                                    {
                                        $guardaTabelasBusca[] = 'versao';
                                        $filtrosTextoBuscaVersao[] = " vv.versao LIKE '%$val%' ";
                                    }
                                    else
                                    {
                                        $sqlBuscaMarca = mysql_query("SELECT marca FROM veiculosMarcas WHERE marca LIKE '%$val%'");
                                        $numBuscaMarca = mysql_num_rows($sqlBuscaMarca);
                                        if($numBuscaMarca > 0)
                                        {
                                            $guardaTabelasBusca[] = 'marca';
                                            $filtrosTextoBuscaMarca[] = " vm.marca LIKE '%$val%' ";
                                        }
                                        else
                                        {
                                            $sqlBuscaCidade = mysql_query("SELECT cidade FROM clientes WHERE cidade LIKE '%$val%'");
                                            $numBuscaCidade = mysql_num_rows($sqlBuscaCidade);
                                            if($numBuscaCidade > 0)
                                            {
                                                $guardaTabelasBusca[] = 'cidade';
                                                $filtrosTextoBuscaCidade[] = " c.cidade LIKE '%$val%' ";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                mysql_close();
                if(in_array('cor',$guardaTabelasBusca))
                    $filtros[] = " ( ".implode(" OR ",$filtrosTextoBuscaCor)." ) ";
                if(in_array('marca',$guardaTabelasBusca))
                    $filtros[] = " ( ".implode(" AND ",$filtrosTextoBuscaMarca)." ) ";
                if(in_array('modelo',$guardaTabelasBusca))
                    $filtros[] = " ( ".implode(" AND ",$filtrosTextoBuscaModelo)." ) ";
                if(in_array('versao',$guardaTabelasBusca))
                    $filtros[] = " ( ".implode(" AND ",$filtrosTextoBuscaVersao)." ) ";
                if(in_array('estado',$guardaTabelasBusca))
                    $filtros[] = " ( ".implode(" AND ",$filtrosTextoBuscaEstado)." ) ";
                if(in_array('cidade',$guardaTabelasBusca))
                    $filtros[] = " ( ".implode(" AND ",$filtrosTextoBuscaCidade)." ) ";
                if(in_array('anoModelo',$guardaTabelasBusca))
                    $filtros[] = $filtrosTextoBuscaAnoModelo;
            }
        }
        
        ## Fim Campo Busca Topo
    }
    if($pagina <= 1)
    {
        $conexao = conexao();
        $sql = "SELECT c.nomeFantasia, c.razaoSocialNome, c.cidade, c.estado, c.cleanTitulo, ca.cod, ca.cor, ca.combustivel, ca.anoFabricacao, ca.anoModelo, vm.marca, vmd.modelo, vv.versao,
                ca.valor, ca.codPlanoParticular, ca.km, ca.superDestaqueLista, ca.destaqueLista, c.tipoAnuncio, ca.dataLiberacaoAnuncio, ca.dataValidadeAnuncio,
                (SELECT a.arquivo FROM arquivos AS a WHERE a.codReferencia = ca.cod 
                AND a.referencia = 'clientesAnuncios' AND a.tipo = 1 ORDER BY a.capa DESC LIMIT 1) AS arquivo
                FROM clientesAnuncios AS ca
                INNER JOIN clientes AS c ON c.cod = ca.codCliente
                INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
                LEFT JOIN veiculosModelos AS vmd ON vmd.cod = ca.modelo
                LEFT JOIN veiculosVersoes AS vv ON vv.cod = ca.versao
                WHERE ".implode(" AND ",$filtros).($orderSql != '' ? $orderSql : ' ORDER BY RAND()')."";
        $query = mysql_query($sql);        
        //echo $sql;
        $n = mysql_num_rows($query);
        //echo $sql."<br />".$n;
        
        while($tp = mysql_fetch_assoc($query))
        {
            if(($apenasFotoTopo == 1 && $tp['arquivo'] != '') || $apenasFotoTopo != 1)
            {
                if($filtroBuscaTopo == 2)
                {
                    if($tp['superDestaqueLista'] == 1 && $tp['destaqueLista'] == 0)
                    {
                        $key = 1;
                    }
                    else if($tp['superDestaqueLista'] == 0 && $tp['destaqueLista'] == 1)
                    {
                        $key = 2;
                    }
                    else
                    {
                        $key = 3;   
                    }
                }
                elseif($filtroBuscaTopo == 1)
                {
                    if($tp['codPlanoParticular'] == 4)
                    {
                        $key = 1;
                    }
                    else if($tp['codPlanoParticular'] == 3)
                    {
                        $key = 2;
                    }
                    else if($tp['codPlanoParticular'] == 2)
                    {
                        $key = 3;
                    }
                    else
                    {
                        $key = 4;   
                    }
                }
                else
                {
                    if(($tp['superDestaqueLista'] == 1 && $tp['destaqueLista'] == 0) || $tp['codPlanoParticular'] == 4)
                    {
                        $key = 1;
                    }
                    else if(($tp['superDestaqueLista'] == 0 && $tp['destaqueLista'] == 1) || $tp['codPlanoParticular'] == 3)
                    {
                        $key = 2;
                    }
                    else
                    {
                        $key = 3;   
                    }
                }
                if($orderSql == '')
                {
                    $anunciosAux[$key][] = array(
                                            'cod' => $tp['cod'],
                                            'nomeFantasia' => $tp['nomeFantasia'],
                                            'tipoAnuncio' => $tp['tipoAnuncio'],
                                            'dataLiberacaoAnuncio' => $tp['dataLiberacaoAnuncio'],
                                            'dataValidadeAnuncio' => $tp['dataValidadeAnuncio'],
                                            'razaoSocialNome' => $tp['razaoSocialNome'],
                                            'cleanTitulo' => $tp['cleanTitulo'],
                                            'cor' => $tp['cor'],
                                            'combustivel' => $tp['combustivel'],
                                            'anoFabricacao' => $tp['anoFabricacao'],
                                            'anoModelo' => $tp['anoModelo'],
                                            'marca' => $tp['marca'],
                                            'modelo' => $tp['modelo'],
                                            'versao' => $tp['versao'],
                                            'estado' => $tp['estado'],
                                            'cidade' => $tp['cidade'],
                                            'km' => $tp['km'],
                                            'valor' => "R$ ".number_format((float)$tp['valor'],2,',','.'),
                                            'arquivo' => $tp['arquivo'],
                                            'ordem' => $key,
                                          );
                }
                else
                {
                    $anunciosAux[0][] = array(
                                            'cod' => $tp['cod'],
                                            'nomeFantasia' => $tp['nomeFantasia'],
                                            'tipoAnuncio' => $tp['tipoAnuncio'],
                                            'dataLiberacaoAnuncio' => $tp['dataLiberacaoAnuncio'],
                                            'dataValidadeAnuncio' => $tp['dataValidadeAnuncio'],
                                            'razaoSocialNome' => $tp['razaoSocialNome'],
                                            'cleanTitulo' => $tp['cleanTitulo'],
                                            'cor' => $tp['cor'],
                                            'combustivel' => $tp['combustivel'],
                                            'anoFabricacao' => $tp['anoFabricacao'],
                                            'anoModelo' => $tp['anoModelo'],
                                            'marca' => $tp['marca'],
                                            'modelo' => $tp['modelo'],
                                            'versao' => $tp['versao'],
                                            'estado' => $tp['estado'],
                                            'cidade' => $tp['cidade'],
                                            'km' => $tp['km'],
                                            'valor' => "R$ ".number_format((float)$tp['valor'],2,',','.'),
                                            'arquivo' => $tp['arquivo'],
                                            'ordem' => $key,
                                          );
                }
            }
        }
        mysql_close();
        ksort($anunciosAux);
        foreach($anunciosAux as $k =>$v)
        {
            foreach($v as $kk =>$vv)
            {
                if($vv['tipoAnuncio'] == 1)
                {
                    if($dataHoje >= $vv['dataLiberacaoAnuncio'] && $dataHoje < $vv['dataValidadeAnuncio'])
                    {
                        $anunciosSlice[] = $vv;
                    }
                }
                else
                {
                    $anunciosSlice[] = $vv;
                }
            }
        }
        unset($anunciosAux);
        $_SESSION['busca'] = $anunciosSlice;
    }
    else
    {
        $anunciosSlice = $_SESSION['busca'];
    }
    $anuncios = array_slice($anunciosSlice,$primeiro_registro,$num_por_pagina);
    $nTotal = count($anunciosSlice);
    unset($anunciosSlice);
    
    
    require_once PROJECT_INC_PATH.'menu.php';
    ?>
    <div class="ofertabloco">
        <div class="centroinside">
            <div class="breadcrumb">
                <?
                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
                ?>
                <a href="<?=$link;?>">Home</a>&nbsp; &gt; &nbsp;<span>Anúncios</span>&nbsp; &gt; &nbsp;<span><?=$filtroBuscaTopo == '1' ? 'Particulares' : 'Revendas';?></span>
            </div>
        </div>
    </div>
    <div class="centro">
    	<div class="centroinside">
            <div class="noticiablocogeral">
                <div class="buscalista">
                    <?php require_once PROJECT_INC_PATH.'buscatopo.php'; ?>
                    <div class="bannerbusca">
                        <?php
                        imprimeBannerSuperAnunciosLista($filtroBuscaTopo);
                        ?>
                    </div>
                    <!--<div class="revendabuscaitem">
                        <div class="revendabuscaimg">
                            <a href="#"><img src="http://< ?=PROJECT_URL;?>/img/vando.jpg" alt="Vando Automóveis" /></a>
                        </div>
                        <div class="revendabuscatexto">
                            <p class="revendaitemtitulo">Vando Automóveis</p>
                            <p class="revendaendereco">
                                Endereço:<br /> 
                                Rua Venâncio Aires, 3355 - Canoas / RS
                            </p>
                            <p class="revendafone">
                                Fones:<br />
                                (51) 9299-9004 | 3059-7090
                            </p>
                        </div>
                    </div>-->
                    <div class="tabelabusca" id="ancora">
                        <div class="buscaheader">
                            <div class="buscaheaderfavorito">
                                Favoritos
                            </div>
                            <div class="buscaheaderfoto">&nbsp;</div>
                            <div class="buscaheadermarca order <?=$ordem == 'marca' ? 'vermelho' : '';?>" rel="marca-<?=$ascDesc == 'asc' ? 'desc' : 'asc';?>">
                                Marca/Modelo 
                                <a class="setafiltro"><img src="<?=sslRedir().PROJECT_URL;?>/img/<?=$ordem == 'marca' ? $seta.'hover' : 'setabuscabaixo';?>.png" /></a>
                            </div>
                            <div class="buscaheaderano order <?=$ordem == 'ano' ? 'vermelho' : '';?>" rel="ano-<?=$ascDesc == 'asc' ? 'desc' : 'asc';?>">
                                Ano
                                <a class="setafiltro"><img src="<?=sslRedir().PROJECT_URL;?>/img/<?=$ordem == 'ano' ? $seta.'hover' : 'setabuscabaixo';?>.png" /></a>
                            </div>
                            <div class="buscaheaderkm order <?=$ordem == 'km' ? 'vermelho' : '';?>" rel="km-<?=$ascDesc == 'asc' ? 'desc' : 'asc';?>">
                                Km
                                <a class="setafiltro"><img src="<?=sslRedir().PROJECT_URL;?>/img/<?=$ordem == 'km' ? $seta.'hover' : 'setabuscabaixo';?>.png" /></a>
                            </div>
                            <div class="buscaheaderpreco order <?=$ordem == 'preco' ? 'vermelho' : '';?>" rel="preco-<?=$ascDesc == 'asc' ? 'desc' : 'asc';?>">
                                Preço
                                <a class="setafiltro"><img src="<?=sslRedir().PROJECT_URL;?>/img/<?=$ordem == 'preco' ? $seta.'hover' : 'setabuscabaixo';?>.png" /></a>
                            </div>
                        </div>
                        <?php
                        if(count($anuncios) > 0)
                        {
                            foreach($anuncios as $k => $v)
                            {
                            
                        ?>
                                <div class="buscacoluna <?=$v['ordem']==1 || $v['ordem']==2 ? "buscacolunadestaque" : '';?>">
                                    <?=$v['ordem'] == 1 ? "<div class='destaquerotulo'>&nbsp;</div>" : '';?>
                                    <?
                                    $urlMarcaModelo = ($v['marca'] != '' ? $v['marca'] : '').($v['modelo'] ? ' '.$v['modelo'] : '');
                                    $urlMarcaModelo = mg_substituirEspacosPorTreacos($urlMarcaModelo);
                                    if($v['tipoAnuncio'] == 1)
                                    {
                                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/particular/'.($v['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$v['cod'].($v['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($v['estado']) : '').($v['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($v['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$v['cod'];
                                    }
                                    else
                                    {
                                        
                                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/revenda/'.$v['cleanTitulo'].'/'.($v['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$v['cod'].($v['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($v['estado']) : '').($v['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($v['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$v['cod'];
                                    }
                                    $favoritoImg = 'favorito';
                                    if(isset($_COOKIE['favoritos']) && $_COOKIE['favoritos'] != '')
                                    {
                                        $cookirFav = unserialize($_COOKIE['favoritos']);
                                        if(in_array($v['cod'],$cookirFav))
                                        {
                                            $favoritoImg = 'favoritohover';
                                        }
                                    }
                                    ?>  
                                    <div class="buscafavorito" rel="<?=$v['cod'];?>"><a><img src="<?=sslRedir().PROJECT_URL;?>/img/<?=$favoritoImg;?>.png" alt="Favorito" /></a></div>
                                    <div class="buscafoto">
                                        <a href="<?=$link;?>">
                                            <img style="width: 116px;" src="<?=$v['arquivo'] != '' ? ssl().PROJECT_URL.'/arquivos/clientesAnuncios/'.$v['arquivo'] : ssl().PROJECT_URL.'/img/placeholderRevendas.jpg';?>" alt="Carro" />
                                        </a>
                                    </div>
                                    <div class="buscamarca">
                                        <a href="<?=$link;?>">
                                            <?=$v['marca'] != '' ? $v['marca']."<br />" : '';?>  
                                            <?=$v['modelo'] != '' ? $v['modelo']."<br />" : '';?>
                                            <?=$v['versao'] != '' ? $v['versao']."<br />" : '';?>
                                            <?=$v['cor'] != '' ? "Cor: ".$v['cor']."<br />" : '';?>
                                        </a>
                                    </div>
                                    <div class="buscaano">
                                        <a href="<?=$link;?>">
                                            <?=$v['anoFabricacao'].($v['anoModelo'] != '' ? "/".$v['anoModelo'] : '');?>
                                        </a>
                                    </div>
                                    <div class="buscakm">
                                        <a href="<?=$link;?>">
                                            <?=($v['km'] == '1' || $v['km'] == '0') ? " - " : $v['km'] ." km";?>
                                        </a>
                                    </div>
                                    <div class="buscapreco">
                                        <a href="<?=$link;?>">
                                            <?=$v['valor'];?>
                                        </a>
                                    </div>
                                </div>
                        <?php                           
                            }
                        }else{
                        ?>
                            <p class="nenhumacoluna">Nenhum anúncio encontrado!</p>
                        <?
                        }
                        ?>
                        
                    </div>
                </div>
                <div class="noticiapropaganda">
                    <?php
                    imprimeBannerLateralAnunciosLista($filtroBuscaTopo);
                    imprimeBannerLateralPequenoAnunciosLista($filtroBuscaTopo);
                    ?>
                </div>
                <?php
                $total_paginas = ($nTotal/$num_por_pagina);
                $total_paginas = ceil($total_paginas);
                $prev = ($pagina-1);
                $next = ($pagina+1);
                
                $painel = "";
                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/busca/' : sslRedir().PROJECT_URL.'/busca.php';
                
                
                //echo count($gets);
                if ($pagina > 1)
                {
                    $prev_link = "<a href='$link?pagina=$prev".((count($gets)>0) ? "&".implode("&",$gets) : '')."'><img src='http://".PROJECT_URL."/img/paginacaoesq.png' alt='Anterior' /></a>";
                }
                else 
                { 
                    $prev_link = "";
                }
                if ($total_paginas > 1 && $pagina < $total_paginas )
                {
                    $next_link = "<a href='$link?pagina=$next".((count($gets)>0) ? "&".implode("&",$gets) : '')."'><img src='http://".PROJECT_URL."/img/paginacaodir.png' alt='Seguinte' /></a>";
                }
                else
                { 
                    $next_link = "";
                }
                if ($total_paginas > 1) 
                {
                    $maxPags = 5;
                    $numeroDePaginas = $total_paginas;
                    if (($maxPags != 0) && ($total_paginas > $maxPags)) 
                    {
                        $paginas = array();
            
                        /** vaiaveis de controle **/
                        $metade = floor($maxPags / 2);
                        $metadeFim = ($maxPags % 2 == 0) ? 1 : 0;
            
                        /** Define inicio e fim das paginas **/
                        $ini = 1;
                        $fim = $numeroDePaginas;
                        while ($numeroDePaginas > $maxPags) 
                        {
                            /** Testa se inicio é menor que 0
                             * se for incrementa
                             **/
                            if (($pagina - $metade) > $ini) 
                            {
                                $ini++;
                                $numeroDePaginas--;
                            }
                            /** Testa se fim é menor que o total de páginas
                             * se for decrementa
                             **/
                            if (($pagina + $metade - $metadeFim) < $fim) 
                            {
                                $fim--;
                                $numeroDePaginas--;
                            }
                        }
            
                        /** Preenche o array com as páginas. **/
                        for ($ini; $ini <= $fim; $ini++) 
                        {
                            $paginas[] = $ini;
                        }
                    
                        for ($x=0; $x < count($paginas); $x++)
                        {
                            if ($pagina==$paginas[$x])
                            {
                                $painel .= "<div class='pagina paginahover'><a href='#'>&nbsp;$paginas[$x]&nbsp;</a></div>";
                            }
                            else
                            {
                                $painel .= "<div class='pagina'><a href='$link?pagina=$paginas[$x]".((count($gets)>0) ? "&".implode("&",$gets) : '')."'>&nbsp;$paginas[$x]&nbsp;</a></div>";
                            }
                            //echo $painel;
                        }
                    }
                    else
                    {                     
                        for ($x=1; $x<=$total_paginas; $x++)
                        {
                            if ($x==$pagina)
                            {
                                $painel .= "<div class='pagina paginahover'><a href='#'>&nbsp;$x&nbsp;</a></div>";
                            }
                            else
                            {
                                $painel .= "<div class='pagina'><a href='$link?pagina=$x".((count($gets)>0) ? "&".implode("&",$gets) : '')."'>&nbsp;$x&nbsp;</a></div>";
                            }
                        }
                    }
    	            ?>
                    <div class="paginacaowrap">
                        <div class="paginacaobloco">
                            <!--<div class="paginanavbloco">
                                <div id="totaDePagina" rel="<?=$total_paginas;?>">
                                    Você está na página <span><?=$pagina;?></span> de <span><?=$total_paginas;?></span>
                                </div>
                                <div>
                                    Ir para página: 
                                    <input onkeypress="return verificaNumero (event)" name="pagina" id="digitaPagina" title="Página" />
                                    <a class="irPagina" >Ir</a>
                                </div>
                            </div>-->
                            <div class="buscapaginacao">
                                <div class="pagina paginaAnterior"><?=$prev_link;?></div>
                                <?=$painel;?>
                                <div class="pagina paginaSeguinte"><?=$next_link;?></div>
                            </div>
                        </div>
                    </div>
  		        <?
                }
                ?>
            </div>
    	</div>
    </div>
    <?php require_once PROJECT_INC_PATH.'rodapebloco.php';?>
</div>
</body>
</html>