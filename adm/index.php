<?php
require_once '../configRoot.php';
session_destroy();

?>
<html>
<head>
<title><?=ADMIN_TITLE;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://<?=ADMIN_CSS_URL;?>/estilo.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" scroll=no>
<table width="960" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
        <img width="960" src="http://<?=ADMIN_IMG_URL;?>/cartola.jpg" />
    </td>
  </tr>
</table>

<div class="login"> 

  <?php
    require_once ADMIN_PATH."login.php";
  ?>
</div>
</body>
</html>