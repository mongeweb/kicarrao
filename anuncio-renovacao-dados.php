<?php require_once 'configRoot.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php 
    require_once PROJECT_INC_PATH.'head.php';
    require_once PROJECT_FUNC_PATH.'enviarEmail.php';
    require_once ADMIN_FUNC_PATH.'validaCampo.php';
	?>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/validador1.4.js"></script>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/jquery.maskedinput.js"></script>
    <script src="<?=ssl().ADMIN_JS_URL;?>/jquery.maskMoney.js" type="text/javascript"></script>
</head>
<?
$_SESSION['boleto'] = 0;
$cod = isset($cod) ? $cod : '';
$cod = isset($_GET['cod']) ? $_GET['cod'] : $cod;
$codCliente = isset($_SESSION['codCliente']) ? $_SESSION['codCliente'] : '';
if(isset($_SESSION['renovacao']))
    unset($_SESSION['renovacao']);
$_SESSION['renovacao'] = array();

$link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';
$qAnunc = mysql_query("SELECT cod FROM clientesAnuncios WHERE codRenovacao = '$cod'");
$nAnunc = mysql_num_rows($qAnunc);
if($nAnunc > 0)
{
    printf("<script type='text/javascript'>
				alert('Anúncio já renovado!');
                document.location.replace('".$link."');
			</script>");
    die();
}

if($cod == '' || $codCliente == '' || $restrita != 1) 
{
    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';
    echo " <script>";
	echo "     location.replace('".$link."'); \n";
	echo " </script>";
    die();   
}

$submit = isset($_POST['enviarRenovacao']) ? $_POST['enviarRenovacao'] : '' ;
$msg = "";
if($submit != '')
{   
    $codAnuncioAntigo = isset($_POST['codAnuncio'])? $_POST['codAnuncio'] : "";
    $plano = isset($_POST['plano'])? $_POST['plano'] : "Bronze";
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
        $dataCadastro = date('Y-m-d');
        $sqlPlano = mysql_query("SELECT * FROM planosParticular WHERE plano = '{$plano}'");
        $tpPlano = mysql_fetch_assoc($sqlPlano);
        $destaqueHome = $tpPlano['destaqueCapa'];
        $destaqueLista = $tpPlano['destaqueLista'];
        $planoValor = $tpPlano['valor'];
        $codPlano = $tpPlano['cod'];
        $nDias = $tpPlano['tempo'];
        $nFotos = $tpPlano['nFotos'];
        $_SESSION['renovacao'] = array
        (
                "codAnuncioAntigo" => $codAnuncioAntigo,
                "tipoVeiculo" => $tipoVeiculo,
                "marca" => $marca,
                "modelo" => $modelo,
                "versao" => $versao,
                "placa" => $placa,
                "anoFabricacao" => $anoFabricacao,
                "anoModelo" => $anoModelo,
                "cor" => $cor,
                "combustivel" => $combustivel,
                "km" => $km,
                "nPortas" => $nPortas,
                "valor" => $valor,
                "nParcelas" => $nParcelas,
                "valorParcela" => $valorParcela,
                "valorEntrada" => $valorEntrada,
                "caractVeiculo" => $caractVeiculo,
                "plano" => $plano,
                "nFotos" => $nFotos,
                "planoValor" => $planoValor,
                "nDias" => $nDias,
                "codPlano" => $codPlano,
                "destaqueHome" => $destaqueHome,
                "superDestaqueHome" => $superDestaqueHome,
                "destaqueLista" => $destaqueLista,
                "superDestaqueLista" => $superDestaqueLista,
        );
        $sqlFotosInseridas = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$codAnuncioAntigo' AND tipo = '1' AND referencia = 'clientesAnuncios'");
        $numFotosInseridas = mysql_num_rows($sqlFotosInseridas);
        for($x=0;$x < $numFotosInseridas;$x++)
        {
            $tpFotosInseridas = mysql_fetch_assoc($sqlFotosInseridas);
            $_SESSION['renovacao']['fotos'][$tpFotosInseridas['codigo']] = array(
                                                                                    "arquivo" => $tpFotosInseridas['arquivo'],
                                                                                    "capa" => $tpFotosInseridas['capa'],
                                                                                );
        }
        
        foreach($acessorios as $k => $v)
        {
            $_SESSION['renovacao']['acessorios'][] = $v;
        }
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-renovacao-fotos' : sslRedir().PROJECT_URL.'/anuncio-renovacao-fotos.php' ;
        echo " <script>";
		echo " document.location.replace('".$link."'); \n";
		echo " </script>";
        die();
    }
}
else
{        
    $conexao = conexao();
    $sqlDadosAnuncio = mysql_query("SELECT * FROM clientesAnuncios WHERE codCliente = '$codCliente' AND cod = '$cod'");
    $numDadosAnuncio = mysql_num_rows($sqlDadosAnuncio);
    if($numDadosAnuncio > 0)
    {
        
        $tpDadosAnuncio = mysql_fetch_assoc($sqlDadosAnuncio);
        $plano = $tpDadosAnuncio['plano'];
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
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';
        echo " <script>";
    	echo "     location.replace('".$link."'); \n";
    	echo " </script>";
        die();
    }
    mysql_close();
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
	objValidadorCadastro = new xform('#dadosAnuncio');
    objValidadorCadastro . adicionar('#plano');
	objValidadorCadastro . adicionar('#tipoVeiculo');
    objValidadorCadastro . adicionar('#marcaVeiculo');
    objValidadorCadastro . adicionar('#modeloVeiculo');
    objValidadorCadastro . adicionar('#anoFabricacaoVeiculo');
    objValidadorCadastro . adicionar('#combustivelVeiculo');
    objValidadorCadastro . adicionar('#placaVeiculo');
    objValidadorCadastro . adicionar('#corVeiculo');
    //objValidadorCadastro . adicionar('#caracteristicasVeiculo');
    objValidadorCadastro . adicionar('#valorVistaVeiculo');
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
                    <div class="anunciedadosbloco" id="dadosveiculo">
                        <?=$msg;?>
                        <form name="dadosAnuncio" id="dadosAnuncio" method="post" action="" enctype="multipart/form-data">
                            <input type="hidden" name="codAnuncio" value="<?=$cod;?>" />
                            <div class="dadosveiculo">
                                <div class="formwrap">
                                    <div class="inputbloco">
                                        <label class="composto" for="plano">Plano <span class="obrigatorio">*</span></label>
                                        <select class="selectgrande" name="plano" id="plano" title="Plano">
                                            <option value="">Selecione</option>
                                            <?php
                                                $conexao = conexao();
                                                $qPlanos = mysql_query("SELECT * FROM planosParticular");
                                                $nPlanos = mysql_num_rows($qPlanos);
                                                for($x = 0;$x < $nPlanos;$x++)
                                                {
                                                    $tpPlano = mysql_fetch_assoc($qPlanos);
                                            ?>
                                                    <option value="<?=$tpPlano['plano'];?>" <?=$tpPlano['plano'] == $plano ? 'selected="selected"' : '';?>><?=$tpPlano['plano'];?></option>
                                            <?php
                                            	}
                                                mysql_close();
                                            ?>
                                        </select>
                                    </div>
                                
                                    
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
                                    <!--<div class="inputbloco">
                                        <label class="composto" for="caracteristicasVeiculo">Características do Veículo <span class="obrigatorio">*</span></label>
                                        <textarea name="caracteristicasVeiculo" id="caracteristicasVeiculo" title="Características do Veículo" rows="" cols=""><?=$caractVeiculo;?></textarea>                                        
                                    </div>-->
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
                                            <input type="submit" name="enviarRenovacao" id="enviarRenovacao" title="Avançar" value="Avançar" />
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