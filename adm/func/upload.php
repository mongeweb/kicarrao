<?
function upload($origem,$destino,$nome)
{

	$ext = strrev($nome);
	$ext = explode(".", $ext);
	$ext = $ext[0];
	$ext = strrev($ext);
	$hoje = date('dmy');
	$arquivo_novo = "arquivo_".$hoje."_".rand(1,10000).".".$ext;

	//echo $foto;
	$local_destino = $destino."/".$arquivo_novo;
	
	//echo "origem:".$origem;
	//echo "<br>Destino:".$local_destino;
	//echo "<br>arquivo_novo:".$arquivo_novo;
	
	if(move_uploaded_file($origem,$local_destino))
		return $arquivo_novo;
	else
		return "";

}
?>