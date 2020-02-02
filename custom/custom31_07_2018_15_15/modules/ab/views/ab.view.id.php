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
		echo '<div class="ab_img">';
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
			echo '<img src="'.$img["src"].'" width="'.$img["width"].'" height="'.$img["height"].'" alt="'.$img["alt"].'" title="'.$img["title"].'">'
			. '</a> ';
		}
		echo '</div>';
	}
            
    echo '<div class="block-text">';
	
		//полное описание объявления
		echo $result['text'];

    echo '</div>';


    echo '<div class="params-oborud">';
	    foreach ($result["param"] as $key => $value) {
	    	if ($value["id"] == 1) echo $value["value"];
	    }
    echo '</div>';


    echo '</div>';



    echo '<div class="documents-wrap flexAround">';
	    foreach ($result["param"] as $key => $value) {
	    	if ($value["id"] == 4)	echo '<a class="item catalog-models" href="'.$value["value"][0]["link"].'"><img src="'.$this->htmleditor('<insert name="custom" path="img/catalog-pdf.png" absolute="true">').'" alt="'.$value["name"].' title="Документ '.$value["name"].'">'.$value["name"].'</a>';
	    }
	    foreach ($result["param"] as $key => $value) {
	    	if ($value["id"] == 5)	echo '<a class="item sertificat" href="'.$value["value"][0]["link"].'"><img src="'.$this->htmleditor('<insert name="custom" path="img/sertificat.png" absolute="true">').'" alt="'.$value["name"].' title="Документ '.$value["name"].'">'.$value["name"].'</a>';
	    }
	    foreach ($result["param"] as $key => $value) {
	    	if ($value["id"] == 6)	echo '<a href="'.$value["value"][0]["link"].'" class="item primer-chertezha"><img src="'.$this->htmleditor('<insert name="custom" path="img/primer-chertezha.png" absolute="true">').'" alt="'.$value["name"].' title="Документ '.$value["name"].'">'.$value["name"].'</a>';
	    }
	   	foreach ($result["param"] as $key => $value) {
	    	if ($value["id"] == 7)	echo '<a href="'.$value["value"][0]["link"].'" class="item catalog-kabin"><img src="'.$this->htmleditor('<insert name="custom" path="img/catalog-pdf.png" absolute="true">').'" alt="'.$value["name"].' title="Документ '.$value["name"].'">'.$value["name"].'</a>';
	    }
    echo '</div>';



    echo '<div class="title">Галерея кабин</div>';
    echo '<div class="photo-oborud flexAround">';
	    foreach ($result["param"] as $key => $value) {
	    	if ($value["id"] == 2) {
    				foreach ($value["value"] as $img)
					{
						switch ($img["type"])
						{
							case 'animation':
								echo '<a href="'.BASE_PATH.$img["src"].'" rel="prettyPhoto[gallery'.$result["id"].'ab]">';
								break;
							case 'large_image':
								echo '<a href="'.BASE_PATH.$img["src"].'" rel="large_image" width="'.$img["link_width"].'" height="'.$img["link_height"].'">';
								break;
							default:
								echo '<a href="'.BASE_PATH_HREF.$img["src"].'" rel="prettyPhoto[gallery2ab]">';
								break;
						}
						echo '<img src="'.$img["src"].'" width="280" height="auto" alt="'.$img["alt"].'" title="'.$img["title"].'">'
						. '</a> ';
					}
	    	}
	    }
    echo '</div>';


    echo '<a class="linkto-mpcard" href="#"><img width="160" src="/custom/custom31_07_2018_15_15/img/mpcardeigner.png"></a>';

    echo '<div class="title">Галерея лифтов</div>';
    echo '<div class="photo-oborud flexAround">';
	    foreach ($result["param"] as $key => $value) {
	    	if ($value["id"] == 3) {
    				foreach ($value["value"] as $img)
					{
						switch ($img["type"])
						{
							case 'animation':
								echo '<a href="'.BASE_PATH.$img["src"].'" rel="prettyPhoto[gallery'.$result["id"].'ab]">';
								break;
							case 'large_image':
								echo '<a href="'.BASE_PATH.$img["src"].'" rel="large_image" width="'.$img["link_width"].'" height="'.$img["link_height"].'">';
								break;
							default:
								echo '<a href="'.BASE_PATH_HREF.$img["src"].'" rel="prettyPhoto[gallery3ab]">';
								break;
						}
						echo '<img src="'.$img["src"].'" width="280" height="auto" alt="'.$img["alt"].'" title="'.$img["title"].'">'
						. '</a> ';
					}
	    	}
	    }
    echo '</div>';

    echo '<div class="title">Обратная связь</div>';
    echo $this->htmleditor('<insert name="show_form" module="feedback">');


echo '</div>';

//счетчик просмотров
if(! empty($result["counter"]))
{
	echo '<div class="ab_counter">'.$this->diafan->_('Просмотров').': '.$result["counter"].'</div>';
}

echo $this->htmleditor('<insert name="show_block_rel" module="ab" count="4" images="1">');