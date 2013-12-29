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
$submit = isset($_POST['submit']) ? $_POST['submit'] : '' ;
$msg = "";
$md5 = new md5();
if($submit != '')
{    
    $tipoAnuncio = isset($_POST['tipoAnuncio'])? $_POST['tipoAnuncio'] : '' ;
    $razaoSocialNome = isset($_POST['razaoSocialNome'])? escape($_POST['razaoSocialNome']) : '' ;
    $documento = isset($_POST['documento'])? escape($_POST['documento']) : '' ;
    $cep = isset($_POST['cep'])? escape($_POST['cep']) : '' ;
    $endereco = isset($_POST['endereco'])? escape($_POST['endereco']) : '' ;
    $numero = isset($_POST['numero'])? escape($_POST['numero']) : '' ;
    $complemento = isset($_POST['complemento'])? escape($_POST['complemento']) : '' ;
    $bairro = isset($_POST['bairro'])? escape($_POST['bairro']) : '' ;
    $cidade = isset($_POST['cidade'])? escape($_POST['cidade']) : '' ;
    $estado = isset($_POST['estado'])? escape($_POST['estado']) : '' ;
    $pais = isset($_POST['pais'])? escape($_POST['pais']) : '' ;
    $site = isset($_POST['site'])? escape($_POST['site']) : '' ;
    $telRes = isset($_POST['telRes'])? escape($_POST['telRes']) : '' ;
    $telCel = isset($_POST['telCel'])? escape($_POST['telCel']) : '' ;
    $telCom = isset($_POST['telCom'])? escape($_POST['telCom']) : '' ;
    $email = isset($_POST['email'])? escape($_POST['email']) : '' ;
    $senha = isset($_POST['senha'])? escape($_POST['senha']) : '' ;
    $senhacript = $md5->code($senha); 
    $tipoRevenda = isset($_POST['tipoRevenda'])? $_POST['tipoRevenda'] : '';
    $responsavel = isset($_POST['responsavel'])? escape($_POST['responsavel']) : '' ;
    $situacao = isset($_POST['situacao'])? $_POST['situacao'] : 0 ;
    $erro = 0;
    
    $msg .= '<ul style="color:red; size:10px;font-style:italic;">';
    if (!validaCampo($tipoAnuncio))
    {
        $msg .= '<li>O campo Tipo de Anúncio deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($razaoSocialNome))
    {
        $msg .= '<li>O campo Razão Social / Nome deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($telRes))
    {
        $msg .= '<li>O campo Telefone Residencial deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($documento))
    {
        $msg .= '<li>O campo Documento deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    
    if (!validaCampo($email))
    {
        $msg .= '<li>O campo Email deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($senha))
    {
        $msg .= '<li>O campo Senha deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if($tipoAnuncio == '2')
    {
        if (!validaCampo($tipoRevenda))
        {
            $msg .= '<li>O campo Tipo de Revenda deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
    }
    $msg .= '</ul>';
    
    if($erro == 0)
    {
        $dataCadastro = date('Y-m-d');
        if($situacao == '1')
        {
            $emailAtivacao = '1';
            //Envia o email
        }
        else
        {
            $emailAtivacao = '0';
        }
        $sql = "INSERT INTO clientes (dataCadastro, tipoAnuncio, razaoSocialNome, documento, cep, endereco, numero, complemento, bairro, cidade, estado, pais, telRes, telCel, telCom, email, senha, tipoRevenda, responsavel, site, situacao, emailAtivacao)
                VALUES(
                '{$dataCadastro}', '{$tipoAnuncio}', '{$razaoSocialNome}', '{$documento}', '{$cep}', '{$endereco}', '{$numero}', '{$complemento}', '{$bairro}', '{$cidade}', '{$estado}', '{$pais}', '{$telRes}', '{$telCel}', '{$telCom}', '{$email}', '{$senhacript}', '{$tipoRevenda}', '{$responsavel}', '{$site}', '{$situacao}', '{$emailAtivacao}');";
    	$resultado = mysql_query($sql);
        
    	if($resultado)
        {
            echo " <script>";
    		echo " alert(\"Cadastro realizado com sucesso!\");\n";
    		echo " location.replace('http://".ADMIN_URL."/principal.php?id=6&subid=1'); \n";
    		echo " </script>";
            die();
    	}
        else
    	{
            echo " <script>";
    		echo " alert(\"Erro ao cadastrar!\");\n";
    		echo " location.replace('http://".ADMIN_URL."/principal.php?id=6&subid=2'); \n";
    		echo " </script>";
            die();
    	}
    }
}
else
{        
    $cliente = '';
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
    $dataValidadeAnuncio = '';
    $destaqueCapa = 0;
    $destaqueLista = 0;
    $nFotos = 0;
    //$video = 0;
    //$linkVideo = '';
    //$mapa = 0;
    //$linkMapa = '';
}
?>

<script type="text/javascript">
$(document).ready(function()
{
    $("input#valor").maskMoney({showSymbol:true, symbol:"R$ ", decimal:".", thousands:""});
    $("input#valorParcela").maskMoney({showSymbol:true, symbol:"R$ ", decimal:".", thousands:""});
    $("input#valorEntrada").maskMoney({showSymbol:true, symbol:"R$ ", decimal:".", thousands:""});
    
    objValidador = new xform('form#cadastro');
    objValidador.adicionar('select#cliente');
    objValidador.adicionar('select#tipoVeiculo');
    objValidador.adicionar('input#dataValidadeAnuncio', 'dataBr');
    objValidador.adicionar('input#valor');
    
    $('#video').click(function(){
        
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
    
    /*$('#mapa').click(function(){
        
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
    })*/
    
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
});
</script>
	
<div id="contentFormNovoEdita" style="width: 100%;">
    <form name="cadastro" id="cadastro" method="post" action="" enctype="multipart/form-data">
    <fieldset>
        <legend>Novo Anúncio</legend>
        <div><?=$msg;?></div>
        <div>
            <label for="cliente"><span class="obrigatorio">*</span> Cliente: </label>
            <select name="cliente" id="cliente" title="Cliente">
                <option value="">Selecione</option>
                <?php
                	$sqlClientes = mysql_query("SELECT * FROM clientes ORDER BY razaoSocialNome");
                    $numClientes = mysql_num_rows($sqlClientes);
                    for($x = 0;$x < $numClientes;$x++)
                    {
                        $tpClientes = mysql_fetch_assoc($sqlClientes);
                ?>
                        <option value="<?=$tpClientes['cod'];?>" <?=$tpClientes['cod'] == $cliente ? "selected = 'selected'" : "";?>><?=$tpClientes['razaoSocialNome'];?></option>
                <?php
                	}
                ?>
            </select>
        </div>
        <div>
            <label for="tipoVeiculo"><span class="obrigatorio">*</span> Tipo de veiculo: </label>
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
            </select>
        </div>
        <div>
            <label for="versao">Versões: </label>
            <span class="carregando" style="color:#666;display:none;">Aguarde, carregando...</span>
            <select name="versao" id="versao" title="Versões">
                <option value="">Selecione</option>
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
            <label for="nPortas">Numero de portas: </label>
            <input onkeypress="return verificaNumero (event)" type="text" name="nPortas" id="nPortas" title="Numero de portas" value="<?=$nPortas;?>"  />
        </div>
        <div>
            <label for="valor"><span class="obrigatorio">*</span> Preço: </label><input type="text" name="valor" id="valor" title="Preço" value="<?=number_format((float)$valor,2,'.','');?>" />
        </div>
        <div>
            <label for="nParcelas">Numero de parcelas: </label>
            <input onkeypress="return verificaNumero (event)" type="text" name="nParcelas" id="nParcelas" title="Numero de parcelas" value="<?=$nParcelas;?>"  />
        </div>
        <div>
            <label for="valorParcela">Valor parcela: </label>
            <input type="text" name="valorParcela" id="valorParcela" title="Valor parcela" value="<?=number_format((float)$valorParcela,2,'.','');?>" />
        </div>
        <div>
            <label for="valorEntrada">Valor Entrada: </label>
            <input type="text" name="valorEntrada" id="valorEntrada" title="Valor Entrada" value="<?=number_format((float)$valorEntrada,2,'.','');?>" />
        </div>
        <div>
            <label for="caractVeiculo">Características do veículo: </label>
            <textarea name="caractVeiculo" id="caractVeiculo" title="Características do veículo"><?=$caractVeiculo;?></textarea>
        </div>
        <div>
            <label for="plano">Plano: </label><input type="text" disabled="disabled" />
        </div>
        <div>
            <label for="dataValidadeAnuncio"><span class="obrigatorio">*</span> Validade do anúncio: </label>
            <input type="text" name="dataValidadeAnuncio" id="dataValidadeAnuncio" title="Validade do anúncio" value="<?=$dataValidadeAnuncio;?>"  />
        </div>
        <div>
            <label for="destaqueCapa">Destaque capa: </label>
            <input type="checkbox" name="destaqueCapa" id="destaqueCapa" value="1" title="Destaque capa" <?=$destaqueCapa == '1' ? 'checked="checked"' : '';?> />
        </div>
        <div>
            <label for="destaqueLista">Destaque lista: </label>
            <input type="checkbox" name="destaqueLista" id="destaqueLista" value="1" title="Destaque lista" <?=$destaqueLista == '1' ? 'checked="checked"' : '';?> />
        </div>
        <div>
            <label for="nFotos">Numero de fotos: </label>
            <input onkeypress="return verificaNumero (event)" type="text" name="nFotos" id="nFotos" title="Numero de fotos" value="<?=$nFotos;?>"  />
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
        <div class="contentButton">
            <input class="botaoDourado" type="submit" name="submit" value="Enviar"/>
        </div>
        <div style="color:#F00; float:right; width:170px;">* Campos Obrigatórios</div>
    </fieldset>
    </form>
</div>