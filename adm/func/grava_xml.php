<?
function xml_projetos()
{
	$sqlxml="SELECT * FROM projetos WHERE mostrar = 1 ORDER BY ordem";
	$result = mysql_query($sqlxml);

	$arquivo = "xml/projetos.xml";
	$handle = fopen($arquivo,"w");
	fwrite($handle,'<?xml version="1.0" encoding="ISO-8859-1"?>'."\n\n");
	fwrite($handle,"<coisa>\n");
	while ($tupla = mysql_fetch_array($result))
	{
		fwrite($handle,"<projeto>\n");
		fwrite($handle,"<cod_projeto>" . $tupla['cod'] . "</cod_projeto>\n");
		fwrite($handle,"<titulo>" . $tupla['titulo'] . "</titulo>\n");
		fwrite($handle,"<imagem_media>./projetos/" . $tupla['imagem_media'] . "</imagem_media>\n");
		fwrite($handle,"<arquivo>" . $tupla['arquivo'] . "</arquivo>\n");
		fwrite($handle,"<link>" . $tupla['link'] . "</link>\n");
		fwrite($handle,"<altura_media>" . $tupla['altura_media'] . "</altura_media>\n");
		fwrite($handle,"<largura_media>" . $tupla['largura_media'] . "</largura_media>\n");
		fwrite($handle,"</projeto>\n");
	}
	fwrite($handle,"</coisa>\n\n");
	fclose($handle);
}

?>