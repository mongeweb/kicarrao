<?php
if(!verifica_permissao($cod_user, $nivel_user, 'clientes'))
{
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Permissao negada!\");\n";
	echo " location.replace('principal.php'); \n";
	echo " //--> \n";
	echo " </script> \n";
	
	die();
}
require_once ADMIN_TOP_PATH."clientesAnuncios_topo.php";
require_once ADMIN_FUNC_PATH.'fotos.php';
$cod = isset($_GET['cod']) ? $_GET['cod'] : '';
$submit = isset($_POST['submit']) ? $_POST['submit'] : '' ;
$msg = "";
$md5 = new md5();
if($submit != '')
{        
    $tipoVeiculo = isset($_POST['tipoVeiculo'])? escape($_POST['tipoVeiculo']) : '';
    $cliente = isset($_POST['codCliente'])? escape($_POST['codCliente']) : '';
    $marca = isset($_POST['marca'])? escape($_POST['marca']) : '';
    $modelo = isset($_POST['modelo'])? escape($_POST['modelo']) : '';
    $versao = isset($_POST['versao'])? escape($_POST['versao']) : '';
    $placa = isset($_POST['placa'])? escape($_POST['placa']) : '';
    $anoFabricacao = isset($_POST['anoFabricacao'])? escape($_POST['anoFabricacao']) : '';
    $anoModelo = isset($_POST['anoModelo'])? escape($_POST['anoModelo']) : '';
    $cor = isset($_POST['cor'])? escape($_POST['cor']) : '';
    $combustivel = isset($_POST['combustivel'])? escape($_POST['combustivel']) : '';
    $km = isset($_POST['km'])? escape($_POST['km']) : '';
    $nPortas = isset($_POST['nPortas'])? escape($_POST['nPortas']) : '';
    $valor = isset($_POST['valor'])? (int)str_replace('.','',$_POST['valor']) : '';
    $nParcelas = isset($_POST['nParcelas'])? escape($_POST['nParcelas']) : '';
    $valorParcela = isset($_POST['valorParcela'])? (int)str_replace('.','',$_POST['valorParcela']) : '';
    $valorEntrada = isset($_POST['valorEntrada'])? (int)str_replace('.','',$_POST['valorEntrada']) : '';
    $caractVeiculo = isset($_POST['caractVeiculo'])? escape($_POST['caractVeiculo']) : '';
    $dataValidadeAnuncio = isset($_POST['dataValidadeAnuncio'])? $_POST['dataValidadeAnuncio'] : '';
    $nFotos = isset($_POST['nFotos'])? escape($_POST['nFotos']) : '';
    $status = isset($_POST['status'])? escape($_POST['status']) : 0;
    $superDestaqueHome = isset($_POST['superDestaqueHome'])? $_POST['superDestaqueHome'] : 0;
    $destaqueHome = isset($_POST['destaqueHome'])? $_POST['destaqueHome'] : 0;
    $superDestaqueLista = isset($_POST['superDestaqueLista'])? $_POST['superDestaqueLista'] : 0;
    $destaqueLista = isset($_POST['destaqueLista'])? $_POST['destaqueLista'] : 0;
    //$video = isset($_POST['video'])? escape($_POST['video']) : '';
    //$linkVideo = isset($_POST['linkVideo'])? htmlspecialchars($_POST['linkVideo']) : '';
    //$mapa = isset($_POST['mapa'])? escape($_POST['mapa']) : '';
    //$linkMapa = isset($_POST['linkMapa'])? htmlspecialchars($_POST['linkMapa']) : '';
    $plano = isset($_POST['plano'])? htmlspecialchars($_POST['plano']) : '';
    $tipoAnuncio = isset($_POST['tipoAnuncio']) ? $_POST['tipoAnuncio'] : '1';
    $acessorios = isset($_POST['acessorios']) ? $_POST['acessorios'] : array();
    
    $erro = 0;
    
    $msg .= '<ul style="color:red; size:10px;font-style:italic;">';
    if (!validaCampo($tipoVeiculo))
    {
        $msg .= '<li>O campo Tipo de veiculo deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($valor))
    {
        $msg .= '<li>O campo Preço deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    $numfotos = count($_FILES['file']['name']);
	for ($x = 0;$x < $numfotos; $x++)
	{
		 $foto = $_FILES['file']['name'][$x];
		 if($foto != '')
		 {
		
			 $formato = $_FILES['file']['name'][$x];
			 $formato = strrev($formato);
			 $formato = explode('.',$formato);
			 $formato = $formato[0];
			 $formato = strrev($formato);
             $formato = strtolower($formato);
		 }
		 $extensoesvalidas = array("jpg","jpeg","png");
		
		 if($foto != '' && !in_array($formato,$extensoesvalidas))
		 {
			$msg .= '<li>Formato de arquivo inválido!</li>';
			$erro = 1;
			break;
		 }
	}
   /* if($video == '1')
    {
        if (!validaCampo($linkVideo))
        {
            $msg .= '<li>O campo Link do vídeo deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
    }
    
    if($mapa == '1')
    {
        if (!validaCampo($linkMapa))
        {
            $msg .= '<li>O campo Link do mapa deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
    }*/
    
    $msg .= '</ul>';
    
    if($erro == 0)
    {
        
        $rn = count(isset($_POST['apagarArquivos']) ? $_POST['apagarArquivos'] : array());
		if ($rn > 0)
		{
		    for ($ab = 0;$ab < $rn;$ab++)
			{
				$exclusoes = isset($_POST['apagarArquivos'][$ab]) ? $_POST['apagarArquivos'][$ab] : '' ;
				if ($exclusoes !="") 
				{	
					$objsArquivo = mysql_query("SELECT arquivo FROM arquivos WHERE codigo ='$exclusoes' AND referencia = 'clientesAnuncios' AND codReferencia = '{$cod}'");
					$qtdObjsArquivo = mysql_num_rows($objsArquivo);
					
					for ($j = 0; $j < $qtdObjsArquivo; $j++)
					{
						$exc = mysql_fetch_assoc($objsArquivo);
						unlink(PROJECT_PATH."arquivos/clientesAnuncios/".$exc['arquivo']);
					}
					$sql_apaga = "DELETE FROM arquivos WHERE codigo = '$exclusoes' AND referencia = 'clientesAnuncios' AND codReferencia = '{$cod}'";
					$resultadoapaga = mysql_query($sql_apaga);
                    
                    $sqlSelectCapa = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$cod' AND referencia = 'clientesAnuncios' AND capa = '1'");
					$linhasSelectCapa = mysql_num_rows($sqlSelectCapa);
					
					if($linhasSelectCapa == 0)
					{
						$sqlMarcaCapa = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$cod' AND referencia = 'clientesAnuncios' AND capa = '0' LIMIT 1");
						$tpMarcaCapa = mysql_fetch_assoc($sqlMarcaCapa);
						$sqlUpCapa = "UPDATE arquivos SET
                                capa = '1'
                                WHERE codReferencia = '$cod' AND codigo = '{$tpMarcaCapa['codigo']}' AND referencia = 'clientesAnuncios'";
    	            	$resultadoUpCapa = mysql_query($sqlUpCapa);
					}
				}
			}
		}
        if($numfotos > 0)
        {
            $sqlDestaque = "UPDATE arquivos SET
    					capa = '0'
    					WHERE codReferencia = '$cod' AND referencia = 'clientesAnuncios'";
    		$resultadoDestaque = mysql_query($sqlDestaque);
    		
    		for ($i = 0; $i < $numfotos; $i++)
    		{
    			$destaque = isset($_POST['destaque'][$i]) ? $_POST['destaque'][$i] : '' ;
    
    			$sqlDestaque = "UPDATE arquivos SET
    						capa = '1'
    						WHERE codReferencia = '$cod' AND codigo = '$destaque' AND referencia = 'clientesAnuncios'";
    			$resultadoDestaque = mysql_query($sqlDestaque);
    		}
        }
        for ($x = 0;$x < $numfotos; $x++)
        {
            $foto = isset($_FILES['file']['name'][$x]) ? $_FILES['file']['name'][$x] : '';
            if($foto != '')
            {
                $foto_temp = isset($_FILES['file']['tmp_name'][$x]) ? $_FILES['file']['tmp_name'][$x] : '';
                $sqlVerificaCapa = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$cod' AND tipo = '1' AND referencia = 'clientesAnuncios' AND capa = '1'");
                $numVerificaCapa = mysql_num_rows($sqlVerificaCapa);
                $capa = $x == 0 && $numVerificaCapa == 0 ? 1 : 0;
                $token = date('dmYHis').rand(1,99999);
                $pasta = PROJECT_PATH."arquivos/clientesAnuncios";
                
                $fileG = insere_foto($foto, $foto_temp, $pasta,'800','600');
        		$sqlG = "INSERT INTO arquivos (referencia, codReferencia,tipo, arquivo, codigo, capa)
                        VALUES ('clientesAnuncios', '{$cod}','3', '{$fileG}','$token', '$capa')";
        		$resultadoG = mysql_query($sqlG);
                
                $fileM = insere_foto($foto, $foto_temp, $pasta,'465','349');
        		$sqlM = "INSERT INTO arquivos (referencia, codReferencia,tipo, arquivo, codigo, capa)
                        VALUES ('clientesAnuncios', '{$cod}','2', '{$fileM}','$token', '$capa')";
        		$resultadoM = mysql_query($sqlM);
                
                $fileP = insere_foto($foto, $foto_temp, $pasta,'158','116');
        		$sqlP = "INSERT INTO arquivos (referencia, codReferencia,tipo, arquivo, codigo, capa)
                        VALUES ('clientesAnuncios', '{$cod}','1', '{$fileP}','$token', '$capa')";
        		$resultadoP = mysql_query($sqlP);
            }
        }
        $dataValidadeAnuncio = dataEn($dataValidadeAnuncio);
        if($tipoAnuncio == '1')
        {
            $auxUpdate = '';
            if($status == '1')
            {
                $sqlVerificaAprovado = mysql_query("SELECT aprovado, nDias, codRenovacao FROM clientesAnuncios WHERE cod = {$cod}");
                $tpVerificaAprovado = mysql_fetch_assoc($sqlVerificaAprovado);
                if($tpVerificaAprovado['aprovado'] < 1)
                {
                    if($tpVerificaAprovado['codRenovacao'] > 0)
                    {
                        $sqlAnuncioAntigo = mysql_query("SELECT dataValidadeAnuncio FROM clientesAnuncios WHERE cod = '{$tpVerificaAprovado['codRenovacao']}'");
                        $tpAnuncioAntigo = mysql_fetch_assoc($sqlAnuncioAntigo);
                        $dataValidade = $tpAnuncioAntigo['dataValidadeAnuncio'];
                        $timeValidade = strtotime($dataValidade);
                        $time = $timeValidade-time();
                        $diasTot = (int)floor($time/86400);
                        $diasTot = $diasTot > 0 ? $diasTot : 0;
                        
                        
                        $validadeAnuncio = date('Y-m-d', strtotime("+".($tpVerificaAprovado['nDias']+$diasTot)." days"));
                        $dataValidadeAnuncio = $validadeAnuncio;
                        $sql = mysql_query("UPDATE clientesAnuncios SET
                                status = '3'
                                WHERE cod = {$tpVerificaAprovado['codRenovacao']}");
                    }
                    else
                    {
                        $dataValidadeAnuncio = date('Y-m-d', strtotime("+".$tpVerificaAprovado['nDias']." days"));
                    }
                    
                    $dataLiberacaoAnuncio = date('Y-m-d');
                    $auxUpdate = " dataLiberacaoAnuncio = '{$dataLiberacaoAnuncio}', aprovado = 1, ";
                      
                }
            }
            
            $sql = "UPDATE clientesAnuncios SET $auxUpdate
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
                    valorParcela = '{$valorParcela}',
                    valorEntrada = '{$valorEntrada}',
                    caractVeiculo = '{$caractVeiculo}',
                    dataValidadeAnuncio = '{$dataValidadeAnuncio}',
                    nFotos = '{$nFotos}',
                    status = '{$status}'
                    WHERE cod = {$cod}";
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
                    valorParcela = '{$valorParcela}',
                    valorEntrada = '{$valorEntrada}',
                    caractVeiculo = '{$caractVeiculo}',
                    dataValidadeAnuncio = '{$dataValidadeAnuncio}',
                    destaqueHome = '{$destaqueHome}',
                    superDestaqueHome = '{$superDestaqueHome}',
                    destaqueLista = '{$destaqueLista}',
                    superDestaqueLista = '{$superDestaqueLista}',
                    nFotos = '{$nFotos}',
                    status = '{$status}'
                    WHERE cod = {$cod}";
        }		
    	
        $resultado = mysql_query($sql);
        if($resultado)
        {
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
            if($status == '1')
            {
                $sqlVerificaAprovado = mysql_query("SELECT aprovado FROM clientesAnuncios WHERE cod = {$cod}");
                $tpVerificaAprovado = mysql_fetch_assoc($sqlVerificaAprovado);
                if($tpVerificaAprovado['aprovado'] < 1)
                {
                    require_once PROJECT_FUNC_PATH.'cadastroEmail.php';
                    $sqlEmailCliente = mysql_query("SELECT email FROM clientes WHERE cod = '$cliente'");
                    $tpEmailCliente = mysql_fetch_assoc($sqlEmailCliente);
                    $nomeRemetente = "Kicarrão";
                    $assunto = "Anúncio Aprovado - Kicarrão";
                    $conteudoEmail = array
                                     (
                                        'codCliente'    => $cliente,
                                        'codAnuncio'    => $cod
                                     );
                    
                    $emailDestinatario = array($tpEmailCliente['email']);//array($email);
                    $emailRemetente = $emailResposta  = 'noreply@kicarrao.com.br';
                    $twitter = '';
                    $facebook = 'kicarrao';
                    
                    for($a=0;$a<5;$a++)
                    {
                        $conf = confirmacaoAnuncio($emailRemetente, $emailDestinatario, $emailResposta, $assunto, $nomeRemetente, $conteudoEmail, $twitter, $facebook);		
                        if($conf)
                        {
                            break;
                        }
                    }
                }
            }
            echo " <script>";
    		echo " alert(\"Cadastro realizado com sucesso!\");\n";
            if(isset($_GET['redir']) && $_GET['redir'] == "pagamentos")
            {
   		       echo " location.replace('http://".ADMIN_URL."/principal.php?id=15&subid=1'); \n";
            }
            else
            {
                echo " location.replace('http://".ADMIN_URL."/principal.php?id=10&subid=1'); \n";
            }
    		echo " </script>";
            die();
    	}
        else
    	{
            echo " <script>";
    		echo " alert(\"Erro ao cadastrar!\");\n";
    		echo " location.replace('http://".ADMIN_URL."/principal.php?id=10&subid=1'); \n";
    		echo " </script>";
            die();
    	}
    }
}
else
{        
    $sqlAnuncios = mysql_query("SELECT * FROM clientesAnuncios WHERE cod = '$cod'");
    $tpAnuncios = mysql_fetch_assoc($sqlAnuncios);
    
    $cliente = $tpAnuncios['codCliente'];
    $tipoVeiculo = $tpAnuncios['tipoVeiculo'];
    $marca = $tpAnuncios['marca'];
    $modelo = $tpAnuncios['modelo'];
    $versao = $tpAnuncios['versao'];
    $placa = $tpAnuncios['placa'];
    $anoFabricacao = $tpAnuncios['anoFabricacao'];
    $anoModelo = $tpAnuncios['anoModelo'];
    $cor = $tpAnuncios['cor'];
    $combustivel = $tpAnuncios['combustivel'];
    $km = $tpAnuncios['km'];
    $nPortas = $tpAnuncios['nPortas'];
    $valor = $tpAnuncios['valor'];
    $nParcelas = $tpAnuncios['nParcelas'];
    $valorParcela = $tpAnuncios['valorParcela'];
    $valorEntrada = $tpAnuncios['valorEntrada'];
    $caractVeiculo = $tpAnuncios['caractVeiculo'];
    $dataValidadeAnuncio = dataBr($tpAnuncios['dataValidadeAnuncio']);
    $nFotos = $tpAnuncios['nFotos'];
    $status = $tpAnuncios['status'];
    $superDestaqueHome = $tpAnuncios['superDestaqueHome'];
    $destaqueHome = $tpAnuncios['destaqueHome'];
    $superDestaqueLista = $tpAnuncios['superDestaqueLista'];
    $destaqueLista = $tpAnuncios['destaqueLista'];
    /*$video = $tpAnuncios['video'];
    $linkVideo = $tpAnuncios['linkVideo'];
    $mapa = $tpAnuncios['mapa'];
    $linkMapa = $tpAnuncios['linkMapa'];*/
    $plano = $tpAnuncios['plano'];
    
    
}
$sqlClientes = mysql_query("SELECT * FROM clientes WHERE cod = '$cliente'");
$tpClientes = mysql_fetch_assoc($sqlClientes);

$nomeCliente = $tpClientes['razaoSocialNome'];
$sobrenomeCliente = $tpClientes['sobrenome'];
$tipoAnuncio = $tpClientes['tipoAnuncio'];
$tipoRevenda = $tpClientes['tipoRevenda'];
$codPlanoRevenda = $tpClientes['codPlanoRevenda'];
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
$(document).ready(function()
{
    $("input#valor").maskMoney({showSymbol:true, symbol:"R$ ", decimal:"", thousands:".", precision: false, defaultZero: false});
    $("input#valorParcela").maskMoney({showSymbol:true, symbol:"R$ ", decimal:"", thousands:".", precision: false, defaultZero: false});
    $("input#valorEntrada").maskMoney({showSymbol:true, symbol:"R$ ", decimal:"", thousands:".", precision: false, defaultZero: false});
    $('#dataValidadeAnuncio').mask('99/99/9999');
    objValidador = new xform('form#cadastro');
    objValidador.adicionar('select#tipoVeiculo');
    objValidador.adicionar('input#valor');
    <?
    if($status == 0)
    {
    ?>
        $('.dataDeValidade').hide();
    <?
    }
    ?>
    /*$('#video').click(function(){
        
        obj = $(this);
        _video = obj.is(':checked') ? '1' : '0';
        if(_video == '1')
        {
            $('.video').show();
            objValidador.adicionar('input#linkVideo');
        }
        else
        {
            $('.video').hide();
            objValidador.remover('input#linkVideo');
        }
    })
    
    $('#mapa').click(function(){
        
        obj = $(this);
        _mapa = obj.is(':checked') ? '1' : '0';
        if(_mapa == '1')
        {
            $('.mapa').show();
            objValidador.adicionar('input#linkMapa');
        }
        else
        {
            $('.mapa').hide();
            objValidador.remover('input#linkMapa');
        }
    })
    if($('#mapa').is(':checked'))
    {
        $('.mapa').show();
        objValidador.adicionar('input#linkMapa');
    }
    else
    {
        $('.mapa').hide();
        objValidador.remover('input#linkMapa');
    }
    
    if($('#video').is(':checked'))
    {
        $('.video').show();
        objValidador.adicionar('input#linkVideo');
    }
    else
    {
        $('.video').hide();
        objValidador.remover('input#linkVideo');
    }*/
    
    $('#marca').change(function()
    {
        if($(this).val())
        {
            $('#modelo').hide();
            $('.carregando').show();
            
            $.ajax(
            {
                type: "POST",
                url: "ajax/ajaxModelo.php",
                data:
                {
                    cod: $(this).val()
                
                },
                dataType: "json", 
                success: function(j)
                { 
                    var options = '<option value="">Selecione</option>';	
                    for (var i = 0; i < j.length; i++) 
                    {
                        options += '<option value="' + j[i].cod + '">' + j[i].modelo + '</option>';
                    }	
                    $('#modelo').html(options).show();
                    $('.carregando').hide();
                }
            });              
        }
        else
        {
            $('#modelo').html('<option value="">Selecione</option>');
        }
    })
    
    $('#modelo').change(function()
    {
        if($(this).val())
        {
            $('#versao').hide();
            $('.carregando').show();
            
            $.ajax(
            {
                type: "POST",
                url: "ajax/ajaxVersao.php",
                data:
                {
                    cod: $(this).val()
                
                },
                dataType: "json", 
                success: function(j)
                { 
                    var options = '<option value="">Selecione</option>';	
                    for (var i = 0; i < j.length; i++) 
                    {
                        options += '<option value="' + j[i].cod + '">' + j[i].versao + '</option>';
                    }	
                    $('#versao').html(options).show();
                    $('.carregando').hide();
                }
            });              
        }
        else
        {
            $('#versao').html('<option value="">Selecione</option>');
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
});
</script>
	
<div id="contentFormNovoEdita" style="width: 100%;">
    <form name="cadastro" id="cadastro" method="post" action="" enctype="multipart/form-data">
    <fieldset>
        <legend>Editar Anúncio</legend>
        <div><?=$msg;?></div>
        <div>
            <label for="cliente">Cliente: </label>
            <span><?=$nomeCliente;?> &nbsp; <?=$sobrenomeCliente;?></span>
            <input type="hidden" name="codCliente" id="codCliente" value="<?=$cliente;?>" />
            <input type="hidden" name="tipoAnuncio" id="tipoAnuncio" value="<?=$tipoAnuncio;?>" />
        </div>
        <div>
            <label for="tipoVeiculo">Tipo de veiculo: </label>
            <select name="tipoVeiculo" id="tipoVeiculo" title="Tipo de veiculo">
                <option value="">Selecione</option>
                <?php
                	$qTipos = mysql_query("SELECT * FROM tipoVeiculo");
                    $nTipos = mysql_num_rows($qTipos);
                    for($x = 0;$x < $nTipos;$x++)
                    {
                        $tpTipos = mysql_fetch_assoc($qTipos);
                ?>
                        <option value="<?=$tpTipos['cod'];?>" <?=$cod != '' && $tpTipos['cod'] == $tipoVeiculo ? 'selected="selected"' : '';?>><?=$tpTipos['tipoVeiculo'];?></option>
                <?php
                	}
                ?>
            </select>
        </div>
        <div>
            <label for="marca">Marca: </label>
            <select name="marca" id="marca" title="Marca">
                <option value="">Selecione</option>
                <?php
                	$sqlMarcas = mysql_query("SELECT * FROM veiculosMarcas ORDER BY marca");
                    $numMarcas = mysql_num_rows($sqlMarcas);
                    for($x = 0;$x < $numMarcas;$x++)
                    {
                        $tpMarcas = mysql_fetch_assoc($sqlMarcas);
                ?>
                        <option value="<?=$tpMarcas['cod'];?>" <?=$tpMarcas['cod'] == $marca ? "selected = 'selected'" : "";?>><?=$tpMarcas['marca'];?></option>
                <?php
                	}
                ?>
            </select>
        </div>
        <div>
            <label for="modelo">Modelos: </label>
            <span class="carregando" style="color:#666;display:none;">Aguarde, carregando...</span>
            <select name="modelo" id="modelo" title="Modelos">
                <option value="">Selecione</option>
                <?php
                	$sqlModelos = mysql_query("SELECT * FROM veiculosModelos WHERE codMarca = '$marca' ORDER BY modelo");
                    $numModelos = mysql_num_rows($sqlModelos);
                    for($x = 0;$x < $numModelos;$x++)
                    {
                        $tpModelos = mysql_fetch_assoc($sqlModelos);
                ?>
                        <option value="<?=$tpModelos['cod'];?>" <?=$tpModelos['cod'] == $modelo ? "selected = 'selected'" : "";?>><?=$tpModelos['modelo'];?></option>
                <?php
                	}
                ?>
            </select>
        </div>
        <div>
            <label for="versao">Versões: </label>
            <span class="carregando" style="color:#666;display:none;">Aguarde, carregando...</span>
            <select name="versao" id="versao" title="Versões">
                <option value="">Selecione</option>
                <?php
                	$sqlVersao = mysql_query("SELECT * FROM veiculosVersoes WHERE codModelo = '$modelo' ORDER BY versao");
                    $numVersao = mysql_num_rows($sqlVersao);
                    for($x = 0;$x < $numVersao;$x++)
                    {
                        $tpVersao = mysql_fetch_assoc($sqlVersao);
                ?>
                        <option value="<?=$tpVersao['cod'];?>" <?=$tpVersao['cod'] == $versao ? "selected = 'selected'" : "";?>><?=$tpVersao['versao'];?></option>
                <?php
                	}
                ?>
            </select>
        </div>
        <div>
            <label for="placa">Placa: </label>
            <input type="text" name="placa" id="placa" title="Placa" value="<?=$placa;?>" />
        </div>
        <div>
            <label for="anoFabricacao">Ano fabricação: </label>
            <input type="text" name="anoFabricacao" id="anoFabricacao" title="Ano fabricação" value="<?=$anoFabricacao;?>" />
        </div>
        <div>
            <label for="anoModelo">Ano modelo: </label>
            <input type="text" name="anoModelo" id="anoModelo" title="Ano modelo" value="<?=$anoModelo;?>" />
        </div>
        <div>
            <label for="cor">Cor: </label>
            <input type="text" name="cor" id="cor" title="Cor" value="<?=$cor;?>" />
        </div>
        <div>
            <label for="combustivel">Combustível: </label>
            <input type="text" name="combustivel" id="combustivel" title="Combustível" value="<?=$combustivel;?>" />
        </div>
        <div>
            <label for="km">Km: </label>
            <input onkeypress="return verificaNumero (event)" type="text" name="km" id="km" title="Km" value="<?=$km;?>"  />
        </div>
        <div>
            <label for="nPortas">Número de portas: </label>
            <input onkeypress="return verificaNumero (event)" type="text" name="nPortas" id="nPortas" title="Número de portas" value="<?=$nPortas;?>"  />
        </div>
        <div>
            <label for="valor"><span class="obrigatorio">*</span> Preço: </label><input type="text" name="valor" id="valor" title="Preço" value="<?=number_format($valor,0,'','.');?>" />
        </div>
        <div>
            <label for="nParcelas">Número de parcelas: </label>
            <input onkeypress="return verificaNumero (event)" type="text" name="nParcelas" id="nParcelas" title="Número de parcelas" value="<?=$nParcelas;?>"  />
        </div>
        <div>
            <label for="valorParcela">Valor parcela: </label>
            <input type="text" name="valorParcela" id="valorParcela" title="Valor parcela" value="<?=number_format($valorParcela,0,'','.');?>" />
        </div>
        <div>
            <label for="valorEntrada">Valor Entrada: </label>
            <input type="text" name="valorEntrada" id="valorEntrada" title="Valor Entrada" value="<?=number_format($valorEntrada,0,'','.');?>" />
        </div>
        <div>
            <label for="caractVeiculo">Observações: </label>
            <textarea name="caractVeiculo" class="caracteristicasVeiculo" id="caractVeiculo" title="Observações"><?=$caractVeiculo;?></textarea>
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
                    ?>
                </table>
            </div>                                      
        </div>
        <div class="dataDeValidade">
            <label for="dataValidadeAnuncio">Validade do anúncio: </label>
            <input type="text" name="dataValidadeAnuncio" id="dataValidadeAnuncio" title="Validade do anúncio" value="<?=$dataValidadeAnuncio;?>"  />
        </div>
        <?
        if($tipoAnuncio == '2')
        {
            $sqlPlano = mysql_query("SELECT * FROM planosRevenda WHERE cod = $codPlanoRevenda");
            $tpPlano = mysql_fetch_assoc($sqlPlano);
            $numPlanoSuperHome = $tpPlano['superDestaqueHome'];
            $numPlanoHome = $tpPlano['destaqueHome'];
            $numPlanoSuperLista = $tpPlano['superDestaqueLista'];
            $numPlanoLista = $tpPlano['destaqueLista'];
            $sqlPlanosAnuncios = mysql_query("SELECT * FROM clientesAnuncios WHERE codCliente = '$cliente'");
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
        <div>
            <label for="nFotos">Número de fotos: </label>
            <input onkeypress="return verificaNumero (event)" type="text" name="nFotos" id="nFotos" title="Número de fotos" value="<?=$nFotos;?>"  />
        </div>
        <div>
            <label for="nFotos">Status: </label>
            <input type="radio" name="status" id="status" title="Status" value="0" <?=$status == 0 ? "checked='true'" : '';?> /><span>Aguardando</span>
            <input type="radio" name="status" id="status" title="Status" value="1" <?=$status == 1 || $status == 3 ? "checked='true'" : '';?> /><span>Ativo</span>
            <input type="radio" name="status" id="status" title="Status" value="2" <?=$status == 2 ? "checked='true'" : '';?> /><span>Cancelado</span>
        </div>
        <!--<div>
            <label for="video">Vídeo: </label>
            <input type="checkbox" name="video" id="video" value="1" title="Vídeo" < ?=$video == '1' ? 'checked="checked"' : '';?> />
        </div>
        <div class="video" style="display: none;">
            <label for="linkVideo">Link do vídeo: </label>
            <input type="text" name="linkVideo" id="linkVideo" title="Link do vídeo" value="< ?=$linkVideo;?>"  />
        </div>
        <div>
            <label for="mapa">Mapa: </label>
            <input type="checkbox" name="mapa" id="mapa" value="1" title="Mapa" < ?=$mapa == '1' ? 'checked="checked"' : '';?> />
        </div>
        <div class="mapa" style="display: none;">
            <label for="linkMapa">Link do mapa: </label>
            <input type="text" name="linkMapa" id="linkMapa" title="Link do mapa" value="< ?=$linkMapa;?>"  />
        </div>-->
        <input type="hidden" name="plano" id="plano" value="<?=$plano;?>" />
        <?
        if($tipoAnuncio == '1' && $tipoRevenda == '0')
        {
            $sqlPlano = mysql_query("SELECT * FROM planosParticular WHERE plano = '$plano'");
            $tpPlano = mysql_fetch_assoc($sqlPlano); 
        ?>
            <fieldset style="margin-top: 15px;">
                <legend>Dados do Plano - <?=$plano;?></legend>
                <div>
                    <label for="">Nome do plano: </label>
                    <span><?=$tpPlano['plano'];?></span>
                </div>
                <div>
                    <label for="">Tempo de veiculação: </label>
                    <span><?=$tpPlano['tempo'];?> dias</span>
                </div>
                <div>
                    <label for="">Destaque na capa do site: </label>
                    <span><?=$tpPlano['destaqueCapa'] == '1' ? "Sim" : "Não";?></span>
                </div>
                <div>
                    <label for="">Destaque na lista de resultado: </label>
                    <span><?=$tpPlano['destaqueLista'] == '1' ? "Sim" : "Não";?></span>
                </div>
                <div>
                    <label for="">Número de fotos: </label>
                    <span><?=$tpPlano['nFotos'];?></span>
                </div>
               <!-- <div>
                    <label for="">Vídeo: </label>
                    <span>< ?=$tpPlano['video'] == '1' ? "Sim" : "Não";?></span>
                </div>
                <div>
                    <label for="">Mapa de endereço do anúncio: </label>
                    <span>< ?=$tpPlano['mapa'] == '1' ? "Sim" : "Não";?></span>
                </div>-->
                <div>
                    <label for="">Valor: </label>
                    <span>R$ <?=number_format((float)$tpPlano['valor'],2,',','.');?></span>
                </div>
            </fieldset>
        <?
        }
        ?>
        <fieldset style="margin-top: 15px;">
            <legend>Fotos</legend>
        <?php
        $qFotos = mysql_query("SELECT * FROM arquivos WHERE codReferencia='$cod' AND tipo = '2' AND referencia = 'clientesAnuncios' ORDER BY cod ASC");
        $nFotos = mysql_num_rows($qFotos);
        if ($nFotos > 0)
        {
            for ($d = 0; $d < $nFotos; $d++)
            {
                $tpFotos = mysql_fetch_assoc($qFotos);
        ?>
                <div class="contentEditor" style="margin-left: -10px;">
                    <label>Foto <?=($d + 1);?>: </label>
                    <img style="width:250px" src="http://<?=PROJECT_URL.'/arquivos/clientesAnuncios/'.remEscape($tpFotos['arquivo']);?>" title="<?=remEscape($tpFotos['legenda']);?>" />
                </div>
                <div>
                    <label>Apagar Foto <?=($d + 1);?>: </label>
                    <input type="checkbox" name="apagarArquivos[]" title="Apagar Foto" value="<?=$tpFotos['codigo'];?>" />
                </div>
                <div>
                    <label>Destaque Foto <?=($d + 1);?>: </label>
                    <input type="radio" id="destaque<?=$ab;?>" <?=$tpFotos['capa'] > 0 ? "checked='true'" : '' ;?> name="destaque[]" title="Foto Destaque" value="<?=$tpFotos['codigo'];?>" />
                </div>
        <?php
            }
        }
        else
        {
            echo "Nenhuma foto cadastrada.";
        }
        ?>
            <fieldset style="margin-top: 15px;">
                <legend>Adicionar Fotos</legend>
                <div>
                    <script type="text/javascript" src="./js/anuncios_novo_edita.js"></script>   
                    <tr>
                        <td width="71" align="right" ><label for="numFotos">N&ordm; de Fotos: </label></td>
                        <td>  
                            <input type="button" value="-" name="menosFotos" id="menosFotos" class="estiloBotao1"/>
                            &nbsp;<input type="text" name="numFotos" id="numFotos" class="tiny" />&nbsp;
                            <input type="button" value="+" name="maisFotos" id="maisFotos" class="estiloBotao1"/>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;  </td> 
                       	<td width="71" align="left" >  
                            <div id="groupDivs" >
                            <!-- AQUI VÃO OS INPUTS PRA UPLOAD DE ARQUIVO -->
                            </div>
                        </td>
                    </tr>     		 
                </div>
            </fieldset> 
        </fieldset>
        <div class="contentButton">
            <input class="botaoDourado" type="submit" name="submit" value="Enviar"/>
        </div>
        <div style="color:#F00; float:right; width:170px;">* Campos Obrigatórios</div>
    </fieldset>
    </form>
</div>