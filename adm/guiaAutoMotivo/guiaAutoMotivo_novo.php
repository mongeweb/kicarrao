<?php
if(!verifica_permissao($cod_user, $nivel_user, 'guiaAutomotivo'))
{
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Permissao negada!\");\n";
	echo " location.replace('principal.php'); \n";
	echo " //--> \n";
	echo " </script> \n";
	
	die();
}
require_once ADMIN_TOP_PATH."guiaAutomotivo_topo.php";
require_once ADMIN_FUNC_PATH.'fotos.php';
$submit = isset($_POST['submit']) ? $_POST['submit'] : '' ;
$msg = "";

if($submit != '')
{
    $categorias = isset($_POST['categorias']) ? $_POST['categorias'] : array();
	$nCategorias = count($categorias);
	
    $dataValidade = isset($_POST['dataValidade']) && $_POST['dataValidade'] != '' ? dataEn($_POST['dataValidade']) : '' ;
    $empresa = isset($_POST['empresa'])? escape($_POST['empresa']) : '' ;
    $cep = isset($_POST['cep'])? escape($_POST['cep']) : '' ;
    $endereco = isset($_POST['endereco'])? escape($_POST['endereco']) : '' ;
    $cidade = isset($_POST['cidade'])? escape($_POST['cidade']) : '' ;
    $estado = isset($_POST['estado'])? escape($_POST['estado']) : '' ;
	$bairro = isset($_POST['bairro'])? escape($_POST['bairro']) : '' ;
    $email = isset($_POST['email'])? escape($_POST['email']) : '' ;
    $site = isset($_POST['site'])? escape($_POST['site']) : '' ;
    $telefone1 = isset($_POST['telefone1'])? escape($_POST['telefone1']) : '' ;
    $telefone2 = isset($_POST['telefone2'])? escape($_POST['telefone2']) : '' ;
    $mostrar = isset($_POST['mostrar']) ? escape($_POST['mostrar']) : 0;
	$destaque = isset($_POST['destaque']) ? escape($_POST['destaque']) : 0;
    $foto = isset($_FILES['file']['name']) ? $_FILES['file']['name'] : '';
    $erro = 0;
    
    $msg .= '<ul style="color:red; size:10px;font-style:italic;">';
    if (!validaCampo($empresa))
    {
        $msg .= '<li>O campo Empresa deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($telefone1))
    {
        $msg .= '<li>O campo Telefone 1 deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if($foto != '')
    {
        $formato = $_FILES['file']['name'];
        $formato = strrev($formato);
        $formato = explode('.',$formato);
        $formato = $formato[0];
        $formato = strrev($formato);
    	$formato = strtolower($formato);
        $extensoesvalidas = array("jpg","jpeg","png");
        if(!in_array($formato,$extensoesvalidas))
    	{
    		$msg .= '<li>Formato de imagem inválido!</li>';
    		$erro = 1;
        }
    }
    $msg .= '</ul>';
    
    
    if($erro == 0)
    {
        $dataCadastro = date('Y-m-d H:i:s');  
        $ordem = reordenarAuto();
        $sql = "INSERT INTO guiaAutomotivo (dataCadastro, dataValidade, empresa, cep, endereco, cidade, estado, bairro, email, site, fone1, fone2, ordem, mostrar, destaque)
                VALUES(
                '{$dataCadastro}', '{$dataValidade}', '{$empresa}', '{$cep}', '{$endereco}', '{$cidade}', '{$estado}', '{$bairro}', '{$email}', '{$site}', '{$telefone1}', '{$telefone2}', '{$ordem}', '{$mostrar}', '{$destaque}');";
    	$resultado = mysql_query($sql);
    	
		$codGuia = mysql_insert_id();
		
	   	for($b = 0; $b < $nCategorias; $b++)
		{
			if($categorias[$b] != '')
				$sqlCategorias = mysql_query("INSERT INTO guiasRelacao (codGuia, codCat) VALUES ('{$codGuia}','{$categorias[$b]}')");
		}
    	
        if($foto != '')
        {
            $foto_temp = $_FILES['file']['tmp_name'];
            $token = rand(1,99999).date('dmYHis');
            $pasta = PROJECT_PATH."arquivos/guia-automotivo";;
            $fileG = insere_foto($foto, $foto_temp, $pasta,'115','86');
    		$sqlG = "INSERT INTO arquivos (referencia, codReferencia,tipo, arquivo, codigo)
                    VALUES ('guiaAutomotivo', '{$codGuia}','1', '{$fileG}','$token')";
    		$resultadoG = mysql_query($sqlG);
        }
    	if($resultado)
        {
            echo " <script>";
    		echo " alert(\"Cadastro realizado com sucesso!\");\n";
    		echo " location.replace('http://".ADMIN_URL."/principal.php?id=3&subid=1'); \n";
    		echo " </script>";
            die();
    	}
        else
    	{
            echo " <script>";
    		echo " alert(\"Erro ao cadastrar!\");\n";
    		echo " location.replace('http://".ADMIN_URL."/principal.php?id=3&subid=2'); \n";
    		echo " </script>";
            die();
    	}
    }
}
else
{        
    $categorias = '';
    $dataValidade = '';
    $empresa = '';
    $cep = '';
    $endereco = '';
    $cidade = '';
    $estado = '';
	$bairro = '';
    $email = '';
    $site = '';
    $telefone1 = '';
    $telefone2 = '';
    $mostrar = 0;
	$destaque = 0;
    $foto = '';
}
?>

<script type="text/javascript">
function atualiza()
{
  _cep = $("#cep").val();
  //Requisição Ajax
  $.ajax(
  {
     type: "GET",
     url: "http://<?=PROJECT_URL;?>/ajaxCep.php", //URL de destino
     data:{ cep: _cep },
     dataType: "json", //Tipo de Retorno
     success: function(correio)
     { //Se ocorrer tudo certo
        if(correio.erro == "0")
        {
            
            _end = correio.logradouro;
			_endereco = _end.split(" - ");
			
			$("#endereco").val(_endereco[0]).focus();
            $("#cidade").val(correio.cidade);
            $("#estado").val(correio.estado);
            $("#cep").val(correio.cep);
        }
        else
        {
            alert(correio.erro);
        }   
     }     
  });
}
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
    $("input#cep").blur(function(){
        atualiza();
    });
    $('input#dataValidade').mask('99/99/9999');
    objValidador = new xform('form#cadastro');
    /*objValidador . adicionar('input#categorias');*/
    objValidador . adicionar('input#empresa');
    objValidador.adicionar('input#site','url',true);
    objValidador.adicionar('input#email','email',true);
    objValidador.adicionar('input#cep','cep',true);
    objValidador.adicionar('input#telefone1');
});
</script>
	
