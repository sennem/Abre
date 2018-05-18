<?php
require_once(dirname(__FILE__) . '/../abre_functions.php');
header("Content-type: text/css");
$siteColor = getSiteColor();
?>


.switch label input[type=checkbox]:checked+.lever:after{
  background-color: <?php echo $siteColor;?> !important;
} 