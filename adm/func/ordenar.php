<?php
function ordenar($desordenado)
{
	$desordem =  explode(" ", $desordenado);
	sort($desordem);
	$str="";
	foreach($desordem as $element)
	{
		$str= $str." ".$element;
	}
	return $str;
}
?>