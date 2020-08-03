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



    echo '<div class="block-text">';
	
		//полное описание объявления
		echo $result['text'];

    echo '</div>';
           


    foreach ($result["param"] as $key => $value) {
    	if ($value["id"] == 8)	echo '<a class="item catalog-models" href="'.$value["value"][0]["link"].'"><img src="'.$result["img"][0]["vs"]["medium"].'" alt="Каталог кабин"></a>';
    }

    echo $this->htmleditor('<insert count="9" images_variation="cabina" name="show_block" module="ab" cat_id="4" images="1">');

    echo '<br><br><h2 style="text-align: center">Обратная связь</h2>';
    echo $this->htmleditor('<insert name="show_form" module="feedback">');

echo '</div>';

//счетчик просмотров
if(! empty($result["counter"]))
{
	echo '<div class="ab_counter">'.$this->diafan->_('Просмотров').': '.$result["counter"].'</div>';
}

echo $this->htmleditor('<insert name="show_block_rel" module="ab" count="4" images="1">');