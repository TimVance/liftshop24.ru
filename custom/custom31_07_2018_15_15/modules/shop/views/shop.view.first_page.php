<?php


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

if (empty($result["categories"]))
	return false;


foreach ($result["categories"] as $key => $value) {
	$names[$key] = $value["name"];	
}

asort($names);

foreach ($names as $key => $value) {
	$sortResult[] = $result["categories"][$key];
}


echo '<h1>Каталог запчастей для лифтов и эскалаторов</h1>';

echo '<div class="flexStart">';
//начало большого цикла, вывод категорий и товаров в них
foreach ($sortResult as $cat_id => $cat)
{
	echo '<div class="js_shop_list shop_list">';

	//вывод названия категории
	echo '<div class="block_header"><a href="'.BASE_PATH_HREF.$cat["link_all"].'"><h4>'.$cat["name"].'</h4></a></div>';

	//вывод изображений категории
	if (!empty($cat["img"]))
	{
		echo '<div class="shop_cat_img">';
		foreach ($cat["img"] as $img)
		{
			switch ($img["type"])
			{
				case 'animation':
					echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$cat_id.'shop]">';
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

	//подкатегории
/*	if (!empty($cat["children"]))
	{
		foreach ($cat["children"] as $child)
		{
			echo '<div class="shop_cat_link">';

			//название и ссылка подкатегории
			echo '<a href="'.BASE_PATH_HREF.$child["link"].'">'.$child["name"].' ('.$child["count"].')</a></div>';
			
			//изображения подкатегории
			if (!empty($child["img"]))
			{
				echo '<div class="shop_cat_img">';
				foreach ($child["img"] as $img)
				{
					switch ($img["type"])
					{
						case 'animation':
							echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$child["id"].'shop]">';
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

			//краткое описание подкатегории
			if (!empty($child["anons"]))
			{
				echo '<div class="shop_cat_anons">'.$child['anons'].'</div>';
			}

			//вывод списка товаров подкатегории
			if (!empty($child["rows"]))
			{
				$res = $result;
				$res["rows"] = $child["rows"];
                                echo '<div class="shop-pane">';
				echo $this->get('rows', 'shop', $res);
                                echo '</div>';
			}
		}
	}*/

	echo '</div>';
}

//постраничная навигация
if (!empty($result["paginator"]))
{
	echo $result["paginator"];
}

echo '</div>';


//краткое описание категории
if (!empty($cat["anons"]))
{
	echo '<div class="shop_cat_anons">'.$cat['text'].'</div>';
}