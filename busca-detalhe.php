<?php require_once 'configRoot.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html prefix="og: http://ogp.me/ns#" lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
    require_once PROJECT_INC_PATH.'head-busca-detalhe.php';
    require_once PROJECT_INC_PATH."publicidade.php";
    require_once ADMIN_FUNC_PATH."formatting.php";
    ?>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/jcarousellite.js"></script>
    <link rel="stylesheet" href="<?=ssl().PROJECT_URL;?>/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
    <script type="text/javascript">
    $(document).ready(function(){
        $("a[rel=galeria]").fancybox({
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'titlePosition' 	: 'over',
			'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
				/*return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';*/
			}
		})
        
        $("div.detalhesetaesq").mouseover(function(){
            $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/setaesqdetalhehover.png");
            $(this).mouseout(function(){
                $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/setaesqdetalhe.png");
            })
        })
        $("div.detalhesetadir").mouseover(function(){
            $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/setadirdetalhehover.png");
            $(this).mouseout(function(){
                $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/setadirdetalhe.png");
            })
        })
        
        $("div.favoritoDoDetalhe").click(function()
            {
                _src = $(this).find("img").attr("src");
                _val = $(this).attr('rel');
                _marca = 0;
                if(_src == "<?=ssl().PROJECT_URL;?>/img/iconeFavoritos.png")
                { 
                    $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/iconeFavoritos-hover.png");
                    $(this).find("span").html("Remover<br /> dos Favoritos");
                    _marca = 1;
                    _favAtual = $('.selecionados').find('b').text();
                    _favAtual = parseInt(_favAtual) + 1;
                    $('.selecionados').find('b').text(_favAtual);
                    $('.selecionados').show();
                }
                if(_src == "<?=ssl().PROJECT_URL;?>/img/iconeFavoritos-hover.png")
                {
                    $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/iconeFavoritos.png");
                    $(this).find("span").html("Adicionar<br /> aos Favoritos");
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
        
        //$(".detalhesetaesq img").hide();
        _visible = 3;
        if($(".detalheminicarro li").length > 3)
        {
        	$(".detalheminicarrowrap").jCarouselLite({
        		speed: 500,
        		circular : false,
                btnPrev : ".detalhesetaesq img",
			    btnNext : ".detalhesetadir img",
        		visible: _visible,
                vertical : false,
        		auto: false,
                beforeStart:function(_obj,_els)
				{
				    $(".detalhesetaesq img").show();
				}
        	});
        	$("div.detalhesetadir img").show();
            //$("div.setaup img").show();
        }
        
        if($("#detalheOfertas li").length > 1)
        {
            _indexSup = 0;
        	_arr = new Array;
        	$("#detalheOfertas li").each(function(){
        		_indexSup++;
        		_arr.push("#elipOferta"+_indexSup);
        	})
            $("#detalheOfertas").jCarouselLite({
            		btnPrev: ".ofertasPrev",
                    btnNext: ".ofertasNext",
                    btnGo:_arr,
                    speed: 500,
            		circular : true,
            		visible: 1,
                    boxElipse: 'div.controleOfertas',
            		auto: 20000
            	});
             $("div.controleOfertas").show();
        }
        
        $("div.garantiabotao").click(function(){
            $("div.sobreposto").show();
            $(this).parent().parent().find("div.garantiamodalbloco").show();
        })
        
        $("div.garantiamodalfechar").click(function(){
            $("div.sobreposto").hide();
            $(this).parent("div.garantiamodalbloco").hide();
        })
        
        $("div#enviarAmigo").click(function(){
            $("div.popupEnviarAmigo").css({'visibility':'visible'});
        })
        $("div.fecharEnviarAmigo").click(function(){
            $("div.popupEnviarAmigo").css({'visibility':'hidden'});
        })
    });    
    </script>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/validador1.4.js"></script>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/jquery.maskedinput.js"></script>
    <?
    require_once PROJECT_FUNC_PATH.'enviarEmail.php';
    $cod = isset($cod) ? $cod : '';
    $cod = isset($_GET['cod']) ? $_GET['cod'] : $cod;
    $dataHoje = date("Y-m-d");
    $filtroSqlNomeRevenda = isset($nomeRevUrl) && $nomeRevUrl != '' ? " AND c.cleanTitulo='".$nomeRevUrl."' " : '';
    $conexao = conexao();
    $sqlAnuncio = mysql_query("SELECT ca.cod, c.cod as codCliente, ca.codPlanoParticular, c.codPlanoRevenda, ca.km, ca.cor, ca.combustivel, ca.versao, ca.anoFabricacao, ca.dataLiberacaoAnuncio,
                                ca.anoModelo, vm.marca, vmd.modelo, ca.valor, ca.valorParcela, ca.nPortas, ca.nParcelas, ca.valorEntrada, ca.caractVeiculo, ca.dataValidadeAnuncio,
                                c.email, ca.placa, c.razaoSocialNome, c.sobrenome, c.nomeFantasia, c.cleanTitulo, c.telRes, c.telCel, c.endereco, c.numero, c.cidade, c.bairro, c.estado, c.tipoAnuncio, c.responsavel, c.site,
                                ca.marca as codMarca, ca.modelo as codModelo
                                FROM clientesAnuncios AS ca
                                INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
                                INNER JOIN veiculosModelos AS vmd ON vmd.cod = ca.modelo 
                                INNER JOIN clientes AS c ON c.cod = ca.codCliente
                                WHERE ca.cod = '$cod' $filtroSqlNomeRevenda AND ca.status = 1 AND c.situacao = 1");
    $numAnuncio = mysql_num_rows($sqlAnuncio);
    if($numAnuncio < 1)
    {
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
        echo "<script type='text/javascript'>
               document.location.replace('".$link."');
			 </script> \n";
             die();
    }
    $tpAnuncio = mysql_fetch_assoc($sqlAnuncio);
    $urlMarcaModelo = ($tpAnuncio['marca'] != '' ? $tpAnuncio['marca'] : '').($tpAnuncio['modelo'] ? ' '.$tpAnuncio['modelo'] : '');
    $urlMarcaModelo = mg_substituirEspacosPorTreacos($urlMarcaModelo);
    if($tpAnuncio['tipoAnuncio'] == 1)
    {
        $linkCurtir = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/particular/'.($tpAnuncio['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$tpAnuncio['cod'].($tpAnuncio['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpAnuncio['estado']) : '').($tpAnuncio['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpAnuncio['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$tpAnuncio['cod'];
    }
    else
    {
        
        $linkCurtir = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/revenda/'.$tpAnuncio['cleanTitulo'].'/'.($tpAnuncio['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$tpAnuncio['cod'].($tpAnuncio['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpAnuncio['estado']) : '').($tpAnuncio['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpAnuncio['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$tpAnuncio['cod'];
    }
    ?>
    <meta property="og:type" content="website" />
    <meta property="og:updated_time" content="<?=time();?>" />
    <meta content='Venda de <?php  $uri[3] = strtr($uri[3], "-", " "); $uri[3] = ucwords($uri[3]); echo $uri[3]; ?> <?php  $uri[4] = strtr($uri[4], "-", " "); $uri[4] = ucwords($uri[4]);  echo $uri[4]; ?> ' property='og:title' />
    <meta content='Kicarrao' property='og:site_name' />
    <meta content='<?=$linkCurtir;?>' property='og:url' />
    <?
    $conexao = conexao();
    $sqlFotosAnuncioCapaPGoogle = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$cod' AND tipo = '1' AND referencia = 'clientesAnuncios' AND capa = '1'");
    $numFotosAnuncioCapaPGoogle = mysql_num_rows($sqlFotosAnuncioCapaPGoogle);
    if($numFotosAnuncioCapaPGoogle > 0)
    {
        $tpFotosAnuncioCapaPGoogle = mysql_fetch_assoc($sqlFotosAnuncioCapaPGoogle);
    ?>
        <meta content='<?=ssl();?>www.kicarrao.com.br/arquivos/clientesAnuncios/<?=$tpFotosAnuncioCapaPGoogle['arquivo'];?>' property='og:image' />
    <?
    }
    else
    {
    ?>
        <meta content='<?=ssl();?>www.kicarrao.com.br/img/logo.png' property='og:image' />
    <?
    }
    ?>
    <meta content='Venda de <?php  $uri[3] = strtr($uri[3], "-", " "); $uri[3] = ucwords($uri[3]); echo $uri[3]; ?> <?php  $uri[4] = strtr($uri[4], "-", " "); $uri[4] = ucwords($uri[4]);  echo $uri[4]; ?>' property='og:description' />

</head>

<?php
if($tpAnuncio['versao'] != '0')
{
    $sqlVersao = mysql_query("SELECT * FROM veiculosVersoes WHERE cod = '{$tpAnuncio['versao']}'");
    $tpVersao = mysql_fetch_assoc($sqlVersao);
    $versao = $tpVersao['versao'];
}
else
{
    $versao = '';
}

// verifica se vai ter o form para enviar proposta
if($tpAnuncio['codPlanoParticular'] > 0)
{
    $sqlVerificaContato = "SELECT alertaEmail FROM planosParticular WHERE cod = '{$tpAnuncio['codPlanoParticular']}'";
    
}
else
{
    $sqlVerificaContato = "SELECT alertaEmail FROM planosRevenda WHERE cod = '{$tpAnuncio['codPlanoRevenda']}'";
}
$queryVerificaContato = mysql_query($sqlVerificaContato);
$numVerificaContato = mysql_num_rows($queryVerificaContato);
if($numVerificaContato > 0)
{
    $tpVerificaContato = mysql_fetch_assoc($queryVerificaContato);
    $verificaContato = $tpVerificaContato['alertaEmail'];
}
else
{
    $verificaContato = 0;
}
// fim

mysql_close();
$erro = 0;
$filtroRel = "";
$breadcrumb = '';

if($tpAnuncio['tipoAnuncio'] == '1')
{
    $breadcrumb = "&nbsp; &gt; &nbsp;<span>Anúncio Particular</span>";
    $filtroRel = "AND ca.dataValidadeAnuncio >= $dataHoje AND c.tipoAnuncio = 1";
    if($tpAnuncio['dataValidadeAnuncio'] < $dataHoje)
    {
        $erro = 1;
    }
    if($dataHoje < $tpAnuncio['dataLiberacaoAnuncio'] || $dataHoje > $tpAnuncio['dataValidadeAnuncio'])
    {
        $erro = 1;
    }  
}
else
{
    $breadcrumb = "&nbsp; &gt; &nbsp;<span>Anúncio Revenda</span>&nbsp; &gt; &nbsp;<span>".($tpAnuncio['nomeFantasia'] != '' ? $tpAnuncio['nomeFantasia'] : $tpAnuncio['razaoSocialNome'])."</span>";    
    $filtroRel = "AND c.tipoAnuncio = 2 AND ca.codCliente = '{$tpAnuncio['codCliente']}'";
}

if($cod == '' || $numAnuncio == 0 || $erro > 0)
{
    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
    echo " <script>";
	echo " location.replace('".$link."'); \n";
	echo " </script>";
    die();
}
if($cod != '')
{
    registraStats($cod,'anunciosStats');
}
if(!empty($_POST['enviarProposta']))
{
    $captcha = isset($_SESSION['captchaDetalhe']) ? $_SESSION['captchaDetalhe'] : '';
    $nome = isset($_POST['nomeProposta']) ? $_POST['nomeProposta'] : '';
    $email = isset($_POST['emailProposta']) ? $_POST['emailProposta'] : '';
    $fone = isset($_POST['telefoneProposta']) ? $_POST['telefoneProposta'] : '';
    $proposta = isset($_POST['mensagemProposta']) ? stripslashes(nl2br($_POST['mensagemProposta'])) : '';  
	  
    if (trim($_POST['captcha']) == $captcha)
    {
        $conexao = conexao();
        $sqlFotosAnuncioPEmail = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$cod' AND tipo = '1' AND referencia = 'clientesAnuncios' AND capa = '1'");
        $numFotosAnuncioPEmail = mysql_num_rows($sqlFotosAnuncioPEmail);
		if($numFotosAnuncioPEmail > 0)
        {
            $tpFotosAnuncioPEmail = mysql_fetch_assoc($sqlFotosAnuncioPEmail);
            $imagem = 'http://www.kicarrao.com.br/arquivos/clientesAnuncios/'.$tpFotosAnuncioPEmail['arquivo'];
        }
        else
        {
            $imagem = 'http://www.kicarrao.com.br/img/placeholderHome1.jpg';
        }
        mysql_close();
		
        $anos = array();
        $tpAnuncio['anoFabricacao'] != '' ? $anos[]=$tpAnuncio['anoFabricacao'] : '';
        $tpAnuncio['anoModelo'] != '' ? $anos[]=$tpAnuncio['anoModelo'] : '';
        $anos = count($anos) > 0 ? implode("/",$anos) : '';
        
        $nomeRev = $tpAnuncio['nomeFantasia'] != '' ? $tpAnuncio['nomeFantasia'] : $tpAnuncio['razaoSocialNome'];
        
        $urlMarcaModelo = ($tpAnuncio['marca'] != '' ? $tpAnuncio['marca'] : '').($tpAnuncio['modelo'] ? ' '.$tpAnuncio['modelo'] : '');
        $urlMarcaModelo = mg_substituirEspacosPorTreacos($urlMarcaModelo);
        
        if($tpAnuncio['tipoAnuncio'] == 1)
        {
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/particular/'.($tpAnuncio['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$tpAnuncio['cod'].($tpAnuncio['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpAnuncio['estado']) : '').($tpAnuncio['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpAnuncio['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$tpAnuncio['cod'];
        }
        else
        {
            
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/revenda/'.$tpAnuncio['cleanTitulo'].'/'.($tpAnuncio['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$tpAnuncio['cod'].($tpAnuncio['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpAnuncio['estado']) : '').($tpAnuncio['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpAnuncio['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$tpAnuncio['cod'];
        }
        
		//$linkAnuncio = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/detalhe/'.$cod : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$cod;
        $preco = number_format($tpAnuncio['valor'],2,',','.');
        $cor = $tpAnuncio['cor'];
        $placa = $tpAnuncio['placa'];
        $descricao = $tpAnuncio['caractVeiculo'];
        $marcaVersao = $tpAnuncio['marca'].($versao != '' ? ' '.$versao : '');
       
        require_once PROJECT_FUNC_PATH . 'propostaEmail.php';
    	$nomeRemetente = "Kicarrão";
    	$assunto = "Proposta - KiCarrão";
    	$emailDestinatario = array($tpAnuncio['email'],'propostas@kicarrao.com.br');
        //$emailDestinatario = array('augustolanzarini@gmail.com');
    	$emailRemetente = 'noreply@kicarrao.com.br';
        $emailResposta  = isset($_POST['emailProposta']) ? $_POST['emailProposta'] : '';
        $conteudoEmail = array(
            'nomeRev'       => $nomeRev,
            'linkAnuncio'   => $link,
            'anos'          => $anos,
            'preco'         => $preco,
            'cor'           => $cor,
            'placa'         => $placa,
            'descricao'     => $descricao,
            'marcaVersao'   => $marcaVersao,
            'imagem'        => $imagem,            
            'nome'          => $nome,
            'email'         => $email,
            'fone'          => $fone,
            'proposta'      => $proposta
        );
        $twitter = '';
        $facebook = 'kicarrao';
    
        $conf = propostaEmail($emailRemetente, $emailDestinatario, $emailResposta, $assunto, $nomeRemetente, $conteudoEmail, $twitter, $facebook);
	
		if($conf)
		{
            $conexao = conexao();
            $dataCadastro = date('Y-m-d');
            $insereProposta = "INSERT INTO propostas (dataCadastro, codAnuncio, codCliente, nome, email, telefone, proposta) VALUES ('{$dataCadastro}','{$tpAnuncio['cod']}','{$tpAnuncio['codCliente']}','{$nome}','{$email}','{$fone}','{$proposta}')";
            for($xz = 0;$xz < 5;$xz++)
            {
                $insertProp = mysql_query($insereProposta);
                if($insertProp)
                {
                    break;
                }
            }
            mysql_close();
            echo "<script type='text/javascript'>
					alert('".$nome.", sua proposta foi enviada com sucesso!');
					location.replace('".$link."');
				  </script>";
                  die(); 
		}
		else
		{
            echo "<script type='text/javascript'>
				   alert(\"Erro ao enviar sua proposta, tente novamente mais tarde.\");
                   location.replace('".$link."');
				 </script> \n";
                 die();
		}
    }
    else
    {
        //$msg_erro .= 'Captcha';
        ?>
        <script>
            alert("Código de ativação incorreto! Tente novamente.");
            //location.replace ('contato.php');
        </script>
        <?php
    }
}
else
{
    $nome = '';
    $email = '';
    $fone = '';
    $proposta = '';
}

if(!empty($_POST['submitEnviarAmigo']))
{
    $nomeEnviarAmigo = isset($_POST['nomeEnviarAmigo']) ? $_POST['nomeEnviarAmigo'] : '';
    $amigoEnviarAmigo = isset($_POST['amigoEnviarAmigo']) ? $_POST['amigoEnviarAmigo'] : '';
    $emailEnviarAmigo = isset($_POST['emailEnviarAmigo']) ? $_POST['emailEnviarAmigo'] : ''; 
	
    $auxDns = explode("@",$emailEnviarAmigo);
    if(count($auxDns) > 1)
    {
        $dns = checkdnsrr($auxDns[1]);
    }
    else
    {
      $dns = false;  
    }
    
	
    $anos = array();
    $tpAnuncio['anoFabricacao'] != '' ? $anos[]=$tpAnuncio['anoFabricacao'] : '';
    $tpAnuncio['anoModelo'] != '' ? $anos[]=$tpAnuncio['anoModelo'] : '';
    $anos = count($anos) > 0 ? implode("/",$anos) : '';
    
    $nomeRev = $tpAnuncio['nomeFantasia'] != '' ? $tpAnuncio['nomeFantasia'] : $tpAnuncio['razaoSocialNome'];
    
    $urlMarcaModelo = ($tpAnuncio['marca'] != '' ? $tpAnuncio['marca'] : '').($tpAnuncio['modelo'] ? ' '.$tpAnuncio['modelo'] : '');
    $urlMarcaModelo = mg_substituirEspacosPorTreacos($urlMarcaModelo);
    if($tpAnuncio['tipoAnuncio'] == 1)
    {
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/particular/'.($tpAnuncio['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$tpAnuncio['cod'].($tpAnuncio['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpAnuncio['estado']) : '').($tpAnuncio['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpAnuncio['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$tpAnuncio['cod'];
    }
    else
    {
        
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/revenda/'.$tpAnuncio['cleanTitulo'].'/'.($tpAnuncio['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$tpAnuncio['cod'].($tpAnuncio['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpAnuncio['estado']) : '').($tpAnuncio['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpAnuncio['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$tpAnuncio['cod'];
    }
    
    if($dns == true)
    { 
        $conexao = conexao();
        $sqlFotosAnuncioPEmail = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$cod' AND tipo = '1' AND referencia = 'clientesAnuncios' AND capa = '1'");
        $numFotosAnuncioPEmail = mysql_num_rows($sqlFotosAnuncioPEmail);
    	if($numFotosAnuncioPEmail > 0)
        {
            $tpFotosAnuncioPEmail = mysql_fetch_assoc($sqlFotosAnuncioPEmail);
            $imagem = 'http://www.kicarrao.com.br/arquivos/clientesAnuncios/'.$tpFotosAnuncioPEmail['arquivo'];
        }
        else
        {
            $imagem = 'http://www.kicarrao.com.br/img/placeholderHome1.jpg';
        }
        mysql_close();
        
        $preco = number_format($tpAnuncio['valor'],2,',','.');
        $cor = $tpAnuncio['cor'];
        $placa = $tpAnuncio['placa'];
        $descricao = $tpAnuncio['caractVeiculo'];
        $marcaVersao = $tpAnuncio['marca'].($versao != '' ? ' '.$versao : '');
       
        require_once PROJECT_FUNC_PATH . 'enviaAmigoEmail.php';
    	$nomeRemetente = "Kicarrão";
    	$assunto = "Indicação de Anúncio - KiCarrão";
    	$emailDestinatario = array($emailEnviarAmigo);
        //$emailDestinatario = array('augustolanzarini@gmail.com');
    	$emailRemetente = 'noreply@kicarrao.com.br';
        $emailResposta  = 'noreply@kicarrao.com.br';
        $conteudoEmail = array(
            'nomeAmigo'       => $amigoEnviarAmigo,
            'linkAnuncio'   => $link,
            'anos'          => $anos,
            'preco'         => $preco,
            'cor'           => $cor,
            'placa'         => $placa,
            'marcaVersao'   => $marcaVersao,
            'imagem'        => $imagem,            
            'nome'          => $nomeEnviarAmigo,
            'email'         => $emailEnviarAmigo
        );
        $twitter = '';
        $facebook = 'kicarrao';
    
        $conf = enviaAmigoEmail($emailRemetente, $emailDestinatario, $emailResposta, $assunto, $nomeRemetente, $conteudoEmail, $twitter, $facebook);
    
    	if($conf)
    	{
                echo "<script type='text/javascript'>
    					alert('".$nomeEnviarAmigo.", seu e-mail foi enviado com sucesso!');
    					document.location.replace('".$link."');
    				  </script>";
                      die(); 
    	}
    	else
    	{
                echo "<script type='text/javascript'>
    				   alert(\"Erro ao enviar, tente novamente mais tarde.\");
                       document.location.replace('".$link."');
    				 </script> \n";
                     die();
    	}
    }
    else
    {
        echo "<script type='text/javascript'>
			   alert(\"Erro ao enviar, tente novamente mais tarde.\");
               document.location.replace('".$link."');
			 </script> \n";
             die();
    }
}
else
{
    $nomeEnviarAmigo = '';
    $amigoEnviarAmigo = '';
    $emailEnviarAmigo = ''; 
}
?>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="sobreposto">&nbsp;</div>
<div class="mestre">
	<?php require_once PROJECT_INC_PATH.'topo.php';?>
    <?php require_once PROJECT_INC_PATH.'menu.php';?>
    <div class="ofertabloco">
        <div class="centroinside">
            <div class="breadcrumb">
            <?
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
            ?>
                <a href="<?=$link;?>">Home</a><?=$breadcrumb;?>
            </div>
        </div>
    </div>
    <div class="centro">
    	<div class="centroinside">
            <div class="noticiablocogeral">
                <div class="detalheleft">
                    <div class="detalhevoltar"><a href="javascript:history.back();"><img src="<?=ssl().PROJECT_URL;?>/img/setavoltar.png" alt="Voltar" />Voltar</a></div>
                    <div class="detalheshare">
                        <p>Compartilhe:</p>
                        <div class="detalheshareitem">
                            <div class="fb-like" data-href="<?=$linkCurtir;?>" data-width="100" data-layout="button_count" data-action="recommend" data-show-faces="false" data-share="false"></div>
                        </div>
                        <div class="detalheshareitem" id="tweet">
                            <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?=$linkCurtir;?>" data-via="revistadogremio" data-lang="pt">Tweetar</a>
                            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                        </div>
                        <div class="detalheshareitem">
                            <script src="//platform.linkedin.com/in.js" type="text/javascript">
                             lang: pt_BR
                            </script>
                            <script type="IN/Share" data-url="<?=$linkCurtir;?>"></script>
                        </div>
                        <div class="detalheshareitem" id="plus">
                            <!-- Place this tag where you want the +1 button to render. -->
                            <div class="g-plusone" data-href="<?=$linkCurtir;?>" data-title="Teste Monge" data-size="medium" data-annotation="inline" data-width="120"></div>
                            
                            <!-- Place this tag after the last +1 button tag. -->
                            <script type="text/javascript">
                              window.___gcfg = {lang: 'pt-BR'};
                            
                              (function() {
                                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                po.src = 'https://apis.google.com/js/platform.js';
                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                              })();
                            </script>
                        </div>
                    </div>
                    <?
                    $conexao = conexao();
                    $sqlFotosAnuncioCapaM = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$cod' AND tipo = '2' AND referencia = 'clientesAnuncios' AND capa = '1'");
                    $sqlFotosAnuncioCapaG = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$cod' AND tipo = '3' AND referencia = 'clientesAnuncios' AND capa = '1'");
                    $numFotosAnuncio = mysql_num_rows($sqlFotosAnuncioCapaM);
                    if($numFotosAnuncio > 0)
                    {
                        $tpFotosAnuncioCapaM = mysql_fetch_assoc($sqlFotosAnuncioCapaM);
                        $tpFotosAnuncioCapaG = mysql_fetch_assoc($sqlFotosAnuncioCapaG);
                        
                        $sqlFotosAnuncioP = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$cod' AND tipo = '1' AND referencia = 'clientesAnuncios' AND capa = '0'");
                        $numFotosAnuncioP = mysql_num_rows($sqlFotosAnuncioP);
                    ?>
                        <div class="detalhefotobloco" <?=$numFotosAnuncioP > 0 ? '' : 'style="width:auto;"';?>>
                            <div class="detalhefotowrap">
                                <div class="detalhefoto">
                                    <a href="<?=ssl().PROJECT_URL;?>/arquivos/clientesAnuncios/<?=$tpFotosAnuncioCapaG['arquivo'];?>" id="fancy" rel="galeria">
                                        <img src="<?=ssl().PROJECT_URL;?>/arquivos/clientesAnuncios/<?=$tpFotosAnuncioCapaM['arquivo'];?>" width="479" alt="Revenda" />
                                    </a>
                                </div>
                            </div>
                            <?
                            if($numFotosAnuncioP > 0)
                            {
                            ?>
                            <div class="detalheminibloco">
                                <div class="detalheminicarro">
                                    <?
                                    if($numFotosAnuncioP > 3)
                                    {
                                    ?>
                                        <div class="detalhesetaesq">
                                            <img src="<?=ssl().PROJECT_URL;?>/img/setaesqdetalhe.png" alt="Revenda" />
                                        </div>
                                    <?
                                    }
                                    ?>
                                    <div class="detalheminicarrowrap">
                                        <ul>
                                        <?
                                        for($x = 0;$x < $numFotosAnuncioP;$x++)
                                        {
                                            $tpFotosAnuncioP = mysql_fetch_assoc($sqlFotosAnuncioP);
                                            $sqlFotosAnuncioG = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$cod' AND tipo = '3' AND referencia = 'clientesAnuncios' AND codigo = '{$tpFotosAnuncioP['codigo']}'");
                                            $tpFotosAnuncioG = mysql_fetch_assoc($sqlFotosAnuncioG);
                                        ?>
                                            <li>
                                                <a href="<?=ssl().PROJECT_URL;?>/arquivos/clientesAnuncios/<?=$tpFotosAnuncioG['arquivo'];?>" id="fancy" rel="galeria">
                                                    <img src="<?=ssl().PROJECT_URL;?>/arquivos/clientesAnuncios/<?=$tpFotosAnuncioP['arquivo'];?>" width="125" alt="Revenda" />
                                                </a>
                                            </li>
                                        <?
                                        }
                                        ?>
                                        </ul>
                                    </div>
                                    <?
                                    if($numFotosAnuncioP > 3)
                                    {
                                    ?>
                                        <div class="detalhesetadir">
                                            <img src="<?=ssl().PROJECT_URL;?>/img/setadirdetalhe.png" alt="Revenda" />
                                        </div>
                                    <?
                                    }
                                    ?>
                                </div>
                            </div>
                            <?
                            }
                            ?>
                        </div>
                    <?
                    }
                    $anos = array();
                    $tpAnuncio['anoFabricacao'] != '' ? $anos[]=$tpAnuncio['anoFabricacao'] : '';
                    $tpAnuncio['anoModelo'] != '' ? $anos[]=$tpAnuncio['anoModelo'] : '';
                    $combustivel = combustivel($tpAnuncio['combustivel']);
                    mysql_close();
                        
                    ?>
                    <div class="propriedade">
                        <?
                        $conexao = conexao();
                        $sqlFotoCliente = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '{$tpAnuncio['codCliente']}' AND referencia = 'clienteRevenda' AND tipo = '1'");
                        $numFotoCliente = mysql_num_rows($sqlFotoCliente);
                        $tpFotoCliente = mysql_fetch_assoc($sqlFotoCliente);
                        mysql_close();
                        if($tpAnuncio['tipoAnuncio'] == '2')
                        {
                        ?>    
                            <div class="propriedadeimg">
                                <a>
                                    <img src="<?=$numFotoCliente > 0 ? ssl().PROJECT_URL.'/arquivos/clientesRevendas/'.$tpFotoCliente['arquivo'] : ssl().PROJECT_URL.'/img/placeholderRevDetalhe.jpg';?>" alt="Vando Automóveis" />
                                </a>
                            </div>
                        <?
                        }else{
                        ?>
                            <div class="particularimg">
                                <img src="<?=ssl().PROJECT_URL;?>/img/veiculo-particular.png" alt="Veículo Particular" />
                            </div>
                        <?    
                        }
                        ?>
                        <div class="propriedadetexto">
                            
                            <?
                            if($tpAnuncio['tipoAnuncio'] == '1')
                            {
                            ?>
                                <span><?=$tpAnuncio['razaoSocialNome'];?> <?=$tpAnuncio['sobrenome'];?></span>
                            <?php
                            }
                            else
                            {
                            ?>
                                <span><?=$tpAnuncio['nomeFantasia'] != '' ? $tpAnuncio['nomeFantasia'] : $tpAnuncio['razaoSocialNome'];?></span>
                                <?=$tpAnuncio['endereco'];?><?=$tpAnuncio['numero'] != '' ? ", ".$tpAnuncio['numero'] : "";?>
                                <br />
							    <?=$tpAnuncio['bairro'] != '' ? $tpAnuncio['bairro']." - " : "";?>  
                            <?
                            }
                            ?>
                            <?=$tpAnuncio['cidade'] != '' ? $tpAnuncio['cidade'] : "";?> 
							<?=$tpAnuncio['estado'] != '' ? " / ".$tpAnuncio['estado'] : "";?> 
                            <span class="propriedadefone"><?=$tpAnuncio['telRes'];?><?=$tpAnuncio['telCel'] != '' ? " <br> ".$tpAnuncio['telCel'] : "";?></span>
                            <div class="propriedadelinks">
                                <?
                                if($tpAnuncio['tipoAnuncio'] == '2' && $tpAnuncio['site'] != '')
                                {
                                ?>
                                    <a class="revendasite" href="<?=$tpAnuncio['site'];?>" target="_blank">
                                        <img src="<?=ssl().PROJECT_URL;?>/img/globo.png" alt="Site" />
                                        <span>Ver site da revenda</span>
                                    </a>
                                    <?
                                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/revenda/'.$tpAnuncio['cleanTitulo'].($tpAnuncio['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpAnuncio['estado']) : '').($tpAnuncio['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpAnuncio['cidade']) : '') : sslRedir().PROJECT_URL.'/revenda-lista.php?cod='.$tpAnuncio['cod'];
                                    ?>
                                    <div class="verestoquedetalhe">
                                        <a href="<?=$link;?>"><img src="<?=ssl().PROJECT_URL;?>/img/botaoverestoque-detalhe.png" alt="Ver Estoque" /></a>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!--
                    <div class="detalheprecobloco">
                        <div class="detalheprecodados">
                            <p>
                                <img src="<?=ssl().PROJECT_URL;?>/img/fipelogo.jpg" alt="Fipe" title="Fipe" />
                                <span>Preço médio</span>
                            </p>
                        </div>
                        <div class="detalheprecodados">
                            <p>
                                R$ <b>52.945,00 <?//=number_format($precoMax,2,',','.');?></b>
                            </p>
                        </div>
                    </div>
                    -->
                    <?
                    if(isset($_GET['teste']))
                    {
                        $conexao = conexao();
                        $codVersao = $tpAnuncio['versao'] != '0' ? ' AND versao='.$tpAnuncio['versao'] : '';
                        $sqlPrecoMedio = mysql_query("SELECT * FROM clientesAnuncios WHERE modelo = '{$tpAnuncio['codModelo']}' AND marca = '{$tpAnuncio['codMarca']}' $codVersao");
                        $numPrecoMedio = mysql_num_rows($sqlPrecoMedio);
                        $precos = array();
                        $precoMedio = 0;
                        for($x= 0;$x < $numPrecoMedio;$x++)
                        {
                            $tpPrecoMedio = mysql_fetch_assoc($sqlPrecoMedio);
                            $precos[] = $tpPrecoMedio['valor'];
                            $precoMedio += $tpPrecoMedio['valor'];
                        }
                        mysql_close();
                        $precoMax = max($precos);
                        $precoMin = min($precos);
                        $precoMedio = $precoMedio / $numPrecoMedio;
                       ?> 
                       <div class="detalheprecobloco">
                            <div class="detalheprecodados">
                                <p>
                                    Preço da tabela FIPE:
                                    <span>R$ 16.000,00</span>
                                </p>
                                <p>
                                    Preço médio Kicarrão:
                                    <span>R$ <?=number_format($precoMedio,2,',','.');?></span>
                                </p>
                            </div>
                            <div class="detalheprecodados">
                                <p>
                                    Maior preço anunciado:
                                    <span>R$ <?=number_format($precoMax,2,',','.');?></span>
                                </p>
                                <p>
                                    Menor preço anunciado:
                                    <span>R$ <?=number_format($precoMin,2,',','.');?></span>
                                </p>
                            </div>
                        </div>
                    <?
                    }
					// ## caso o plano não contemple proposta por e-mail
                    //if($verificaContato > 0)
                    //{
                    ?>
                </div>
                <div class="detalheright">
                    <div class="detalhetextobloco">
                        <div class="detalhetopo">
                            <div class="detalhevisualizacao">
                                <img src="<?=ssl().PROJECT_URL;?>/img/visualizacoes.png" alt="Nº de Visualizações" />
                                <?
                                $conexao = conexao();
                                $calculaStatus = mysql_query("SELECT * FROM anunciosStats WHERE codReferencia = '$cod'");
                                $numCalculaStatus = mysql_num_rows($calculaStatus);
                                mysql_close();
                                ?>
                                <span>N° de Visualizações: <?=$numCalculaStatus;?></span>
                            </div>
                            <div class="detalhecodigo">
                                cód. <?=$tpAnuncio['cod'];?>
                            </div>
                        </div>
                        <div class="detalhevalortotal">
                            Valor R$ <span><?=number_format($tpAnuncio['valor'],2,',','.');?></span>
                        </div>
                        <?
                        $favoritoImg = 'iconeFavoritos';
                        $msgFavorito = 'Adicionar<br /> aos Favoritos';
                        if(isset($_COOKIE['favoritos']) && $_COOKIE['favoritos'] != '')
                        {
                            $cookirFav = unserialize($_COOKIE['favoritos']);
                            if(in_array($cod,$cookirFav))
                            {
                                $favoritoImg = 'iconeFavoritos-hover';
                                $msgFavorito = 'Remover<br /> dos Favoritos';
                            }
                        }
                        ?>
                        <div class="detalhemenu">
                            <div class="detalhemenuitem favoritoDoDetalhe" rel="<?=$cod;?>">
                                <a>
                                    <img src="<?=ssl().PROJECT_URL;?>/img/<?=$favoritoImg;?>.png" alt="Adicionar aos Favoritos" />
                                    <span><?=$msgFavorito;?></span>
                                </a>
                            </div>
                            <div class="detalhemenuitem">
                                <?
                                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/imprimir/'.$cod : sslRedir().PROJECT_URL.'/busca-detalhe-imprimir.php?cod='.$cod;
                                ?>
                                <a href="<?=$link;?>" target="_blank">
                                    <img src="<?=ssl().PROJECT_URL;?>/img/iconeImprimir.png" alt="Imprimir Anúncio" />
                                    <span>Imprimir<br /> Anúncio</span>
                                </a>
                            </div>
                            <div class="detalhemenuitem" id="enviarAmigo">
                                <a>
                                    <img src="<?=ssl().PROJECT_URL;?>/img/iconeEnviarAmigo.png" alt="Enviar para um amigo" />
                                    <span>Enviar para<br /> um amigo</span>
                                </a>
                            </div>
                            
                            <div class="popupEnviarAmigo">
                                <div class="tituloEnviarAmigo">
                                    <img src="<?=ssl().PROJECT_URL;?>/img/iconeEnviarAmigo.png" alt="Enviar para um amigo" />
                                    <span>Enviar para um amigo</span>
                                </div>
                                <div class="fecharEnviarAmigo">
                                    <img src="<?=ssl().PROJECT_URL;?>/img/modalfechar.png" alt="Fechar" />
                                </div>
                                <form name="formEnviarAmigo" id="formEnviarAmigo" action="" method="post" enctype="multipart/form-data">
                                    <label for="nomeEnviarAmigo">Nome</label>
                                    <input name="nomeEnviarAmigo" id="nomeEnviarAmigo" value="<?=$nomeEnviarAmigo;?>" title="Nome" type="text" />
                                    <br class="clear" />
                                    
                                    <label for="amigoEnviarAmigo">Nome do Amigo</label>
                                    <input name="amigoEnviarAmigo" id="amigoEnviarAmigo" value="<?=$amigoEnviarAmigo;?>" title="Nome do Amigo" type="text" />
                                    <br class="clear" />
                                    
                                    <label for="emailEnviarAmigo">E-mail</label>
                                    <input name="emailEnviarAmigo" id="emailEnviarAmigo" value="<?=$emailEnviarAmigo;?>" title="E-mail" type="text" />
                                    <br class="clear" />
                                    
                                    <input name="submitEnviarAmigo" id="submitEnviarAmigo" title="Enviar" value="&nbsp;" type="submit" />
                                </form>
                                <script type="text/javascript">
                					//<![CDATA[
                						objValidadorCadastro = new xform('#formEnviarAmigo');
                						objValidadorCadastro . adicionar('#nomeEnviarAmigo', 'nome');
                						objValidadorCadastro . adicionar('#amigoEnviarAmigo','nome');
                                        objValidadorCadastro . adicionar('#emailEnviarAmigo', 'email');
                					//]]>
                				</script>
                            </div>    
                        </div>
                        
                        <div class="detalhetexto">
                            <div class="detalhetextoesq">
                                <?=$tpAnuncio['marca'];?> <? //=$tpAnuncio['modelo'];?> <?=$versao;?>
                                <?=count($anos) > 0 ? 'Ano/Modelo: '.implode("/",$anos).'<br />' : '';?>
                                <?=$tpAnuncio['cor'] != '' ? 'Cor: '.$tpAnuncio['cor'].'<br />' : '';?>
                                <?=$tpAnuncio['placa'] != '' ? 'Placa: '.$tpAnuncio['placa'].'<br />' : '';?>
                            </div>
                            <div class="detalhetextodir">
                                <?=$tpAnuncio['combustivel'] != '' ? 'Combustível: '.$combustivel.'<br />' : '';?>
                                <?=$tpAnuncio['km'] != '0' && $tpAnuncio['km'] != '1' ? 'Km: '.$tpAnuncio['km'].' km<br />' : '';?>
                                <?=$tpAnuncio['nPortas'] != '0' ? 'Portas: '.$tpAnuncio['nPortas'].'<br />' : '';?>
                                <?=$tpAnuncio['valorEntrada'] != '0' ? 'Entrada: R$ '.number_format($tpAnuncio['valorEntrada'],2,',','.').'<br />' : '';?>
                                <?=$tpAnuncio['nParcelas'] != '0' ? 'Nº de Parcelas: '.$tpAnuncio['nParcelas'].'<br />' : '';?>
                                <?=$tpAnuncio['valorParcela'] != '0' ? 'Valor da Parcela: R$ '.number_format($tpAnuncio['valorParcela'],2,',','.') : '';?>
                            </div>
                        </div>
                        <?
                        $conexao = conexao();
                        $sqlAcessorios = mysql_query("SELECT * FROM acessoriosAnuncios WHERE codAnuncio = '{$tpAnuncio['cod']}'");
                        $numAcessorios = mysql_num_rows($sqlAcessorios);
                        if($tpAnuncio['caractVeiculo'] != '' || $numAcessorios > 0)
                        {
                        ?>
                            <div class="atributobloco">
                                <div class="atributotopo">
                                    Detalhes do Veículo
                                </div>
                                <div class="atributolistawrap">
                                    <div class="atributolista">
                                    <?
                                    if($numAcessorios > 0)
                                    {
                                        for($x = 0;$x < $numAcessorios;$x++)
                                        {
                                            $tpAcessorios = mysql_fetch_assoc($sqlAcessorios);
                                            $sqlAcessorio = mysql_query("SELECT * FROM acessorios WHERE cod = '{$tpAcessorios['codAcessorio']}'");
                                            $tpAcessorio = mysql_fetch_assoc($sqlAcessorio);
                                    ?>
                                        <div class="atributoitem">
                                            <img src="<?=ssl().PROJECT_URL;?>/img/atributo-possui.png" alt="Possui" />
                                            <span><?=$tpAcessorio['acessorio'];?></span>
                                        </div>
                                    <?
                                        }
                                    }
                                    else
                                    {
                                    ?>    
                                        <div style="color: #6E6E6E; font-family: Arial,Helvetica,sans-serif; font-size: 12px; font-weight: bold; line-height: 16px;">
                                            <?=$tpAnuncio['caractVeiculo'] != '' ? nl2br($tpAnuncio['caractVeiculo']) : '';?>
                                        </div>
                                    <?
                                    }
                                    ?> 
                                    </div>
                                </div>
                            </div>
                        <?
                        }
                        mysql_close();
                        ?>
                        <div class="detalheproposta">
                            <div class="propostafaixa">
                                <p>
                                    <img src="<?=ssl().PROJECT_URL;?>/img/enviarProposta.png" alt="Enviar proposta ao anunciante" />
                                    ENVIAR PROPOSTA AO ANUNCIANTE:
                                </p>
                            </div>
                            <form name="propostaForm" id="propostaForm" method="post" action="" enctype="multipart/form-data">
                                <label for="nomeProposta">Nome</label>
                                <input type="text" name="nomeProposta" id="nomeProposta" value="<?=$nome;?>" title="Nome" />
                                <br class="clear" />
                                
                                <label for="telefoneProposta">Telefone</label>
                                <input type="text" name="telefoneProposta" id="telefoneProposta" value="<?=$fone;?>" title="Telefone" />
                                <br class="clear" />
                                
                                <label for="emailProposta">E-mail</label>
                                <input type="text" name="emailProposta" id="emailProposta" value="<?=$email;?>" title="E-mail" />
                                <br class="clear" />
                                
                                <label for="mensagemProposta">Proposta</label>
                                <textarea name="mensagemProposta" id="mensagemProposta" title="Proposta"><?=$proposta;?></textarea>
                                <br class="clear" />
                                
                                <label for="captcha">&nbsp;</label>
                                <label for="captcha" style="width: auto;">Preencha o código de ativação abaixo:</label><br class="clear" />
                                <label for="captcha">&nbsp;</label>
                                <img style="float: left;" src="<?=ssl().PROJECT_URL;?>/captcha.php" alt="" />
                                <input class="captcha" title="Código de Ativação" name="captcha" type="text" id="captcha" size="20" maxlength="8" />
                                
                                <input type="submit" name="enviarProposta" id="enviarProposta" title="Enviar" value="&nbsp;" />
                            </form>
                        </div>
                        <script type="text/javascript">
        					//<![CDATA[
        						objValidadorCadastro = new xform('#propostaForm');
        						objValidadorCadastro . adicionar('#nomeProposta', 'nome');
        						objValidadorCadastro . adicionar('#telefoneProposta','fone5');
                                objValidadorCadastro . adicionar('#emailProposta', 'email');
        						objValidadorCadastro . adicionar('#mensagemProposta');
                                objValidadorCadastro . adicionar('#captcha');
        					//]]>
        				</script>
                        
                        <!--<div class="detalhetitulo"><?=$tpAnuncio['marca'];?> <? //=$tpAnuncio['modelo'];?> <?=$versao;?></div>
                        <div class="caracteristicas">
                            <?=$tpAnuncio['caractVeiculo'] != '' ? nl2br($tpAnuncio['caractVeiculo']) : '';?> 
                        </div>-->
                        <div class="garantiabloco">
                            <!--<div class="garantiabotao">Adquira garantia de 1 ano</div>-->
                            <div class="garantiamodalbloco">
                                <div class="garantiamodalfechar"><img src="<?=ssl().PROJECT_URL;?>/img/modalfechar.png" alt="Fechar" /></div>
                                <div class="garantiamodal">
                                    <div class="garantiabotaomodal">Adquira garantia de 1 ano</div>
                                    <form name="adquirirGarantia" id="adquirirGarantia" action="" method="post" enctype="multipart/form-data">
                                        <div class="inputbloco">
                                            <label for="marcaGarantia">Marca</label>
                                            <select class="selectgrande" title="Marca" id="marcaGarantia" name="marcaGarantia">
                                                <option value="">-</option>
                                                <option value="1">Carro</option>
                                                <option value="2">Moto</option>
                                                <option value="3">Caminhão</option>
                                                <option value="4">Náutica</option>
                                                <option value="5">Outros</option>
                                            </select>
                                        </div>
                                        <div class="inputbloco">
                                            <label for="modeloGarantia">Modelo</label>
                                            <select class="selectgrande" title="Modelo" id="modeloGarantia" name="modeloGarantia">
                                                <option value="">-</option>
                                                <option value="1">Carro</option>
                                                <option value="2">Moto</option>
                                                <option value="3">Caminhão</option>
                                                <option value="4">Náutica</option>
                                                <option value="5">Outros</option>
                                            </select>
                                        </div>
                                        <div class="inputbloco">
                                            <label for="cilindradaGarantia">Cilindrada</label>
                                            <input type="text" title="Cilindrada" id="cilindradaGarantia" name="cilindradaGarantia" class="inputgrande" tabindex="751" maxlength="150" />
                                        </div>
                                        <div class="inputbloco">
                                            <label for="cilindradaGarantia">&nbsp;</label>
                                            <div class="garantiaradiobloco">
                                                <div class="garantiaradio">
                                                    <input type="radio" title="Selecionar tipo de garantia" value="1" id="filtroBuscaRevenda" name="filtroBusca" class="uncheck" checked="true" />
                                                    <span>Importado</span>
                                                </div>
                                                <div class="garantiaradio">
                                                    <input type="radio" title="Selecionar tipo de garantia" value="2" id="filtroBuscaRevenda" name="filtroBusca" class="uncheck" />
                                                    <span>Nacional</span>
                                                </div>
                                                <div class="garantiaradio">
                                                    <input type="radio" title="Selecionar tipo de garantia" value="3" id="filtroBuscaRevenda" name="filtroBusca" class="uncheck" checked="true" />
                                                    <span>Câmbio Manual</span>
                                                </div>
                                                <div class="garantiaradio">
                                                    <input type="radio" title="Selecionar tipo de garantia" value="4" id="filtroBuscaRevenda" name="filtroBusca" class="uncheck" />
                                                    <span>Câmbio Automático</span>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="submit" value="&nbsp;" title="Enviar" id="enviarGarantia" name="enviarGarantia" tabindex="516" />
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?/*<div class="compartilhebloco">
                    <div class="compartilhe">
                        <p>Compartilhe:</p>
                        <a href="https://www.facebook.com/kicarrao" target="_blank">
                            <img src="<?=ssl().PROJECT_URL;?>/img/detalhe-facebook.png" alt="Facebook" />
                        </a>
                        <a href="https://twitter.com/kicarrao" target="_blank">
                            <img src="<?=ssl().PROJECT_URL;?>/img/detalhe-twitter.png" alt="Twitter" />
                        </a>
                        <!--<a href="#" target="_blank"><img src="http://<?=PROJECT_URL;?>/img/detalhe-google.png" alt="Google Plus" /></a>
                        <a href="#" target="_blank"><img src="http://<?=PROJECT_URL;?>/img/detalhe-pinterest.png" alt="Pinterest" /></a>
                        <a href="#" target="_blank"><img src="http://<?=PROJECT_URL;?>/img/detalhe-orkut.png" alt="Orkut" /></a>
                        <a href="#" target="_blank"><img src="http://<?=PROJECT_URL;?>/img/detalhe-mail.png" alt="" /></a>-->
                    </div>
                </div>*/?>
                
                <?
                //}
                ?>
                <!--<div class="noticiapropaganda">
                    <?php
                    //imprimeBannerLateralDet($tpAnuncio['tipoAnuncio']);
                    //imprimeBannerLateralPequenoDet($tpAnuncio['tipoAnuncio']);
                    ?>
                </div>-->
            </div>
            <div class="detalheoferta">
                <?
                $dataHoje = date('Y-m-d');
                $anunciosSuperDestaque = array();
                $conexao = conexao();
                /** Busca os anunios particulares com plano ouro **/
                $qSuperPart = mysql_query("SELECT ca.cod, ca.cor, ca.combustivel, ca.anoFabricacao, c.cleanTitulo, c.estado, c.cidade, ca.km, vm.marca, ca.valor, vv.versao, vmd.modelo,
                                        (SELECT a.arquivo FROM arquivos AS a WHERE a.codReferencia = ca.cod
                                        AND a.referencia = 'clientesAnuncios' AND a.tipo = 1 ORDER BY a.capa DESC LIMIT 1) AS arquivo
                                        FROM clientesAnuncios AS ca
                                        INNER JOIN clientes AS c ON c.cod = ca.codCliente
                                        INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
                                        INNER JOIN veiculosModelos AS vmd ON vmd.cod = ca.modelo
                                        LEFT JOIN veiculosVersoes AS vv ON vv.cod = ca.versao
                                        WHERE c.tipoAnuncio = 1 AND c.situacao = 1 AND ca.codPlanoParticular = 4
                                        AND ca.status = 1 AND '$dataHoje' BETWEEN ca.dataLiberacaoAnuncio AND ca.dataValidadeAnuncio ORDER BY RAND() LIMIT 10");
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
                /** Busca os anunios de revendas com plano 100 **/
                $qSuperRev100 = mysql_query("SELECT ca.cod, ca.cor, ca.combustivel, ca.anoFabricacao, c.estado, c.cidade, ca.km, vm.marca, c.nomeFantasia, c.cleanTitulo, c.tipoRevenda, ca.valor, vv.versao, vmd.modelo,
                            (SELECT a.arquivo FROM arquivos AS a WHERE a.codReferencia = ca.cod
                            AND a.referencia = 'clientesAnuncios' AND a.tipo = 1 ORDER BY a.capa DESC LIMIT 1) AS arquivo
                            FROM clientesAnuncios AS ca 
                            INNER JOIN clientes AS c ON c.cod = ca.codCliente
                            INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
                            INNER JOIN veiculosModelos AS vmd ON vmd.cod = ca.modelo
                            LEFT JOIN veiculosVersoes AS vv ON vv.cod = ca.versao
                            WHERE c.tipoAnuncio = 2 AND c.situacao = 1 AND ca.superDestaqueHome = '1' AND ca.destaqueHome = '0' AND ca.status = 1 AND (c.codPlanoRevenda = '2' OR c.codPlanoRevenda = '5' OR c.codPlanoRevenda = '9' OR c.codPlanoRevenda = '13' OR c.codPlanoRevenda = '22' OR c.codPlanoRevenda = '24' OR c.codPlanoRevenda = '26' OR c.codPlanoRevenda = '28')
                            ORDER BY RAND() LIMIT 15");
                            //echo mysql_error();
                $nSuperRev100 = mysql_num_rows($qSuperRev100);
                if($nSuperRev100 > 0)
                {
                    for($a=0;$a<$nSuperRev100;$a++)
                    {
                        $tpSuperRev100 = mysql_fetch_assoc($qSuperRev100);
                        $anunciosSuperDestaque[] = array(
                                                            'cod' => $tpSuperRev100['cod'],
                                                            'cor' => $tpSuperRev100['cor'],
                                                            'combustivel' => combustivel($tpSuperRev100['combustivel']),
                                                            'anoFabricacao' => $tpSuperRev100['anoFabricacao'],
                                                            'marca' => $tpSuperRev100['marca'],
                                                            'versao' => $tpSuperRev100['versao'],
                                                            'modelo' => $tpSuperRev100['modelo'],
                                                            'cidade' => $tpSuperRev100['cidade'],
                                                            'estado' => $tpSuperRev100['estado'],
                                                            'km' => $tpSuperRev100['km'],
                                                            'valor' => "R$ ".number_format((float)$tpSuperRev100['valor'],2,',','.'),
                                                            'arquivo' => $tpSuperRev100['arquivo'],
                                                            'anunciante' => $tpSuperRev100['nomeFantasia'],
                                                            'cleanTitulo' => $tpSuperRev100['cleanTitulo'], 
                                                            'tipoAnuncio' => 2,
                                                        );
                    }
                    
                }
                /** Busca os anunios de revendas com plano 200 **/
                $qSuperRev200 = mysql_query("SELECT ca.cod, ca.cor, ca.combustivel, ca.anoFabricacao, c.estado, c.cidade, ca.km, vm.marca, c.nomeFantasia, c.cleanTitulo, c.tipoRevenda, ca.valor, vv.versao, vmd.modelo,
                            (SELECT a.arquivo FROM arquivos AS a WHERE a.codReferencia = ca.cod
                            AND a.referencia = 'clientesAnuncios' AND a.tipo = 1 ORDER BY a.capa DESC LIMIT 1) AS arquivo
                            FROM clientesAnuncios AS ca 
                            INNER JOIN clientes AS c ON c.cod = ca.codCliente
                            INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
                            INNER JOIN veiculosModelos AS vmd ON vmd.cod = ca.modelo
                            LEFT JOIN veiculosVersoes AS vv ON vv.cod = ca.versao
                            WHERE c.tipoAnuncio = 2 AND c.situacao = 1 AND ca.superDestaqueHome = '1' AND ca.destaqueHome = '0' AND ca.status = 1 AND (c.codPlanoRevenda = '1' OR c.codPlanoRevenda = '21' OR c.codPlanoRevenda = '23' OR c.codPlanoRevenda = '25' OR c.codPlanoRevenda = '27')
                            ORDER BY RAND() LIMIT 15");
                            //echo mysql_error();
                $nSuperRev200 = mysql_num_rows($qSuperRev200);
                if($nSuperRev200 > 0)
                {
                    for($a=0;$a<$nSuperRev200;$a++)
                    {
                        $tpSuperRev200 = mysql_fetch_assoc($qSuperRev200);
                        $anunciosSuperDestaque[] = array(
                                                            'cod' => $tpSuperRev200['cod'],
                                                            'cor' => $tpSuperRev200['cor'],
                                                            'combustivel' => combustivel($tpSuperRev200['combustivel']),
                                                            'anoFabricacao' => $tpSuperRev200['anoFabricacao'],
                                                            'marca' => $tpSuperRev200['marca'],
                                                            'versao' => $tpSuperRev200['versao'],
                                                            'modelo' => $tpSuperRev200['modelo'],
                                                            'cidade' => $tpSuperRev200['cidade'],
                                                            'estado' => $tpSuperRev200['estado'],
                                                            'km' => $tpSuperRev200['km'],
                                                            'valor' => "R$ ".number_format((float)$tpSuperRev200['valor'],2,',','.'),
                                                            'arquivo' => $tpSuperRev200['arquivo'],
                                                            'anunciante' => $tpSuperRev200['nomeFantasia'],
                                                            'cleanTitulo' => $tpSuperRev200['cleanTitulo'], 
                                                            'tipoAnuncio' => 2,
                                                        );
                    }
                    
                }
                mysql_close();
                shuffle($anunciosSuperDestaque);
                ?>
                <div class="ofertabloco" style="border: none;">
              		<div class="ofertalistaSuper" id="detalheOfertas" style="overflow: hidden; margin-top:25px;">
                        <div class="ofertaheader">
                            <img src="<?=ssl().PROJECT_URL;?>/img/ofertas-premium.png" alt="Ofertas Premium" />
                            <div class="ofertaheaderlinha">&nbsp;</div>
                        </div>
                        <div class="premiumbloco">
                            <?
                            if(count($anunciosSuperDestaque) > 4)
                            {
                            ?>
                                <a href="#" class="paginaNoticiaAnt ofertasPrev">
                                    <img alt="Anterior" src="<?=ssl().PROJECT_URL;?>/img/ofertaesq.png" />
                                </a>
                            <?
                            }
                            ?>
                            <div class="premiumcarro">
                                <ul>
                                <?
                                foreach($anunciosSuperDestaque as $k => $anuncioSuperDestaque)
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
                                 
                                    echo "<li>    
                                            <div class='ofertalistamedio'>
                                                <div class='ofertalistaimgwrap'>
                                                    <div class='ofertalistaimg'><a href='".$link."'><img src='".($anuncioSuperDestaque['arquivo'] != '' ? ssl().PROJECT_URL.'/arquivos/clientesAnuncios/'.$anuncioSuperDestaque['arquivo'] : ssl().PROJECT_URL.'/img/placeholderHome1.jpg')."' alt='Ofertas' /></a></div>
                                                </div>
                                                <div class='ofertalistatexto'>
                                                    <div class='ofertalistapreco'>{$anuncioSuperDestaque['valor']}</div>
                                                    <p class='ofertalistatitulo'><span>{$anuncioSuperDestaque['marca']} {$anuncioSuperDestaque['versao']}</span></p>
                                                    <p><b>{$anuncioSuperDestaque['anunciante']}</b></p>
                                                </div>
                                            </div>
                                        </li>";
                                  }
                                  ?>  
                                </ul>
                            </div>
                            <?
                            if(count($anunciosSuperDestaque) > 4)
                            {
                            ?>
                                <a href="#" class="paginaNoticiaProx ofertasNext">
                                    <img alt="Próxima" src="<?=ssl().PROJECT_URL;?>/img/ofertadir.png" />
                                </a>
                            <?
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <?php require_once PROJECT_INC_PATH.'rodapebloco.php';?>
</div>
</body>
</html>