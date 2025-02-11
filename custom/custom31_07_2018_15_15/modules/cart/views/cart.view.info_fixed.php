<?php
/**
 * Шаблон информации о товарах в корзине
 * 
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2017 OOO «Диафан» (http://www.diafan.ru/)
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

echo '<a class="carttopinfo" href="'.$result["link"].'"><svg aria-hidden="true" data-prefix="fas" data-icon="shopping-cart" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="svg-inline--fa fa-shopping-cart fa-w-18 fa-2x"><path fill="currentColor" d="M528.12 301.319l47.273-208C578.806 78.301 567.391 64 551.99 64H159.208l-9.166-44.81C147.758 8.021 137.93 0 126.529 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24h69.883l70.248 343.435C147.325 417.1 136 435.222 136 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-15.674-6.447-29.835-16.824-40h209.647C430.447 426.165 424 440.326 424 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-22.172-12.888-41.332-31.579-50.405l5.517-24.276c3.413-15.018-8.002-29.319-23.403-29.319H218.117l-6.545-32h293.145c11.206 0 20.92-7.754 23.403-18.681z" class=""></path></svg>';
$goods = '%s шт. ';
if(substr($result["count"], -1) == 1 || substr($result["count"], -1) == 1 && substr($result["count"], -2, 1) != 1)
{
	$goods = '%s шт. ';
}
elseif(substr($result["count"], -1) > 1 && substr($result["count"], -1) < 5 && substr($result["count"], -2, 1) != 1)
{
	$goods = '%s шт. ';
}
elseif(substr($result["count"], -1) < 1 && substr($result["count"], -1) < 5 && substr($result["count"], -2, 1) != 1)
{
	$goods = '<span class="emptycart">0</a>';
}
echo $this->diafan->_($goods, true, $result["count"]);
echo '</a>';