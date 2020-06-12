<?php
/**
 * Шаблон страницы товара
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

echo '<div class="itemscope-product" itemscope itemtype="http://schema.org/Product">';
echo '<div class="js_shop_id js_shop shop shop-item-container flexBetween">';


echo '<div class="shop-item-left">';

//вывод изображений товара
if (!empty($result["img"]))
{
	echo '<div class="js_shop_all_img shop_all_img shop-item-big-images">';
	echo '<div class="zoomic"></div>';

    echo '<span class="shop-photo-labels">';
    if (!empty($result['hit']))
    {
        echo '<img src="'.BASE_PATH.Custom::path('img/label_hot_big.png').'">';
    }
    if (!empty($result['action']))
    {
        echo '<img src="'.BASE_PATH.Custom::path('img/label_special_big.png').'">';
    }
    if (!empty($result['new']))
    {
        echo '<img src="'.BASE_PATH.Custom::path('img/label_new_big.png').'">';
    }
    echo '</span>';

	//echo '<div class="fotorama" data-autoplay="true" data-nav="thumbs" data-maxwidth="435" data-width="100%">';
	$k = 0;
	foreach ($result["img"] as $img)
	{
		switch ($img["type"])
		{
			case 'animation':
				echo '<a class="js_shop_img shop-item-image'.(empty($k) ? ' active' : '').'" href="'.BASE_PATH.$img["link"].'" rel="prettyPhoto[gallery'.$result["id"].'shop]" image_id="'.$img["id"].'">';
				break;
			case 'large_image':
				echo '<a class="js_shop_img shop-item-image'.(empty($k) ? ' active' : '').'" href="'.BASE_PATH.$img["link"].'" rel="large_image" width="'.$img["link_width"].'" height="'.$img["link_height"].'" image_id="'.$img["id"].'">';
				break;
			default:
				echo '<a class="js_shop_img shop-item-image'.(empty($k) ? ' active' : '').'" href="'.BASE_PATH.$img["link"].'" image_id="'.$img["id"].'" prettyPhoto[gallery]>';
				break;
		}
		echo '<img itemprop="image" data-full="'.BASE_PATH.$img["link"].'" src="'.BASE_PATH.($k > 0 ? $img["vs"]["preview"] : $img["vs"]["id"]).'" alt="'.$img["alt"].'" title="'.$img["title"].'" image_id="'.$img["id"].'" class="shop_id_img">';
		echo '</a>';
		$k++;
	}
	//echo '</div>';
	echo '</div>';
}
else {
	echo '<div class="js_shop_all_img shop_all_img shop-item-big-images">';
	echo '<div class="zoomic"></div>';
		echo '<a class="js_shop_img shop-item-image active" href="https://liftshop24.ru/custom/custom31_07_2018_15_15/img/not-image.png" image_id="'.$result["id"].'" rel="prettyPhoto[gallery'.$result["id"].'shop]">';
			echo '<img width="100%" height="auto" itemprop="image" data-full="https://liftshop24.ru/custom/custom31_07_2018_15_15/img/not-image.png" src="https://liftshop24.ru/custom/custom31_07_2018_15_15/img/not-image.png" alt="'.$result["name"].'" title="'.$result["name"].'" image_id="'.$result["id"].'" class="shop_id_img">';
		echo '</a>';
	echo '</div>';
}

echo '</div>';

echo '<div class="shop-item-right">';
	echo '<div class="shop-item-info1">';

		echo '<h1 itemprop="name">'.$result["name"]."</h1>";

		//вывод артикула
		if (!empty($result["article"]))
		{
			echo '<h4 class="shop-item-artikul">'.$this->diafan->_('Артикул').': '.$result["article"].'</h4><br />';
		}

		//вывод производителя
		if (!empty($result["brand"]))
		{
			echo '<div class="shop_brand">';
			echo $this->diafan->_('Производитель').': ';
			echo '<a href="'.BASE_PATH_HREF.$result["brand"]["link"].'">'.$result["brand"]["name"].'</a>';
			echo '</div>';
		}

		//скидка на товар
		if (!empty($result["discount"]))
		{
			echo '<div class="shop_discount">'.$this->diafan->_('Скидка').': <span class="shop_discount_value">'.$result["discount"].' '.$result["discount_currency"].($result["discount_finish"] ? ' ('.$this->diafan->_('до').' '.$result["discount_finish"].')' : '').'</span></div>';
		}

		//кнопка "Купить"
		echo $this->get('buy_form', 'shop', array("row" => $result, "result" => $result));

        echo $this->htmleditor('<insert name="show_block" module="bought" good_id="'.$result["id"].'">');

	echo '</div>';  	

echo '</div>';

//теги товара
if (!empty($result["tags"]))
{
	echo $result["tags"];
}

//характеристики товара
if (!empty($result["param"]))
{
	echo $this->get('param', 'shop', array("rows" => $result["param"], "id" => $result["id"]));
}

//комментарии к товару
if (!empty($result["comments"]))
{
	echo $result["comments"];
}

echo '</div>';

if ($this->htmleditor($result['text'])) {
	//полное описание товара
	echo "<h2 class='titleblock'>Описание</h2>";
	echo '<div itemprop="description" class="shop_text id_text">'.$this->htmleditor($result['text']).'</div>';
}
else {
	echo "<h2 class='titleblock'>Описание</h2>";
	echo '<div itemprop="description" class="shop_text id_text">
		<p>'.$result["name"].' заказать в <a href="/catalog/">интернет-магазине запчастей для лифтов и эскалаторов</a>.</p><p> Доставка товаров производителя '.$result["breadcrumb"][1]["name"].' по всей России и странам СНГ.</p><p>Лифтовое и эскалаторное оборудование по низким ценам можно купить в магазине <a href="/">liftshop24.ru</a></p>
	</div>';
}

echo "<h2 class='titleblock'>Оплата</h2>";
echo '<!--noindex--><div class="pay_text id_text">'.$this->htmleditor('<insert name="show_block" id="15" module="site">').'</div><!--/noindex-->';

echo "<h2 class='titleblock'>Доставка</h2>";
echo '<!--noindex--><div class="dostavka_text id_text">'.$this->htmleditor('<insert name="show_block" id="16" module="site">').'</div><!--/noindex-->';

//ссылки на предыдущий и последующий товар
if (! empty($result["previous"]) || ! empty($result["next"]))
{
	echo '<div class="previous_next_links">';
	if (! empty($result["previous"]))
	{
		echo '<div class="previous_link"><a href="'.BASE_PATH_HREF.$result["previous"]["link"].'">&larr; '.$result["previous"]["text"].'</a></div>';
	}
	if (! empty($result["next"]))
	{
		echo '<div class="next_link"><a href="'.BASE_PATH_HREF.$result["next"]["link"].'">'.$result["next"]["text"].' &rarr;</a></div>';
	}
	echo '</div>';
}

echo "</div>";

echo "<h2>Другие товары этой категории</h2>";
echo $this->htmleditor('<insert name="show_block" module="shop" images="1" count="6" cat_id="'.$result["cat_id"].'">');
//echo $this->htmleditor('<insert name="show_block_order_rel" module="shop" count="12" images="1">');