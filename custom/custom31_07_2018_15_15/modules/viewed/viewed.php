<?php

/**
*
*Модуль Просмотренные товары
*
*@author     TimVance
*@link       https://dlay.ru
*
*
*/

if (! defined('DIAFAN'))
{
	include dirname(dirname(dirname(__FILE__))).'/includes/404.php';
}

/**
 * Clauses
 */
class Viewed extends Controller
{

	/**
	 * Инициализация модуля
	 * 
	 * @return void
	 */
	public function init()
	{
		$this->model->show_viewed();
	}


	public function show_viewed($attributes) {

		$maxview = (isset($attributes["maxview"]))? $attributes["maxview"]: 3;

		if (isset($_SESSION["shop_view"])) {

			$show_view = $_SESSION["shop_view"];

			foreach ($show_view as $index => $countview) {
				$product[] = $index;
			}

			$products_id = array_reverse($product);

			$attributes = $this->get_attributes($attributes, 'count', 'images', 'images_variation', 'template');

			$images  = intval($attributes["images"]);
			$images_variation = $attributes["images_variation"] ? strval($attributes["images_variation"]) : 'medium';

			$this->model->show_viewed($maxview, $images, $images_variation, $products_id);
			$this->model->result();
			$this->model->result["attributes"] = $attributes;

			echo $this->diafan->_tpl->get('show_block', 'viewed', $this->model->result, $attributes["template"]);
		}
	}
}