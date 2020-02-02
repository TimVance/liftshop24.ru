<?php
/**
 * Шаблон блока объявлений
 * 
 * Шаблонный тег <insert name="show_block" module="ab" [count="количество"]
 * [cat_id="категория"] [site_id="страница_с_прикрепленным_модулем"]
 * [images="количество_изображений"] [images_variation="тег_размера_изображений"]
 * [sort="порядок_вывода"] [param="дополнительные_условия"]
 * [only_module="выводить_только_на_странице_модуля"] [template="шаблон"]>:
 * блок объявлений
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

if (empty($result["rows"]))
	return false;

echo '<div class="ab_block list-cabins-models">';

//объявления
if (!empty($result["rows"]))
{
	foreach ($result["rows"] as $row)
	{
		echo '<div class="js_ab ab flexBetween">';

		//изображения
		if (!empty($row["img"]))
		{
			echo '<div class="ab_img">';
			foreach ($row["img"] as $img)
			{
				switch ($img["type"])
				{
					case 'animation':
						echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$row["id"].'ab]">';
						break;
					case 'large_image':
						echo '<a href="'.BASE_PATH.$img["link"].'" rel="large_image" width="'.$img["link_width"].'" height="'.$img["link_height"].'">';
						break;
					default:
						echo '<a href="'.BASE_PATH.$img["vs"]["large"].'" rel="prettyPhoto[gallery_ab]">';
						break;
				}
				echo '<img src="'.$img["vs"]["idab"].'" alt="'.$img["alt"].'" title="'.$img["title"].'">'
				. '</a> ';
			}
			echo '</div>';
		}

		echo '<div>';

		//название и ссылка
		echo '<div class="ab_desc">';

		echo $row["anons"];

		echo '</div>';


		echo '</div>';
		echo '</div>';
	}
}

echo '</div>';