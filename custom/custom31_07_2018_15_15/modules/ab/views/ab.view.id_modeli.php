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


	echo '<div class="flexBetween">';

	//вывод изображений объявления
	if (!empty($result["img"]))
	{
		echo '<div class="ab_img page-modeli">';
		foreach ($result["img"] as $img)
		{
			switch ($img["type"])
			{
				case 'animation':
					echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$result["id"].'ab]">';
					break;
				case 'large_image':
					echo '<a href="'.BASE_PATH.$img["link"].'" rel="large_image" width="'.$img["link_width"].'" height="'.$img["link_height"].'">';
					break;
				default:
					echo '<a href="'.BASE_PATH_HREF.$img["link"].'">';
					break;
			}
			echo '<img src="'.$img["vs"]["idab"].'" alt="'.$img["alt"].'" title="'.$img["title"].'">'
			. '</a> ';
		}
		echo '</div>';
	}
            
    echo '<div class="block-text models-gallery">';
	
		//полное описание объявления
		echo $result['text'];



    echo '<br /><div class="flexBetween flexAlign">';

	    foreach ($result["param"] as $key => $value) {
	    	if ($value["id"] == 12)	echo '<a href="'.$value["value"][0]["link"].'" class="downdload-catalog"><img src="'.$this->htmleditor('<insert name="custom" path="img/catalog-filt.png" absolute="true">').'" alt="'.$value["name"].' title="Документ '.$value["name"].'"><br />'.$value["name"].'</a>';
	    }

		echo '<a class="return-back" href="/mp-car/">Назад</a>
    </div>';

    echo '</div>';

    echo '</div>';

    echo '<br><br><h2 style="text-align: center">Обратная связь</h2>';
    echo $this->htmleditor('<insert name="show_form" module="feedback">');

echo '</div>';