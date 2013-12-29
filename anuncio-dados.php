<?php require_once 'configRoot.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require_once PROJECT_INC_PATH.'head.php';?>
    <?php
    require_once PROJECT_FUNC_PATH.'enviarEmail.php';
    require_once ADMIN_FUNC_PATH.'validaCampo.php';
	?>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/validador1.4.js"></script>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/jquery.maskedinput.js"></script>
    <script src="<?=ssl().ADMIN_JS_URL;?>/jquery.maskMoney.js" type="text/javascript"></script>
</head>
<?
unset($_SESSION['id_anuncio']);
$_SESSION['boleto'] = 0;
$cod = isset($cod) ? $cod : '';
$cod = isset($_GET['cod']) ? $_GET['cod'] : $cod;
$codPlanoRevenda = isset($_SESSION['codPlanoRevenda']) ? $_SESSION['codPlanoRevenda'] : '';
$codCliente = isset($_SESSION['codCliente']) ? $_SESSION['codCliente'] : '';
$tipoAnuncio = isset($_SESSION['tipoAnuncio']) ? $_SESSION['tipoAnuncio'] : 1;
$plano = isset($_SESSION['plano']) ? $_SESSION['plano'] : 'Bronze';
if(isset($_POST['planoInput']))
{
    $_SESSION['plano'] = $_POST['planoInput'];
}
elseif(!isset($_POST['planoInput']) && !isset($_SESSION['plano']) && $cod == '' && $codCliente == '') 
{
    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/planos' : sslRedir().PROJECT_URL.'/anuncio-planos.php';
    echo " <script>";
	echo " location.replace('".$link."'); \n";
	echo " </script>";
    die();   
}
$conexao = conexao();
if($codPlanoRevenda != '0')
{
    $sqlPlanoRevTipo = mysql_query("SELECT codTipoVeiculo FROM planosRevenda WHERE cod = '$codPlanoRevenda'");
    $tpPlanoRevTipo = mysql_fetch_assoc($sqlPlanoRevTipo);
    $auxFiltroSqlTipoVeiculo = ' WHERE cod = '.$tpPlanoRevTipo['codTipoVeiculo'];
}
else
{
    $auxFiltroSqlTipoVeiculo = '';
}