<div id="contentFormNovoEdita" style="width: 100%;">
    <form name="cadastro" id="cadastro" method="post" action="" enctype="multipart/form-data">
    <fieldset>
        <legend>Novo</legend>
        <div><?=$msg;?></div>
        <div>
            <label for="categoria"><!--<span class="obrigatorio">*</span> -->Categoria: </label>
             <? 
			 	$sqlCategorias = mysql_query("SELECT cod, categoria FROM guiaAutomotivoCategorias order by categoria");
			  	$nCategorias = mysql_num_rows($sqlCategorias);
			  	
				if($nCategorias > 0)
			  	{
              		for ($i = 0; $i < $nCategorias; $i++)
					{
						$tpCategorias = mysql_fetch_assoc($sqlCategorias);	
			  			?> 
                        <div style="margin-left: 185px;"> 
						<input type="checkbox"  name="categorias[]" id="categorias" title="<?=$tpCategorias['categoria']?>" value="<?=$tpCategorias['cod']?>"  /><?=$tpCategorias['categoria']?><br />
                        </div>
			  			<?						
					}
			  	}
			  ?>
        </div>
        <div>
            <label for="dataValidade">Data de Validade do anúncio: </label>
            <input type="text" name="dataValidade" id="dataValidade" title="Data de Validade do anúncio" value="<?=$dataValidade;?>" />
        </div>
        <div>
            <label for="empresa"><span class="obrigatorio">*</span> Empresa: </label>
            <input type="text" name="empresa" id="empresa" title="Empresa" value="<?=$empresa;?>" />
        </div>
        <div>
            <label for="cep">CEP: </label>
            <input type="text" name="cep" id="cep" title="CEP" value="<?=$cep;?>" />
        </div>
        <div>
            <label for="estado">Estado: </label>
            <input type="text" name="estado" id="estado" title="Estado" value="<?=$estado;?>" />
        </div>
        <div>
            <label for="cidade">Cidade: </label>
            <input type="text" name="cidade" id="cidade" title="Cidade" value="<?=$cidade;?>" />
        </div>
        <div>
            <label for="bairro">Bairro: </label>
            <input type="text" name="bairro" id="bairro" title="Bairro" value="<?=$bairro;?>" />
        </div>
        <div>
            <label for="endereco">Endereço: </label>
            <input type="text" name="endereco" id="endereco" title="Endereço" value="<?=$endereco;?>" />
        </div>
        <div>
            <label for="email">E-mail: </label>
            <input type="text" name="email" id="email" title="E-mail" value="<?=$email;?>" />
        </div>
        <div>
            <label for="site">Site: </label>
            <input type="text" name="site" id="site" title="Site" value="<?=$site;?>" />
        </div>
        <div>
            <label for="telefone1"><span class="obrigatorio">*</span> Telefone 1: </label>
            <input type="text" name="telefone1" id="telefone1" title="Telefone 1" value="<?=$telefone1;?>" />
        </div>
        <div>
            <label for="telefone2">Telefone 2: </label>
            <input type="text" name="telefone2" id="telefone2" title="Telefone 2" value="<?=$telefone2;?>" />
        </div>
        <div>
            <label for="imagem">Logo da Empresa: </label><input type="file" name="file" id="file" title="Foto" />
        </div>
        <div>
            <label for="mostrar"> Mostrar: </label><input type="checkbox" name="mostrar" id="mostrar" title="Mostrar" value="1" checked/>
        </div>
        <div>
            <label for="destaque"> Destaque: </label><input type="checkbox" name="destaque" id="destaque" title="Destaque" value="1" checked/>
        </div>
        <div class="contentButton">
            <input class="botaoDourado" type="submit" name="submit" value="Enviar"/>
        </div>
        <div style="color:#F00; float:right; width:170px;">* Campos Obrigatórios</div>
    </fieldset>
    </form>
</div>