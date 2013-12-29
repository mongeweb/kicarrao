<?php

/**
 * imprimeFCKeditor()
 * 
 * Fun��o que imprime o editor FCKeditor.
 * 
 * @author Luis Fernando Gomes
 * @copyright 08/2009
 * @version 1.1
 * 
 * Hist�rico:
 * 
 * Data			| Vers�o | Modifica��o
 * ------------------------------------------------------------------------------------------------
 * 06/05/2010	|	1.1	 | Adicionado par�metro $instanceName.
 * ------------------------------------------------------------------------------------------------
 * 
 * @param string $instanceName
 * @param string $basePath
 * @param string $value
 * @param integer $width
 * @param integer $height
 * @return void
 */
function imprimeFCKeditor($instanceName = 'FCKeditor1', $basePath = '', $value = '', $width = 600, $height = 450)
{
    $oFCKeditor = new FCKeditor($instanceName);
    $oFCKeditor->BasePath = $basePath; 
    $oFCKeditor->Width = $width;
    $oFCKeditor->Height = $height;
    $oFCKeditor->Value = $value;
    $oFCKeditor->Create();
}

?>