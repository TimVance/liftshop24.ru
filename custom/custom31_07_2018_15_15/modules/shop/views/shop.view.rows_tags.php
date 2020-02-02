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


if(empty($result['rows'])) return false;

echo 'rest';

if(empty($result["ajax"])) {
	foreach ($result['rows'] as $row)
	{
		echo '<div class="js_shop shop-item shop">';
		echo '<div class="shop-item-inside">';
		//вывод изображений товара
		if (!empty($row["img"]))
		{
			echo '<div class="shop_img shop-photo">';
			foreach ($row["img"] as $img)
			{
				switch ($img["type"])
				{
					case 'animation':
						echo '<a href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$row["id"].'shop]">';
						break;
					case 'large_image':
						echo '<a href="'.BASE_PATH.$img["link"].'" rel="large_image" width="'.$img["link_width"].'" height="'.$img["link_height"].'">';
						break;
					default:
						echo '<a href="'.BASE_PATH_HREF.$img["link"].'">';
						break;
				}
				echo '<div class="imgsrap"><img src="'.$img["src"].'" alt="'.$img["alt"].'" title="'.$img["title"].'" image_id="'.$img["id"].'" class="js_shop_img"></div>';
				echo '<span class="shop-photo-labels">';
						if (!empty($row['hit']))
						{
							echo '<img src="' . BASE_PATH . Custom::path('img/label_hot.png').'"/>';
						}
						if (!empty($row['action']))
						{
							echo '<img src="' . BASE_PATH . Custom::path('img/label_special.png').'"/>';
						}
						if (!empty($row['new']))
						{
							echo '<img src="' . BASE_PATH . Custom::path('img/label_new.png').'"/>';					
						}
					echo '</span>';
				echo '</a> ';
                                    
                                    if(!empty($result['search'])) break;
			}

			echo '</div>';
		}
		else {
			echo '<a href="'.BASE_PATH.$row["link"].'" class="imgsrap">
				<div class="emmtyphoto"><img src="https://liftshop24.ru/custom/custom31_07_2018_15_15/img/not-image.png"></div>
			</a>';
		}

		//вывод названия и ссылки на товар	
		echo '<a href="'.BASE_PATH_HREF.$row["link"].'" class="shop-item-title">'.$row["name"].'</a>';	


		echo $this->get('buy_rows', 'shop', array("row" => $row, "result" => $result));


		echo '</div>';		
	}			
}
else {
	$count = 6;
	foreach ($result['rows'] as $row)
	{
		if ($count < 1) break;
		echo '<div class="item-result">';
			echo '<a href="'.BASE_PATH_HREF.$row["link"].'">'.$row["name"].'</a>';
		echo '</div>';
		$count--;	
	}		
}