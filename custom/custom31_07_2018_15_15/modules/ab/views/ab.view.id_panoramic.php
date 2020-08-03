<?php
/**
 * Шаблон страница объявления
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

echo '<div class="js_ab ab block">';



    echo $this->htmleditor('<insert name="show_block" module="ab" cat_id="6" images="1" template="panoramic" count="99">');


    echo '<br />';

		echo '<a style="float:right" class="return-back" href="/mp-car/">Назад</a><div class="clear"></div>';

        echo '<br><br><h2 style="text-align: center">Обратная связь</h2>';
		echo $this->htmleditor('<insert name="show_form" module="feedback">');




echo '</div><br />';