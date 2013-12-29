<?
function limitar($texto, $numero){
 
	$total = strlen($texto);
	$texto = substr($texto,0,$numero);
	$separar = explode(" ",$texto);
 
	if($total >= $numero){
		for($i=0; $i< (count($separar)-1); $i++){	
			$fim .= $separar[$i]." ";
		}
		$fim .= '...';
	}
        else
	{
         $fim = $texto;
        }
return $fim;
}

?>