<?php

/**
*
*Шаблон модуля Просмотренные товары
*
*@author     TimVance
*@link       https://dlay.ru
*
*
*/

if (! defined('DIAFAN'))
{
    $path = __FILE__; $i = 0;
	while(! file_exists($path.'/includes/404.php'))
	{
		if($i == 10) exit; $i++;
		$path = dirname($path);
	}
	include $path.'/includes/404.php';
}

if (empty($result["rows"]))
{
	return false;
}


echo "<h2 class='titlefree'>Просмотренные товары</h2>";

//товары в разделе
if (!empty($result["rows"]))
{
	echo '<div class="shop-pane column3">';	
        echo $this->get('rows','shop',$result);
	echo '</div>';
}
