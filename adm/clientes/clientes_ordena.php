<?php

$cod = isset($_GET['cod']) ? $_GET['cod'] : '';

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'))
{   
    require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."configRoot.php";
	
    if(!empty($_POST['data']))
    {		
			$ordem = $_POST['data'];
			for ($x=0;$x<count($ordem);$x++)
            {
				$i = $x+1;
				$refer = $ordem[$x];
				$varUpt = "UPDATE clientes SET ordem = '$i' WHERE cod = '$refer'";
                
                for($a=0;$a<5;$a++)
                {
                    $sqlOrdem = mysql_query($varUpt);    
                    if($sqlOrdem)
                    {                        
                        break;
                    }
                }
                
                 
			}			
	}

    die();
}

$resultado = mysql_query("SELECT * FROM clientes WHERE tipoAnuncio = '2' ORDER BY ordem ASC");	 
$linhas = mysql_num_rows($resultado);
     
?>
<script type="text/javascript" src="./js/jquery-ui.min.js"></script>
<script type="text/javascript">
	$(document).ready(function()
    {
		
		$(".drag").sortable();
		$("#Salvar").click(function()
        {
			var ordem = [];
			$(".drag").children().each(function()
            {
				ordem.push($(this).attr("class"));
			});			
			$.post("http://<?=ADMIN_URL;?>/clientes/clientes_ordena.php",
            {
               data : ordem
            }
            ,
            function()
            {
            	alert("Ordem editada com sucesso!");
            	location.replace("http://<?=ADMIN_URL;?>/principal.php?id=6&subid=1&tipoCliente=2");
            });
		})
	})
</script>
<hr />
<div class="directions">
	Arraste as Revendas para cima ou para baixo para ordená-las.
</div>
<ul class="drag ordem" style="width: 700px;">
<?php

if ($linhas>0)
{
	for($n=0;$n<$linhas;$n++)
	{
		#<!-- linha impar branca | linha par cinza -->
		$tupla = mysql_fetch_assoc($resultado);
		if ( ($n/2) == (ceil($n/2)) )
		{
			echo "\n  <li class='".$tupla['cod']."'  style='cursor: all-scroll;border: black solid 1px; list-style: none;text-align: center; font-size: 20px;'>";
    	}	
		else
		{
			echo  "<li class='".$tupla['cod']."'  style='cursor: all-scroll;border: black solid 1px;list-style: none; text-align: center; font-size: 20px;'>";
		}
        $titulo = $tupla['nomeFantasia'] != '' ? $tupla['nomeFantasia'] : $tupla['razaoSocialNome'];
		if (strlen($titulo) > 45)
			$nome = substr($titulo,0,45)."..."; 
		else
			$nome = $titulo;
			
		echo $nome;  
        echo "</li>";		
	}
}
else
{
	echo "Nenhum Registro Encontrado";
}	

?>
</ul>
<div style="width:790px;">
    <a class="botaoDourado" href="http://<?=ADMIN_URL;?>/principal.php?id=6&subid=1&tipoCliente=2" style="float:left;width: 50px;text-align: center;">Voltar</a>
    <button class="botaoDourado" value="Salvar" id="Salvar" style="float:right;">Salvar</button>
</div>