/*Verifica se o limite de anúncios foi atingido. */
if($codCliente != '' && $tipoAnuncio > 1)
{
    $nOfertas = 0;
    $qNofertas = mysql_query("SELECT pr.nOfertas FROM clientes AS c
                           INNER JOIN planosRevenda AS pr ON c.codPlanoRevenda = pr.cod
                           WHERE c.cod = '$codCliente'
                           GROUP BY pr.cod");
    $nNofertas = mysql_num_rows($qNofertas);
    if($nNofertas > 0)
    {
        $tpNofertas = mysql_fetch_assoc($qNofertas);
        $nOfertas = (int)$tpNofertas['nOfertas'];
        if($nOfertas > 0)
        {
            $qTot = mysql_query("SELECT * FROM clientesAnuncios WHERE codCliente = '{$codCliente}'");
            $ofertasCad = mysql_num_rows($qTot);
            if($ofertasCad >= $nOfertas)
            {
                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';
                echo " <script>";
        		echo " alert(\"O limite de anúncios do seu plano foi atingido! Para aumentar o seu limite entre em contato com o setor comercial do KiCarrão.\");\n";
        		echo " location.replace('".$link."'); \n";
        		echo " </script>";
                die();
            }
        }
    }
}
/*Fim verifica se o limite de anúncios foi atingido. */
mysql_close();
$submit = isset($_POST['enviarDadosAnuncio']) ? $_POST['enviarDadosAnuncio'] : '' ;
$msg = "";
if($submit != '')
{   
    $tipoVeiculo = isset($_POST['tipoVeiculo'])? $_POST['tipoVeiculo'] : '';
    $marca = isset($_POST['marcaVeiculo'])? $_POST['marcaVeiculo'] : '';
    $modelo = isset($_POST['modeloVeiculo'])? $_POST['modeloVeiculo'] : '';
    $versao = isset($_POST['versaoVeiculo'])? $_POST['versaoVeiculo'] : '';
    $placa = isset($_POST['placaVeiculo'])? str_replace('-','',$_POST['placaVeiculo']) : '';
    $anoFabricacao = isset($_POST['anoFabricacaoVeiculo'])? $_POST['anoFabricacaoVeiculo'] : '';
    $anoModelo = isset($_POST['anoModeloVeiculo'])? $_POST['anoModeloVeiculo'] : '';
    $cor = isset($_POST['corVeiculo'])? $_POST['corVeiculo'] : '';
    $combustivel = isset($_POST['combustivelVeiculo'])? $_POST['combustivelVeiculo'] : '';
    $km = isset($_POST['kmVeiculo'])? $_POST['kmVeiculo'] : '';
    $nPortas = isset($_POST['numPortasVeiculo'])? $_POST['numPortasVeiculo'] : '';
    $valor = isset($_POST['valorVistaVeiculo'])? (int)str_replace('.','',$_POST['valorVistaVeiculo']) : '';
    $nParcelas = isset($_POST['quantParcelaVeiculo'])? $_POST['quantParcelaVeiculo'] : '';
    $valorParcela = isset($_POST['valorParcelaVeiculo'])? (int)str_replace('.','',$_POST['valorParcelaVeiculo']) : '';
    $valorEntrada = isset($_POST['valorEntradaVeiculo'])? (int)str_replace('.','',$_POST['valorEntradaVeiculo']) : '';
    $caractVeiculo = isset($_POST['caracteristicasVeiculo'])? $_POST['caracteristicasVeiculo'] : '';
    $superDestaqueHome = isset($_POST['superDestaqueHome'])? $_POST['superDestaqueHome'] : 0;
    $destaqueHome = isset($_POST['destaqueHome'])? $_POST['destaqueHome'] : 0;
    $superDestaqueLista = isset($_POST['superDestaqueLista'])? $_POST['superDestaqueLista'] : 0;
    $destaqueLista = isset($_POST['destaqueLista'])? $_POST['destaqueLista'] : 0;
    $acessorios = isset($_POST['acessorios']) ? $_POST['acessorios'] : array();
    //var_dump($acessorios);
    //die();
    $erro = 0;
    $msg .= '<ul style="color:red; size:10px;font-style:italic;">';
    if (!validaCampo($tipoVeiculo))
    {
        $msg .= '<li>O campo Tipo de veiculo deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($marca))
    {
        $msg .= '<li>O campo Marca deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($modelo))
    {
        $msg .= '<li>O campo Modelo deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($placa))
    {
        $msg .= '<li>O campo Placa deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($cor))
    {
        $msg .= '<li>O campo Cor deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($combustivel))
    {
        $msg .= '<li>O campo Combustível deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    /*if ($caractVeiculo == '')
    {
        $msg .= '<li>O campo Características do Veículo deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }*/
    $msg .= '</ul>';
    
    if($erro == 0)
    {
        $conexao = conexao();
        if($cod == '')
        { 
            $dataCadastro = date('Y-m-d');
            if($tipoAnuncio == '1')
            {
                $sqlPlano = mysql_query("SELECT * FROM planosParticular WHERE plano = '{$plano}'");
                $tpPlano = mysql_fetch_assoc($sqlPlano);
                $destaqueHome = $tpPlano['destaqueCapa'];
                $destaqueLista = $tpPlano['destaqueLista'];
                $planoValor = $tpPlano['valor'];
                $codPlano = $tpPlano['cod'];
                $nDias = $tpPlano['tempo'];
                
                $nFotos = $tpPlano['nFotos'];
                $sql = "INSERT INTO clientesAnuncios 
                        (dataCadastro, codCliente, tipoVeiculo, marca, modelo, versao, placa, anoFabricacao, anoModelo, cor, combustivel,
                        km, nPortas, valor, nParcelas, valorParcela, valorEntrada, plano,
                        nFotos, planoValor, nDias, codPlanoParticular, destaqueHome, superDestaqueHome, destaqueLista, superDestaqueLista, caractVeiculo)
                        VALUES
                        ('$dataCadastro','{$codCliente}','{$tipoVeiculo}', '{$marca}', '{$modelo}', '{$versao}', '{$placa}', '{$anoFabricacao}',
                        '{$anoModelo}', '{$cor}', '{$combustivel}', '{$km}', '{$nPortas}', '{$valor}', '{$nParcelas}',
                        '{$valorParcela}', '{$valorEntrada}', '{$plano}',
                        '{$nFotos}', '$planoValor','$nDias', '$codPlano','$destaqueHome', '$superDestaqueHome','$destaqueLista', '$superDestaqueLista', '$caractVeiculo');";
            
            }
            else
            {
                $sql = "INSERT INTO clientesAnuncios 
                        (dataCadastro, codCliente, tipoVeiculo, marca, modelo, versao, placa, anoFabricacao, anoModelo, cor, combustivel,
                        km, nPortas, valor, nParcelas, valorParcela, valorEntrada, destaqueHome, superDestaqueHome, destaqueLista, superDestaqueLista, status, caractVeiculo)
                        VALUES
                        ('$dataCadastro','{$codCliente}','{$tipoVeiculo}', '{$marca}', '{$modelo}', '{$versao}', '{$placa}', '{$anoFabricacao}',
                        '{$anoModelo}', '{$cor}', '{$combustivel}', '{$km}', '{$nPortas}', '{$valor}', '{$nParcelas}',
                        '{$valorParcela}', '{$valorEntrada}', '$destaqueHome', '$superDestaqueHome','$destaqueLista', '$superDestaqueLista', '1', '$caractVeiculo');";
                
            }
            $resultado = mysql_query($sql);
        	if($resultado)
            {
                $codRedir = mysql_insert_id();
                foreach($acessorios as $k => $v)
                {
                    $sqlAcessorioIns = "INSERT INTO acessoriosAnuncios (codAnuncio, codAcessorio) VALUES ('$codRedir','$v')";
                    for($a=0;$a<5;$a++)
                    {
                        $qAcessoriosIns = mysql_query($sqlAcessorioIns);
                        if($qAcessoriosIns)
                        {
                            break;
                        } 
                    }
                }
                if($tipoAnuncio == '1')
                {
                    $_SESSION['id_anuncio'] = $codRedir;
                    $_SESSION['tipoLogin'] = 2;
                
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/identificacao' : sslRedir().PROJECT_URL.'/identificacao.php';
                }
                else
                {
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-fotos/'.$codRedir : sslRedir().PROJECT_URL.'/anuncio-fotos.php?cod='.$codRedir ;
                }
                echo " <script>";
        		echo " location.replace('".$link."'); \n";
        		echo " </script>";
                die();
        	}
            else
        	{
                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-dados' : sslRedir().PROJECT_URL.'/anuncio-dados.php';
                echo " <script>";
        		echo " location.replace('".$link."'); \n";
        		echo " </script>";
                die();
        	}
        }
        else
        {
            if($tipoAnuncio == '1')
            {
                $sql = "UPDATE clientesAnuncios SET 
                        tipoVeiculo = '{$tipoVeiculo}',
                        marca = '{$marca}',
                        modelo = '{$modelo}',
                        versao = '{$versao}',
                        placa = '{$placa}',
                        anoFabricacao = '{$anoFabricacao}',
                        anoModelo = '{$anoModelo}',
                        cor = '{$cor}',
                        combustivel = '{$combustivel}',
                        km = '{$km}',
                        nPortas = '{$nPortas}',
                        valor = '{$valor}',
                        nParcelas = '{$nParcelas}',
                        caractVeiculo = '{$caractVeiculo}',
                        valorParcela = '{$valorParcela}',
                        valorEntrada = '{$valorEntrada}'
                        WHERE cod = '$cod'";
            }
            else
            {
                $sql = "UPDATE clientesAnuncios SET 
                        tipoVeiculo = '{$tipoVeiculo}',
                        marca = '{$marca}',
                        modelo = '{$modelo}',
                        versao = '{$versao}',
                        placa = '{$placa}',
                        anoFabricacao = '{$anoFabricacao}',
                        anoModelo = '{$anoModelo}',
                        cor = '{$cor}',
                        combustivel = '{$combustivel}',
                        km = '{$km}',
                        nPortas = '{$nPortas}',
                        valor = '{$valor}',
                        nParcelas = '{$nParcelas}',
                        caractVeiculo = '{$caractVeiculo}',
                        valorParcela = '{$valorParcela}',
                        valorEntrada = '{$valorEntrada}',
                        destaqueHome = '{$destaqueHome}',
                        superDestaqueHome = '{$superDestaqueHome}',
                        destaqueLista = '{$destaqueLista}',
                        superDestaqueLista = '{$superDestaqueLista}'
                        WHERE cod = '$cod'";
            }
        	$resultado = mysql_query($sql);
            $apagaAcessorios = mysql_query("DELETE FROM acessoriosAnuncios WHERE codAnuncio = '$cod'");
            foreach($acessorios as $k => $v)
            {
                $sqlAcessorioIns = "INSERT INTO acessoriosAnuncios (codAnuncio, codAcessorio) VALUES ('$cod','$v')";
                for($a=0;$a<5;$a++)
                {
                    $qAcessoriosIns = mysql_query($sqlAcessorioIns);
                    if($qAcessoriosIns)
                    {
                        break;
                    } 
                }
            }
            
            if($resultado)
            {
                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-fotos/'.$cod : sslRedir().PROJECT_URL.'/anuncio-fotos.php?cod='.$cod ;
                echo " <script>";
        		echo " location.replace('".$link."'); \n";
        		echo " </script>";
                die();
        	}
            else
        	{
                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-dados/'.$cod : sslRedir().PROJECT_URL.'/anuncio-dados.php?cod='.$cod;
                echo " <script>";
        		echo " location.replace('".$link."'); \n";
        		echo " </script>";
                die();
        	}
        }
        mysql_close();
    }
}
else
{        
    if($cod == '')
    {
        $tipoVeiculo = '';
        $marca = '';
        $modelo = '';
        $versao = '';
        $placa = '';
        $anoFabricacao = '';
        $anoModelo = '';
        $cor = '';
        $combustivel = '';
        $km = '';
        $nPortas = 0;
        $valor = 0;
        $nParcelas = 0;
        $valorParcela = 0;
        $valorEntrada = 0;
        $caractVeiculo = '';
        $superDestaqueHome = 0;
        $destaqueHome = 0;
        $superDestaqueLista = 0;
        $destaqueLista = 0;
    }
    else
    {
        $conexao = conexao();
        $sqlDadosAnuncio = mysql_query("SELECT * FROM clientesAnuncios WHERE codCliente = '$codCliente' AND cod = '$cod'");
        $numDadosAnuncio = mysql_num_rows($sqlDadosAnuncio);
        if($numDadosAnuncio > 0)
        {
            $tpDadosAnuncio = mysql_fetch_assoc($sqlDadosAnuncio);
            $tipoVeiculo = $tpDadosAnuncio['tipoVeiculo'];
            $marca = $tpDadosAnuncio['marca'];
            $modelo = $tpDadosAnuncio['modelo'];
            $versao = $tpDadosAnuncio['versao'];
            $placa = str_replace('-','',$tpDadosAnuncio['placa']);
            $anoFabricacao = $tpDadosAnuncio['anoFabricacao'];
            $anoModelo = $tpDadosAnuncio['anoModelo'];
            $cor = $tpDadosAnuncio['cor'];
            $combustivel = $tpDadosAnuncio['combustivel'];
            $km = $tpDadosAnuncio['km'];
            $nPortas = $tpDadosAnuncio['nPortas'];
            $valor = $tpDadosAnuncio['valor'];
            $nParcelas = $tpDadosAnuncio['nParcelas'];
            $valorParcela = $tpDadosAnuncio['valorParcela'];
            $valorEntrada = $tpDadosAnuncio['valorEntrada'];
            $caractVeiculo = $tpDadosAnuncio['caractVeiculo'];
            $superDestaqueHome = $tpDadosAnuncio['superDestaqueHome'];
            $destaqueHome = $tpDadosAnuncio['destaqueHome'];
            $superDestaqueLista = $tpDadosAnuncio['superDestaqueLista'];
            $destaqueLista = $tpDadosAnuncio['destaqueLista'];
        }
        else
        {
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
            echo " <script>";
        	echo " location.replace('".$link."'); \n";
        	echo " </script>";
            die();
        }
        mysql_close();
    }
}
?>
<script type="text/javascript">
$(document).ready(function()
{
    $("input#valorVistaVeiculo").maskMoney({showSymbol:true, symbol:"R$ ", decimal:"", thousands:".", precision: false, defaultZero: false});
    $("input#valorParcelaVeiculo").maskMoney({showSymbol:true, symbol:"R$ ", decimal:"", thousands:".", precision: false, defaultZero: false});
    $("input#valorEntradaVeiculo").maskMoney({showSymbol:true, symbol:"R$ ", decimal:"", thousands:".", precision: false, defaultZero: false});
    
    $('#tipoVeiculo').change(function()
    {
        if($(this).val())
        {
            $('#marcaVeiculo').hide();
            $('.carregandoMarca').show();
            
            $.ajax(
            {
                type: "POST",
                url: "<?=ssl().PROJECT_URL;?>/adm/ajax/ajaxMarca.php",
                data:
                {
                    cod: $(this).val()
                
                },
                dataType: "json", 
                success: function(j)
                { 
                    var options = '<option value="">-</option>';
					var separador = 0;	
                    for (var i = 0; i < j.length; i++) 
                    {
                        if(separador == 0 && j[i].destaque == 0)
						{
							options += '<option value="" disabled="disabled">&nbsp;</option>';
							separador = 1;
						}
						options += '<option value="' + j[i].cod + '">' + j[i].marca + '</option>';
						
                    }	
                    $('#marcaVeiculo').html(options).show();
                    $('.carregandoMarca').hide();
                    $('#modeloVeiculo').html('<option value="">-</option>');
                    $('#versaoVeiculo').html('<option value="">-</option>');
                }
            });              
        }
        else
        {
            $('#marcaVeiculo').html('<option value="">-</option>');
            $('#modeloMarca').html('<option value="">-</option>');
            $('#modeloVeiculo').html('<option value="">-</option>');
            $('#versaoVeiculo').html('<option value="">-</option>');
        }
    })
    $('#marcaVeiculo').change(function()
    {
        if($(this).val())
        {
            $('#modeloVeiculo').hide();
            $('.carregandoModelo').show();
            
            $.ajax(
            {
                type: "POST",
                url: "<?=ssl().PROJECT_URL;?>/adm/ajax/ajaxModelo.php",
                data:
                {
                    cod: $(this).val()
                
                },
                dataType: "json", 
                success: function(j)
                { 
                    var options = '<option value="">-</option>';	
                    for (var i = 0; i < j.length; i++) 
                    {
                        options += '<option value="' + j[i].cod + '">' + j[i].modelo + '</option>';
                    }	
                    $('#modeloVeiculo').html(options).show();
                    $('.carregandoModelo').hide();
                    $('#versaoVeiculo').html('<option value="">-</option>');
                }
            });              
        }
        else
        {
            $('#modeloVeiculo').html('<option value="">-</option>');
            $('#versaoVeiculo').html('<option value="">-</option>');
            
        }
    })
    
    $('#modeloVeiculo').change(function()
    {
        if($(this).val())
        {
            $('#versaoVeiculo').hide();
            $('.carregandoVersao').show();
            
            $.ajax(
            {
                type: "POST",
                url: "<?=ssl().PROJECT_URL;?>/adm/ajax/ajaxVersao.php",
                data:
                {
                    cod: $(this).val()
                
                },
                dataType: "json", 
                success: function(j)
                { 
                    var options = '<option value="">-</option>';	
                    for (var i = 0; i < j.length; i++) 
                    {
                        options += '<option value="' + j[i].cod + '">' + j[i].versao + '</option>';
                    }	
                    $('#versaoVeiculo').html(options).show();
                    $('.carregandoVersao').hide();
                }
            });              
        }
        else
        {
            $('#versaoVeiculo').html('<option value="">-</option>');
            
        }
    })
    
    $('#anoFabricacaoVeiculo').change(function()
    {
        if($(this).val())
        {
            $('#anoModeloVeiculo').hide();
            $('#carregandoAnoModelo').show();
            
            $.ajax(
            {
                type: "POST",
                url: "<?=ssl().PROJECT_URL;?>/adm/ajax/ajaxAnosModelo.php",
                data:
                {
                    ano: $(this).val()
                
                },
                dataType: "json", 
                success: function(j)
                { 
                    options = '';
                    for (var i = 0; i < j.length; i++) 
                    {
                        options += '<option value="' + j[i].ano + '">' + j[i].ano + '</option>';
                    }	
                    $('#anoModeloVeiculo').html(options).show();
                    $('#carregandoAnoModelo').hide();
                }
            });              
        }
        else
        {
            $('#anoModeloVeiculo').html('<option value="">-</option>');
        }
    })
    $(".caracteristicasVeiculo").keyup(function(event){
 
        // abaixo algumas variáveis que iremos utilizar.
 
        // pega a span onde esta a quantidade máxima de caracteres.
        var target    = $("#content-countdown");
 
        // pego pelo atributo title a quantidade maxima permitida.
        var max        = target.attr('title');
 
        // tamanho da string dentro da textarea.
        var len     = $(this).val().length;
 
        // quantidade de caracteres restantes dentro da textarea.
        var remain    = max - len;
 
        // caso a quantidade dentro da textarea seja maior que
        // a quantidade maxima.
        if(len > max)
        {
            // abaixo vamos pegar tudo que tiver na string e limitar
            // a quantidade de caracteres para o máximo setado.
            // isso significa que qualquer coisa que seja maior que
            // o máximo será cortado.
            var val = $(this).val();
            $(this).val(val.substr(0, max));
 
            // setamos o restante para 0.
            remain = 0;
        }
 
        // atualizamos a quantidade de caracteres restantes.
        target.html(remain);
 
    });
    if($(".caracteristicasVeiculo").val().length > 0)
    {
        _target = $("#content-countdown");
        _max = _target.attr('title');
        _restant = _max - $(".caracteristicasVeiculo").val().length;
        _target.html(_restant);
    }
    /*
	objValidadorCadastro = new xform('#dadosAnuncio');
	objValidadorCadastro . adicionar('#tipoVeiculo');
    objValidadorCadastro . adicionar('#marcaVeiculo');
    objValidadorCadastro . adicionar('#modeloVeiculo');
    objValidadorCadastro . adicionar('#anoFabricacaoVeiculo');
    objValidadorCadastro . adicionar('#combustivelVeiculo');
    objValidadorCadastro . adicionar('#placaVeiculo');
    objValidadorCadastro . adicionar('#corVeiculo');
    //objValidadorCadastro . adicionar('#caracteristicasVeiculo');
    objValidadorCadastro . adicionar('#valorVistaVeiculo');
    */
})
</script>

<body>
<div class="mestre">
    <?php require_once PROJECT_INC_PATH.'topo.php';?>
    <?php require_once PROJECT_INC_PATH.'menu.php';?>
    <div class="ofertabloco">
        <div class="centroinside">
            <div class="breadcrumb">
            <?
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
            ?>
                <a href="<?=$link;?>">Home</a>&nbsp; &gt; &nbsp;<span>Anuncie</span>&nbsp; &gt; &nbsp;<span>Dados do Anúncio</span>
            </div>
        </div>
    </div>
    <div class="centro">
    	<div class="centroinside">
            <div class="planobloco">
                <div class="anunciewrap">
                <?
                if($cod == '' && $codCliente == '')
                {
                ?>
                    <div class="anunciemenu">
                        <div class="anunciemenuitem anunciemenuhover" id="dados">
                            <a href="#">Dados do Anúncio</a>
                        </div>
                        <div class="anunciemenusepara">
                            <div class="menuseparaleft separalefthover"></div>
                            <div class="menusepararight"></div>
                            <div class="separalinha"></div>
                        </div>
                        <div class="anunciemenuitem" id="identificacao">
                            <a href="#">Identificação</a>
                        </div>
                        <div class="anunciemenusepara">
                            <div class="menuseparaleft"></div>
                            <div class="menusepararight"></div>
                            <div class="separalinha"></div>
                        </div>
                        <div class="anunciemenuitem" id="fotos">
                            <a href="#">Fotos</a>
                        </div>
                        <div class="anunciemenusepara">
                            <div class="menuseparaleft"></div>
                            <div class="menusepararight"></div>
                            <div class="separalinha"></div>
                        </div>
                        <div class="anunciemenuitem" id="finalizacao">
                            <a href="#">Finalização</a>
                        </div>
                    </div>
                   <?
                   }
                   else
                   {
                   ?> 
                    <div class="anunciemenu">
                        <div class="anunciemenuitem" id="editardados">
                        <?
                        if($cod != '')
                            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-dados/'.$cod : sslRedir().PROJECT_URL.'/anuncio-dado.php?cod='.$cod;
                        else
                            $link = '#';
                        ?>
                            <a href="<?=$link;?>">Dados do Veículo</a>
                        </div>
                        <div class="anunciemenusepara">
                            <div class="menuseparaleft"></div>
                            <div class="menusepararight separarighthover"></div>
                            <div class="separalinha"></div>
                        </div>
                        <div class="anunciemenuitem anunciemenuhover" id="editarfotos">
                        <?
                        if($cod != '')
                            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-fotos/'.$cod : sslRedir().PROJECT_URL.'/anuncio-fotos.php?cod='.$cod;
                        else
                            $link = '#';
                        ?>
                            <a href="<?=$link;?>">Fotos</a>
                        </div>
                    </div>
                    <?
                    }
                    ?>
                    <div class="anunciedadosbloco" id="dadosveiculo">
                    <?=$msg;?>
                        <form name="dadosAnuncio" id="dadosAnuncio" method="post" action="" enctype="multipart/form-data">
                            <div class="dadosveiculo">
                                <div class="formwrap">
                                
                                    <div class="inputbloco">
                                        <label class="composto" for="tipoVeiculo">Tipo de veiculo <span class="obrigatorio">*</span></label>
                                        <select class="selectgrande" name="tipoVeiculo" id="tipoVeiculo" title="Tipo de veiculo">
                                            <option value="">Selecione</option>
                                            <?php
                                                $conexao = conexao();
                                            	$qTipos = mysql_query("SELECT * FROM tipoVeiculo");
                                                $nTipos = mysql_num_rows($qTipos);
                                                for($x = 0;$x < $nTipos;$x++)
                                                {
                                                    $tpTipos = mysql_fetch_assoc($qTipos);
                                            ?>
                                                    <option value="<?=$tpTipos['cod'];?>" <?=$cod != '' && $tpTipos['cod'] == $tipoVeiculo ? 'selected="selected"' : '';?>><?=$tpTipos['tipoVeiculo'];?></option>
                                            <?php
                                            	}
                                                mysql_close();
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="inputbloco">
                                        <label for="marcaVeiculo">Marca <span class="obrigatorio">*</span></label>
                                        <span class="carregandoMarca" style="color:#666;display:none;">Aguarde, carregando...</span>
                                        <select class="selectgrande" name="marcaVeiculo" id="marcaVeiculo" title="Marca">
                                            <option value="">-</option>
                                            <?
                                            if($cod != '')
                                            {
                                                $conexao = conexao();
                                                $qMarcas = mysql_query("SELECT * FROM veiculosMarcas WHERE codTipoVeiculo = '$tipoVeiculo'");
                                                $nMarcas = mysql_num_rows($qMarcas);
												for($x = 0;$x < $nMarcas;$x++)
                                                {
                                                    $tpMarcas = mysql_fetch_assoc($qMarcas);
                                            	?>
                                                    <option value="<?=$tpMarcas['cod'];?>" <?=$tpMarcas['cod'] == $marca ? 'selected="selected"' : '';?>><?=$tpMarcas['marca'];?></option>
                                            	<?
													
                                                }
                                                mysql_close();
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="inputbloco">
                                        <label for="modeloVeiculo">Modelo <span class="obrigatorio">*</span></label>
                                        <span class="carregandoModelo" style="color:#666;display:none;">Aguarde, carregando...</span>
                                        <select class="selectgrande" name="modeloVeiculo" id="modeloVeiculo" title="Modelo">
                                            <option value="">-</option>
                                            <?
                                            if($cod != '')
                                            {
                                                $conexao = conexao();
                                                $qModelos = mysql_query("SELECT * FROM veiculosModelos WHERE codMarca = '$marca'");
                                                $nModelos = mysql_num_rows($qModelos);
                                                for($x = 0;$x < $nModelos;$x++)
                                                {
                                                    $tpModelos = mysql_fetch_assoc($qModelos);
                                            ?>
                                                    <option value="<?=$tpModelos['cod'];?>" <?=$tpModelos['cod'] == $modelo ? 'selected="selected"' : '';?>><?=$tpModelos['modelo'];?></option>
                                            <?
                                                }
                                                mysql_close();
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="inputbloco">
                                        <label for="versaoVeiculo">Versão </label>
                                        <span class="carregandoVersao" style="color:#666;display:none;">Aguarde, carregando...</span>
                                        <select class="selectgrande" name="versaoVeiculo" id="versaoVeiculo" title="Versão">
                                            <option value="">-</option>
                                            <?
                                            if($cod != '')
                                            {
                                                $conexao = conexao();
                                                $qVersoes = mysql_query("SELECT * FROM veiculosVersoes WHERE codModelo = '$modelo'");
                                                $nVersoes = mysql_num_rows($qVersoes);
                                                for($x = 0;$x < $nVersoes;$x++)
                                                {
                                                    $tpVersoes = mysql_fetch_assoc($qVersoes);
                                            ?>
                                                    <option value="<?=$tpVersoes['cod'];?>" <?=$tpVersoes['cod'] == $versao ? 'selected="selected"' : '';?>><?=$tpVersoes['versao'];?></option>
                                            <?
                                                }
                                                mysql_close();
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="inputbloco">
                                        <div class="inputleft">
                                            <label class="composto" for="anoFabricacaoVeiculo">Ano de Fabricação <span class="obrigatorio">*</span></label>
                                            <span class="carregandoAno" id="carregandoAnoFabricacao" style="color:#666;display:none;">Aguarde, carregando...</span>
                                            <select class="selectpequeno" name="anoFabricacaoVeiculo" id="anoFabricacaoVeiculo" title="Ano de Fabricação">
                                                <option value="">-</option>
                                                <?php
                                                $anosRange = range(date("Y"),1900);
                                                foreach($anosRange as $k => $ano)
                                                {
                                                    ?>
                                                    <option value="<?=$ano;?>" <?=$anoFabricacao == $ano ? 'selected="selected"' : '';?>><?=$ano;?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="inputright">
                                            <label class="composto" for="anoModeloVeiculo">Ano do Modelo</label>
                                            <span class="carregandoAno" id="carregandoAnoModelo" style="color:#666;display:none;">Aguarde, carregando...</span>
                                            <select class="selectpequeno" name="anoModeloVeiculo" id="anoModeloVeiculo" title="Ano do Modelo">
                                                <option value="">-</option>
                                                <?
                                                if($cod != '' && $anoFabricacao > 0)
                                                {
                                                    $anosRange = range($anoFabricacao,date("Y",strtotime("+1 Year")));
                                                    foreach($anosRange as $k => $ano)
                                                    {
                                                ?>
                                                        <option value="<?=$ano;?>" <?=$anoModelo == $ano ? 'selected="selected"' : '';?>><?=$ano;?></option>
                                                <?
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="inputbloco">
                                        <label for="placaVeiculo">Placa <span class="obrigatorio">*</span></label>
                                        <input type="text" class="inputgrande" name="placaVeiculo" id="placaVeiculo" maxlength="8" title="Placa" value="<?=$placa;?>" />
                                        <span>(EX.: <em>"xyz1234"</em>)</span>
                                    </div>
                                    <div class="inputbloco">
                                        <label for="corVeiculo">Cor <span class="obrigatorio">*</span></label>
                                        <select class="selectgrande" name="corVeiculo" id="corVeiculo" title="Cor" >
                                            <option value="Amarelo">Amarelo</option>
                                            <option value="Azul">Azul</option>
                                            <option value="Bege">Bege</option>
                                            <option value="Branco">Branco</option>
                                            <option value="Bronze">Bronze</option>
                                            <option value="Cinza">Cinza</option>
                                            <option value="Dourado">Dourado</option>
                                            <option value="Indefinida">Indefinida</option>
                                            <option value="Laranja">Laranja</option>
                                            <option value="Marrom">Marrom</option>
                                            <option value="Prata">Prata</option>
                                            <option value="Preto">Preto</option>
                                            <option value="Rosa">Rosa</option>
                                            <option value="Roxo">Roxo</option>
                                            <option value="Verde">Verde</option>
                                            <option value="Vermelho">Vermelho</option>
                                            <option value="Vinho">Vinho</option>
                                    	</select>
                                    </div>
                                    
                                    <div class="inputbloco">
                                        <label for="combustivelVeiculo">Combustível <span class="obrigatorio">*</span></label>
                                        <select class="selectgrande" name="combustivelVeiculo" id="combustivelVeiculo" title="Combustível" >
                                            <option value="" <?=$combustivel == '' || $combustivel == '0' ? 'selected="selected"' : '';?>>-</option>
                                            <option value="1" <?=$combustivel == '1' ? 'selected="selected"' : '';?>>Gasolina</option>
                                            <option value="2" <?=$combustivel == '2' ? 'selected="selected"' : '';?>>Álcool</option>
                                            <option value="3" <?=$combustivel == '3' ? 'selected="selected"' : '';?>>Flex</option>
                                            <option value="4" <?=$combustivel == '4' ? 'selected="selected"' : '';?>>Gás - GNV</option>
                                            <option value="5" <?=$combustivel == '5' ? 'selected="selected"' : '';?>>Diesel</option>
                                            <option value="6" <?=$combustivel == '6' ? 'selected="selected"' : '';?>>Biodiesel</option>
                                            <option value="7" <?=$combustivel == '7' ? 'selected="selected"' : '';?>>Eletricidade</option>
                                        </select>
                                    </div>
                                    
                                    <div class="inputbloco">
                                        <label for="kmVeiculo">Km</label>
                                        <input onkeypress="return verificaNumero (event)" type="text" class="inputgrande" name="kmVeiculo" id="kmVeiculo" title="Km"  value="<?=$km;?>" />
                                    </div>
                                    
                                    <div class="inputbloco">
                                        <label for="numPortasVeiculo">Nº de Portas</label>
                                        <input onkeypress="return verificaNumero (event)" type="text" class="inputgrande" name="numPortasVeiculo" id="numPortasVeiculo" title="Nº de Portas" value="<?=$nPortas;?>" />
                                    </div>
                                    
                                    <div class="inputbloco">
                                        <label for="valorVistaVeiculo">Valor à vista <span class="obrigatorio">*</span></label>
                                        <input type="text" class="inputgrande" name="valorVistaVeiculo" id="valorVistaVeiculo" title="Valor à vista" value="<?=number_format($valor,0,'','.');?>" />
                                    </div>
                                    
                                    <div class="inputbloco">
                                        <div class="inputleft">
                                            <label class="composto" for="quantParcelaVeiculo">Quantidade de Parcelas</label>
                                            <input onkeypress="return verificaNumero (event)" type="text" class="inputpequeno" name="quantParcelaVeiculo" id="quantParcelaVeiculo" title="Quantidade de Parcelas" value="<?=$nParcelas;?>" />
                                        </div>
                                        <div class="inputright">
                                            <label class="composto" for="valorParcelaVeiculo">Valor da Parcela</label>
                                            <input type="text" class="inputpequeno" name="valorParcelaVeiculo" id="valorParcelaVeiculo" title="Valor da Parcela" value="<?=number_format($valorParcela,0,'','.');?>"/>
                                        </div>
                                    </div>
                                    
                                    <div class="inputbloco">
                                        <label class="composto" for="valorEntradaVeiculo">Valor da Entrada</label>
                                        <input type="text" class="inputgrande" name="valorEntradaVeiculo" id="valorEntradaVeiculo" title="Valor da Entrada" value="<?=number_format($valorEntrada,0,'','.');?>" />
                                    </div>
                                    <?
                                    if($tipoAnuncio == '2')
                                    {
                                        $conexao = conexao();
                                        $sqlPlano = mysql_query("SELECT * FROM planosRevenda WHERE cod = $codPlanoRevenda");
                                        $tpPlano = mysql_fetch_assoc($sqlPlano);
                                        $numPlanoSuperHome = $tpPlano['superDestaqueHome'];
                                        $numPlanoHome = $tpPlano['destaqueHome'];
                                        $numPlanoSuperLista = $tpPlano['superDestaqueLista'];
                                        $numPlanoLista = $tpPlano['destaqueLista'];
                                        $sqlPlanosAnuncios = mysql_query("SELECT * FROM clientesAnuncios WHERE codCliente = '$codCliente'");
                                        $numPlanosAnuncios = mysql_num_rows($sqlPlanosAnuncios);
                                        $numPlanoSuperHomeCad = 0;
                                        $numPlanoHomeCad = 0;
                                        $numPlanoSuperListaCad = 0;
                                        $numPlanoListaCad = 0;
                                        for($x = 0;$x < $numPlanosAnuncios;$x++)
                                        {
                                            $tpPlanosAnuncios = mysql_fetch_assoc($sqlPlanosAnuncios);
                                            if($tpPlanosAnuncios['superDestaqueHome'] == '1')
                                                $numPlanoSuperHomeCad++;
                                            if($tpPlanosAnuncios['destaqueHome'] == '1')
                                                $numPlanoHomeCad++;
                                            if($tpPlanosAnuncios['superDestaqueLista'] == '1')
                                                $numPlanoSuperListaCad++;
                                            if($tpPlanosAnuncios['destaqueLista'] == '1')
                                                $numPlanoListaCad++;
                                        }
                                        mysql_close();
                                        if($numPlanoSuperHome != '0')
                                        {
                                    ?>
                                            <div class="inputbloco">
                                                <label class="composto" for="superDestaqueHome">Super Destaque Home </label>
                                                <input type="checkbox" name="superDestaqueHome" <?=$numPlanoSuperHomeCad >= $numPlanoSuperHome ? 'disabled="disabled"' : '';?> id="superDestaqueHome" title="Super Destaque Home" value="1" <?=$superDestaqueHome == '1' ? 'checked="checked"' : '';?>/>
                                                <?=$numPlanoSuperHomeCad >= $numPlanoSuperHome ? '<span class="anunciolegenda">Você já excedeu o limite de Super Destaque Home!</span>' : '';?>
                                            </div>
                                    <?
                                        }
                                        if($numPlanoHome != '0')
                                        {
                                    ?>    
                                            <div class="inputbloco">
                                                <label class="composto" for="destaqueHome">Destaque Home </label>
                                                <input type="checkbox" name="destaqueHome" <?=$numPlanoHomeCad >= $numPlanoHome ? 'disabled="disabled"' : '';?> id="destaqueHome" title="Destaque Home" value="1" <?=$destaqueHome == '1' ? 'checked="checked"' : '';?>/>
                                                <?=$numPlanoHomeCad >= $numPlanoHome ? '<span class="anunciolegenda">Você já excedeu o limite de Destaque Home!</span>' : '';?>
                                            </div>
                                    <?
                                        }
                                        if($numPlanoSuperLista != '0')
                                        {
                                    ?>
                                            <div class="inputbloco">
                                                <label class="composto" for="superDestaqueLista">Super Destaque Lista </label>
                                                <input type="checkbox" name="superDestaqueLista" <?=$numPlanoSuperListaCad >= $numPlanoSuperLista ? 'disabled="disabled"' : '';?> id="superDestaqueLista" title="Super Destaque Lista" value="1" <?=$superDestaqueLista == '1' ? 'checked="checked"' : '';?>/>
                                                <?=$numPlanoSuperListaCad >= $numPlanoSuperLista ? '<span class="anunciolegenda">Você já excedeu o limite de Super Destaque Lista!</span>' : '';?>
                                            </div>
                                    <?
                                        }
                                        if($numPlanoLista != '0')
                                        {
                                    ?>
                                            <div class="inputbloco">
                                                <label class="composto" for="destaqueLista">Destaque Lista </label>
                                                <input type="checkbox" name="destaqueLista" <?=$numPlanoListaCad >= $numPlanoLista ? 'disabled="disabled"' : '';?> id="destaqueLista" title="Destaque Lista" value="1" <?=$destaqueLista == '1' ? 'checked="checked"' : '';?>/>
                                                <?=$numPlanoListaCad >= $numPlanoLista ? '<span class="anunciolegenda">Você já excedeu o limite de Destaque Lista!</span>' : '';?>
                                            </div>
                                    <? 
                                        }  
                                    }
                                    ?>
                                    <div class="inputbloco">
                                        <label class="composto" for="caracteristicasVeiculo">Observações </label>
                                        <textarea name="caracteristicasVeiculo" id="caracteristicasVeiculo" class="caracteristicasVeiculo" title="Observações" rows="" cols=""><?=$caractVeiculo;?></textarea>                                        
                                        <span>
                                            Caracteres restantes
                                            <span id="content-countdown" title="160">160</span>
                                        </span>
                                    </div>
                                    <div class="inputbloco">
                                        <label class="composto" for="caracteristicasVeiculo">Acessórios do Veículo </label>
                                        <div class="caractbloco">    
                                            <table>
                                                <?php
                                                $conexao = conexao();
                                                $qAcessorios = mysql_query("SELECT * FROM acessorios ORDER BY acessorio ASC");
                                                $nAcessorios = mysql_num_rows($qAcessorios);
                                                $auxAcessorios = 0;
                                                for($a=0;$a<$nAcessorios;$a++)
                                                {
                                                    if($auxAcessorios == 0)
                                                    {
                                                        echo "<tr>";
                                                    }
                                                    $auxAcessorios++;
                                                    $tpAcessorios = mysql_fetch_assoc($qAcessorios);
                                                    if($cod != '')
                                                    {
                                                        $sqlVerificaAcessorios = mysql_query("SELECT * FROM acessoriosAnuncios WHERE codAnuncio = '$cod' AND codAcessorio = '{$tpAcessorios['cod']}'");
                                                        $numVerificaAcessorios = mysql_num_rows($sqlVerificaAcessorios);
                                                    }
                                                    else
                                                    {
                                                        $numVerificaAcessorios = 0;
                                                    }
                                                ?>
                                                    <td class="caractitem">
                                                        <table class="caractinput">
                                                            <tr>
                                                                <td>
                                                                    <input type="checkbox" <?=$numVerificaAcessorios > 0 ? 'checked="checked"' : '';?> id="acessorios" name="acessorios[]" value="<?=$tpAcessorios['cod'];?>" />
                                                                </td>
                                                                <td>
                                                                    <label><?=$tpAcessorios['acessorio'];?></label>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                <?php
                                                    if($auxAcessorios >= 3 || $a == ($nAcessorios-1))
                                                    {
                                                        $auxAcessorios = 0;
                                                        echo "</tr>";
                                                    }
                                                }
                                                mysql_close();
                                                ?>
                                            </table>
                                        </div>                                      
                                    </div>
                                    <div class="inputbloco" id="anunciotextmaior">
                                        <label for="valorEntradaVeiculo">&nbsp;</label>
                                        <span class="anunciolegenda">* Campos obrigatórios</span>
                                        <div class="anuncioenviar">
                                            <input type="submit" name="enviarDadosAnuncio" id="enviarDadosAnuncio" title="Avançar" value="Avançar" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    	</div>
    </div>
    <?php require_once PROJECT_INC_PATH.'rodapebloco.php';?>
</div>
</body>
</html>