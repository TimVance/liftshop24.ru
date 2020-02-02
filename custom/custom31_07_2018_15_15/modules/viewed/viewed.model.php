<?php

/**
*
*Модель модуля Просмотренные товары
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


class Viewed_model extends Model
{


	public function show_viewed($maxview, $images, $images_variation, $products_id)
	{
		$time = mktime(23, 59, 0, date("m"), date("d"), date("Y"));

		//кеширование
		$cache_meta = array(
			"name" => "block",
			"count" => $maxview,
			"lang_id" => _LANG,
			"images" => $images,
			"products_id" => $products_id,
			"images_variation" => $images_variation,
			"access" => ($this->diafan->configmodules('where_access_element', 'shop') || $this->diafan->configmodules('where_access_cat', 'shop') ? $this->diafan->_users->role_id : 0),
			"time" => $time,
		);

		if (! $this->result = $this->diafan->_cache->get($cache_meta, "shop"))
		{
			$minus = array();

			$params = array();
			$where = '';
			$inner = '';
			$values = array();

			$rands[0] = 1;

			$this->result["rows"] = array();

			$countProducts = 0;

			foreach ($products_id as $id)
			{
				if ($countProducts >= $maxview) break;
				$rows = DB::query_fetch_all("SELECT id, [name], [anons], brand_id, no_buy, site_id, timeedit, hit, new, action, article, [measure_unit] FROM {shop} WHERE id=%d", $id);
				$this->result["rows"] = array_merge($this->result["rows"], $rows);
				$countProducts++;
			}
			$this->elements($this->result["rows"], 'block', array("count" => $images, "variation" => $images_variation));


				$this->diafan->_cache->save($this->result, $cache_meta, "shop");
		}
		foreach ($this->result["rows"] as &$row)
		{
			$this->prepare_data_element($row);
		}
		foreach ($this->result["rows"] as &$row)
		{
			$this->format_data_element($row);
		}
	}



















	/**
	 * Валидация атрибута brand_id для шаблонных тегов
	 *
	 * @param array $brand_ids производители
	 * @param array $minus производители, которые вычитаются
	 * @return boolean
	 */
	private function validate_attribute_brand(&$brand_ids, &$minus)
	{
		if (! empty($brand_ids) && count($brand_ids) == 1 && empty($brand_ids[0]))
		{
			$brand_ids = array();
		}
		if (! empty($brand_ids))
		{
			$new_brand_ids = array();
			foreach ($brand_ids as $brand_id)
			{
				if(substr($brand_id, 0, 1) == '-')
				{
					$brand_id = substr($brand_id, 1);
					if(preg_replace('/[^0-9]+/', '', $brand_id) != $brand_id)
					{
						$this->error_insert_tag('Атрибут brand_id="%s" задан неверно. Номер производителя %s должен быть числом.', 'shop', implode(',', $brand_ids), $brand_id);
						return false;
					}
					$minus["brand_ids"][] = $brand_id;
					continue;
				}
				$brand_id = trim($brand_id);
				if(preg_replace('/[^0-9]+/', '', $brand_id) != $brand_id)
				{
					$this->error_insert_tag('Атрибут brand_id="%s" задан неверно. Номер производителя %s должен быть числом.', 'shop', implode(',', $brand_ids), $brand_id);
					return false;
				}
				elseif(in_array($brand_id, $new_brand_ids))
				{
					$this->error_insert_tag('Атрибут brand_id="%s" задан неверно. Повторяется производитель %s.', 'shop', implode(',', $brand_ids), $brand_id);
					return false;
				}
				else
				{
					$new_brand_ids[] = $brand_id;
				}
			}
			$brand_ids = $new_brand_ids;
			$new_brand_ids = array();
			$isset_brand_ids = array();
			if($brand_ids)
			{
				$rows = DB::query_fetch_all("SELECT id, trash FROM {shop_brand} WHERE id IN (%h)", implode(",", $brand_ids));
				foreach ($rows as $row)
				{
					if($row["trash"])
					{
						$this->error_insert_tag('Атрибут brand_id="%s" задан неверно. Производитель %d удален.', 'shop', implode(',', $brand_ids), $row["id"]);
						return false;
					}
					$isset_brand_ids[] = $row["id"];
	
					if(! in_array($row["id"], $new_brand_ids))
					{
						$new_brand_ids[] = $row["id"];
					}
				}
				// нет доступа к производит для текущего пользователя
				if(! $new_brand_ids)
				{
					return false;
				}
				foreach ($brand_ids as $brand_id)
				{
					if(! in_array($brand_id, $isset_brand_ids))
					{
						$this->error_insert_tag('Атрибут brand_id="%s" задан неверно. Производитель %s не существует.', 'shop', implode(',', $brand_ids), $brand_id);
						return false;
					}
				}
				$brand_ids = $new_brand_ids;
				return true;
			}
		}
		return true;
	}














	/**
	 * Форматирует данные о товаре для списка товаров
	 *
	 * @param array $rows все полученные из базы данных элементы
	 * @param string $function функция, для которой генерируется список товаров
	 * @param string $images_config настройки отображения изображений
	 * @return void
	 */
	public function elements(&$rows, $function = 'list', $images_config = '')
	{
		if (empty($this->result["timeedit"]))
		{
			$this->result["timeedit"] = '';
		}
		foreach ($rows as &$row)
		{
			$this->diafan->_shop->price_prepare_all($row["id"]);
		}
		foreach ($rows as &$row)
		{
			$this->price($row);
			if ($this->diafan->configmodules("images_element", "shop", $row["site_id"]))
			{
				if (is_array($images_config))
				{
					if($images_config["count"] > 0)
					{
						$this->diafan->_images->prepare($row["id"], "shop");
					}
				}
				elseif($this->diafan->configmodules("list_img_element", "shop", $row["site_id"]))
				{
					if($this->diafan->configmodules("list_img_element", "shop", $row["site_id"]) == 1)
					{
						$image_ids = array();
						foreach ($row["price_arr"] as $price)
						{
							if(! empty($price["image_rel"]))
							{
								$image_ids[] = $price["image_rel"];
							}
						}
						if(! $image_ids)
						{
							$this->diafan->_images->prepare($row["id"], "shop");
						}
					}
					else
					{
						$this->diafan->_images->prepare($row["id"], "shop");
					}
				}
			}
			if($row["brand_id"] && ! isset($this->cache["prepare_brand"][$row["brand_id"]]) && ! isset($this->cache["brand"][$row["brand_id"]]))
			{
				$this->cache["prepare_brand"][$row["brand_id"]] = true;
			}
			$this->diafan->_route->prepare($row["site_id"], $row["id"], "shop");

			$this->prepare_param($row["id"], $row["site_id"], $function);
			$ids[] = $row["id"];
		}
		if(isset($this->cache["prepare_brand"]))
		{
			$brands = DB::query_fetch_all("SELECT id, [name], site_id FROM {shop_brand} WHERE trash='0' AND [act]='1' AND id IN (%s)", implode(",", array_keys($this->cache["prepare_brand"])));
			foreach($brands as $b)
			{
				$this->diafan->_route->prepare($b["site_id"], $b["id"], "shop", "brand");
			}
			foreach($brands as $b)
			{
				$b["link"] = $this->diafan->_route->link($b["site_id"], $b["id"], "shop", "brand");
				$this->cache["brand"][$b["id"]] = $b;
			}
		}
		if($rows)
		{
			$additional_cost_rels = DB::query_fetch_key_array("SELECT a.id, a.[name], a.percent, a.price, a.amount, a.required, r.element_id, r.summ FROM {shop_additional_cost} AS a INNER JOIN {shop_additional_cost_rel} AS r ON r.additional_cost_id=a.id WHERE r.element_id IN (%s) AND a.trash='0'", implode(",", $ids), "element_id");
		}
		foreach ($rows as &$row)
		{
			if ( ! $this->diafan->configmodules("cat", "shop", $row["site_id"]))
			{
				$row["cat_id"] = 0;
			}
			if ($row["timeedit"] < $this->result["timeedit"])
			{
				$this->result["timeedit"] = $row["timeedit"];
			}
			unset($row["timeedit"]);

			if($row["brand_id"] && ! empty($this->cache["brand"][$row["brand_id"]]))
			{
				$row["brand"] = $this->cache["brand"][$row["brand_id"]];
			}
			else
			{
				$row["brand"] = false;
			}
			
			$row["additional_cost"] = array();
			if(! empty($additional_cost_rels[$row["id"]]))
			{
				foreach($additional_cost_rels[$row["id"]] AS $a_c_rel)
				{
					if($a_c_rel["percent"] || $a_c_rel["amount"])
					{
						foreach($row["price_arr"] as $price)
						{
							if($a_c_rel["amount"] && $price["price"] >= $a_c_rel["amount"])
							{
								$a_c_rel["price_summ"][$price["price_id"]] = 0;
							}
							elseif($a_c_rel["percent"])
							{
								$a_c_rel["price_summ"][$price["price_id"]] = ($price["price"] * $a_c_rel["percent"]) / 100;
							}
							else
							{
								$a_c_rel["price_summ"][$price["price_id"]] = $a_c_rel["price"];
							}
							$a_c_rel["format_price_summ"][$price["price_id"]] = $this->diafan->_shop->price_format($a_c_rel["price_summ"][$price["price_id"]]);
						}
					}
					else
					{
						if(! $a_c_rel["summ"])
						{
							$a_c_rel["summ"] = $a_c_rel["price"];
						}
						if($a_c_rel["summ"])
						{
							$a_c_rel["format_summ"] = $this->diafan->_shop->price_format($a_c_rel["summ"]);
						}
					}
					$row["additional_cost"][] = $a_c_rel;
				}
			}

			$row["link"] = $this->diafan->_route->link($row["site_id"], $row["id"], "shop");

			if ($this->diafan->configmodules("images_element", "shop", $row["site_id"]))
			{
				$count = 0;
				if (is_array($images_config))
				{
					$count = $images_config["count"];
					$link = $row["link"];
					if($images_config["count"] > 0)
					{
						$row["img"]  = $this->diafan->_images->get(
								$images_config["variation"], $row["id"], 'shop', 'element',
								$row["site_id"], $row["name"], 0,
								$images_config["count"],
								$row["link"]
							);
						$tag = $images_config["variation"];
					}
				}
				elseif($this->diafan->configmodules("list_img_element", "shop", $row["site_id"]))
				{
					$count = $this->diafan->configmodules("list_img_element", "shop", $row["site_id"]) == 1 ? 1 : 'all';
					$tag = 'medium';
					$link = ($count !== 'all' ? $row["link"] : 'large');
				}
				if($count && $count != 'all')
				{
					$image_ids = array();
					foreach ($row["price_arr"] as $price)
					{
						if(! empty($price["image_rel"]))
						{
							$image_ids[] = $price["image_rel"];
						}
					}
					if($image_ids)
					{
						$count = $image_ids;
					}
				}
				if($count)
				{
					$row["img"]  = $this->diafan->_images->get(
							$tag, $row["id"], 'shop', 'element',
							$row["site_id"], $row["name"], 0,
							$count == "all" ? 0 : $count,
							$link
						);
				}
			}

			$this->param($row, $function);
			$row["is_file"] = $this->diafan->configmodules("use_non_material_goods", "shop") ? $row["is_file"] : 0;
		}
		if(! isset($this->result["currency"]))
		{
			$this->result["currency"] = $this->diafan->configmodules("currency", "shop");
		}
	}
















	/**
	 * Формирует данные о цене товара
	 *
	 * @param array $row данные о товаре
	 * @return void
	 */
	private function price(&$row)
	{
		// массив всех характеристик, доступных к выбору при заказе
		if (! isset($this->result["depends_param"]))
		{
			$this->result["depends_param"] = DB::query_fetch_all("SELECT id, [name] FROM {shop_param} WHERE `type`='multiple' AND required='1' AND trash='0' ORDER BY sort ASC");
			foreach ($this->result["depends_param"] as &$row_param)
			{
				$row_param["values"] = DB::query_fetch_all("SELECT id, [name] FROM {shop_param_select} WHERE param_id=%d AND trash='0' ORDER BY sort ASC", $row_param["id"]);
			}
		}

		$price = array();
		$count = 0;
		$row["param_multiple"] = array();
		$rows = $this->diafan->_shop->price_get_all($row["id"], $this->diafan->_users->id);
		foreach ($rows as $row_price)
		{
			$empty_param = array();
			$row_price["param"] = array();
			$rows_param = DB::query_fetch_all("SELECT param_id, param_value FROM {shop_price_param} WHERE price_id=%d", $row_price["price_id"]);
			foreach ($rows_param as &$row_param)
			{
				if(! empty($row_param["param_value"]))
				{
					$row["param_multiple"][$row_param["param_id"]][$row_param["param_value"]] = 'depend';
					$row_price["param"][] = array("id" => $row_param["param_id"], "value" => $row_param["param_value"]);
				}
				else
				{
					$empty_param[] = $row_param["param_id"];
				}
			}
			if(! empty($empty_param))
			{
				$rows_param = DB::query_fetch_all("SELECT param_id, value".$this->diafan->_languages->site." AS value FROM {shop_param_element} WHERE element_id=%d AND param_id IN (%s)", $row["id"], implode(",", $empty_param));
				foreach ($rows_param as $row_param)
				{
					$row["param_multiple"][$row_param["param_id"]][$row_param["value"]] = 'select';
				}
			}
			$count += $row_price["count_goods"];
			$row_price["count"] = $this->diafan->configmodules("use_count_goods", "shop") ? $row_price["count_goods"] : true;
			$row_price["image_rel"] = DB::query_result("SELECT image_id FROM {shop_price_image_rel} WHERE price_id=%d LIMIT 1", $row_price["price_id"]);
			$price[] = $row_price;
		}
		$row["price_arr"] = $price;
		$row["count"] = $this->diafan->configmodules("use_count_goods", "shop") ? $count : true;
		$row["price"] = !empty($price[0]) ? $price[0]["price"] : 0;
		$row["old_price"] = !empty($price[0]) ? $price[0]["old_price"] : 0;
		$row["discount"] = '';
		if(! empty($price[0]) && $price[0]["discount_id"])
		{
			if($price[0]["discount"])
			{
				$row["discount"] = $price[0]["discount"];
				$row["discount_currency"] = '%';
			}
			else
			{
				$row["discount"] = $this->diafan->_shop->price_format($price[0]["old_price"] - $price[0]["price"]);
				$row["discount_currency"] = $this->diafan->configmodules("currency", "shop");
			}
			$row["discount_finish"] = !empty($price[0]["date_finish"]) ? $this->format_date($price[0]["date_finish"], "shop") : '';
		}
	}


















	/**
	 * Подготавливает дополнительные характеристики товара
	 * 
	 * @param integer $id номер товара
	 * @param integer $site_id номер страницы, к которой прикреплен товар
	 * @param string $function функция, для которой выбираются параметры
	 * @return array
	 */
	private function prepare_param($id, $site_id, $function = "id")
	{
	}

	/**
	 * Получает дополнительные характеристики товара
	 * 
	 * @param integer $id номер товара
	 * @param integer $site_id номер страницы, к которой прикреплен товар
	 * @param string $function функция, для которой выбираются параметры
	 * @return array
	 */
	private function param(&$good, $function = "id")
	{
		global $param_select, $param_select_page;
		$values = DB::query_fetch_key_array("SELECT e.value".$this->diafan->_languages->site." as rvalue, e.[value], e.param_id, e.id FROM {shop_param_element} as e"
		. " LEFT JOIN {shop_param_select} as s ON e.param_id=s.param_id AND e.value".$this->diafan->_languages->site."=s.id"
		. " WHERE e.element_id=%d GROUP BY e.id ORDER BY s.sort ASC", $good["id"], "param_id");

		$rows = DB::query_fetch_all("SELECT p.id, p.[name], p.type, p.page, p.[measure_unit], p.config, p.[text], p.block, p.list, p.id_page FROM {shop_param} as p "
		. ($this->diafan->configmodules("cat", "shop", $good["site_id"]) ? " INNER JOIN {shop_category_rel} as c ON c.element_id=".$good["id"] : "")
		. " INNER JOIN {shop_param_category_rel} as cp ON cp.element_id=p.id "
		. ($this->diafan->configmodules("cat", "shop", $good["site_id"]) ?
				" AND (cp.cat_id=c.cat_id OR cp.cat_id=0) " : "")
		. " WHERE p.trash='0' "
		. " GROUP BY p.id ORDER BY p.sort ASC"
		);

		$good["param"] = array();
		$good["all_param"] = array();
		foreach ($rows as $row)
		{
			switch ($row["type"])
			{
				case "text":
				case "textarea":
				case "editor":
					if ( ! empty($values[$row["id"]][0]["value"]))
					{
						$row["value"] = $values[$row["id"]][0]["value"];
						$row["value_id"] = $values[$row["id"]][0]["id"];
					}
					break;

				case "date":
					if ( ! empty($values[$row["id"]][0]["rvalue"]))
					{
						$row["value"] = $this->diafan->formate_from_date($values[$row["id"]][0]["rvalue"]);
						$row["value_id"] = $values[$row["id"]][0]["id"];
					}
					break;

				case "datetime":
					if ( ! empty($values[$row["id"]][0]["rvalue"]))
					{
						$row["value"] = $this->diafan->formate_from_datetime($values[$row["id"]][0]["rvalue"]);
						$row["value_id"] = $values[$row["id"]][0]["id"];
					}
					break;

				case "select":
					$value = ! empty($values[$row["id"]][0]["rvalue"]) ? $values[$row["id"]][0]["rvalue"] : '';
					if ($value)
					{
						if (empty($this->cache["param_select"][$row["id"]][$value]))
						{
							$this->cache["param_select"][$row["id"]][$value] = DB::query_result("SELECT [name] FROM {shop_param_select} WHERE id=%d AND param_id=%d LIMIT 1", $values[$row["id"]][0]["rvalue"], $row["id"]);
						}
						if ($row["page"])
						{
							if (empty($this->cache["param_select_page"][$row["id"]][$value]))
							{
								$this->cache["param_select_page"][$row["id"]][$value] = $this->diafan->_route->link($good["site_id"], $value, "shop", 'param');
							}
							$row["link"] = $this->cache["param_select_page"][$row["id"]][$value];
						}
						$row["value"] = $this->cache["param_select"][$row["id"]][$value];
					}
					break;

				case "multiple":
					if ( ! empty($values[$row["id"]]))
					{
						$value = array();
						foreach ($values[$row["id"]] as $val)
						{
							if (empty($this->cache["param_select"][$row["id"]][$val["rvalue"]]))
							{
								$this->cache["param_select"][$row["id"]][$val["rvalue"]] =
										DB::query_result("SELECT [name] FROM {shop_param_select} WHERE id=%d AND param_id=%d LIMIT 1", $val["rvalue"], $row["id"]);
							}
							if ($row["page"])
							{
								if ($this->diafan->_site->module == 'shop' && $this->diafan->_route->param == $val["rvalue"])
								{
									$link = '';
								}
								else
								{
									if (empty($this->cache["param_select_page"][$row["id"]][$val["rvalue"]]))
									{
										$this->cache["param_select_page"][$row["id"]][$val["rvalue"]] = $this->diafan->_route->link($good["site_id"], $val["rvalue"], "shop", 'param');
									}
									$link = $this->cache["param_select_page"][$row["id"]][$val["rvalue"]];
								}
								$value[] = array("id" => $row["id"], "name" => $this->cache["param_select"][$row["id"]][$val["rvalue"]], "link" => $link);
							}
							else
							{
								$value[] = $this->cache["param_select"][$row["id"]][$val["rvalue"]];
							}
						}
						$row["value"] = $value;
					}
					break;

				case "checkbox":
					$value = ! empty($values[$row["id"]][0]["rvalue"]) ? 1 : 0;
					if ( ! isset($this->cache["param_select"][$row["id"]][$value]))
					{
						$this->cache["param_select"][$row["id"]][$value] =
								DB::query_result("SELECT [name] FROM {shop_param_select} WHERE value=%d AND param_id=%d LIMIT 1", $value, $row["id"]);
					}
					if ( ! $this->cache["param_select"][$row["id"]][$value])
					{
						if($value == 1)
						{
							$row["value"] = '';
						}
					}
					else
					{
						$row["value"] = $this->cache["param_select"][$row["id"]][$value];
					}
					break;

				case "title":
					$row["value"] = '';
					break;

				case "images":
					$value = $this->diafan->_images->get('large', $good["id"], "shop", 'element', 0, '', $row["id"]);
					if(! $value)
						continue 2;

					$row["value"] = $value;
					break;

				case "attachments":
					$config = unserialize($row["config"]);
					if($config["attachments_access_admin"])
						continue 2;

					$value = $this->diafan->_attachments->get($good["id"], "shop", $row["id"]);
					if(! $value)
						continue 2;

					$row["value"] = $value;
					$row["use_animation"] = ! empty($config["use_animation"]) ? true : false;
					break;

				default:
					if ( ! empty($values[$row["id"]][0]["rvalue"]))
					{
						$row["value"] = $values[$row["id"]][0]["rvalue"];
						$row["value_id"] = $values[$row["id"]][0]["id"];
					}
					break;
			}
			if(isset($row["value"]))
			{
				$param = array(
					"id" => $row["id"],
					"name" => $row["name"],
					"value" => $row["value"],
					"value_id" => (! empty($row["value_id"]) ? $row["value_id"] : ''),
					"use_animation" => ! empty($row["use_animation"]) ? true : false,
					"text" => $row["text"],
					"type" => $row["type"],
					"measure_unit" => $row["measure_unit"],
					"link" => (! empty($row["link"]) ? $row["link"] : ''),
				);
				$good["all_param"][] = $param;
				switch($function)
				{
					case "block":
						if($row["block"])
						{
							$good["param"][] = $param;
						}
						break;

					case "list":
						if($row["list"])
						{
							$good["param"][] = $param;
						}
						break;

					case "id":
						if($row["id_page"])
						{
							$good["param"][] = $param;
						}
						break;
				}
			}
		}
	}













	/**
	 * Подготовка к форматированию данных о товаре для шаблона вне зоны кэша
	 *
	 * @return void
	 */
	private function prepare_data_element(&$row)
	{
		$this->diafan->_tags->prepare($row["id"], 'shop');
		$this->diafan->_rating->prepare($row["id"], 'shop');
		foreach($row["param"] as &$p)
		{
			if($p["type"] == "editor")
			{
				$p["value"] = $this->diafan->_tpl->htmleditor($p["value"]);
			}
			if($p["text"])
			{
				if(! isset($this->cache["param_text"][$p["id"]]))
				{
					$this->cache["param_text"][$p["id"]] = $this->diafan->_tpl->htmleditor($p["text"]);
				}
				$p["text"] = $this->cache["param_text"][$p["id"]];
			}
		}
	}
















	/**
	 * Форматирование данных о товаре для шаблона вне зоны кэша
	 *
	 * @return void
	 */
	public function format_data_element(&$row)
	{
		$this->select_price($row);

		if(! empty($row["price_arr"]))
		{
			foreach ($row["price_arr"] as $i => $price)
			{
				if ( ! empty($row['discount']))
				{
					$row["price_arr"][$i]["old_price"] = $this->diafan->_useradmin->get($row["price_arr"][$i]["old_price"], 'price', $row["price_arr"][$i]["price_id"], 'shop_price', '', 'text');
				}
				else
				{
					$row["price_arr"][$i]["price"] = $this->diafan->_useradmin->get($row["price_arr"][$i]["price"], 'price', $row["price_arr"][$i]["price_id"], 'shop_price', '', 'text');
				}
			}
		}
		elseif(! empty($row["price"]))
		{
			if ( ! empty($row['discount']))
			{
				$row["old_price"] = $this->diafan->_useradmin->get($row["old_price"], 'price', $row["price_id"], 'shop_price', '', 'text');
			}
			else
			{
				$row["price"] = $this->diafan->_useradmin->get($row["price"], 'price', $row["price_id"], 'shop_price', '', 'text');
			}
		}

		if ( ! empty($row["name"]))
		{
			$row["name"] = $this->diafan->_useradmin->get($row["name"], 'name', $row["id"], 'shop', _LANG);
		}
		if ( ! empty($row["article"]))
		{
			$row["article"] = $this->diafan->_useradmin->get($row["article"], 'article', $row["id"], 'shop', '', 'text');
		}
		if ( ! empty($row["text"]))
		{
			$row["text"] = $this->diafan->_useradmin->get($row["text"], 'text', $row["id"], 'shop', _LANG);
		}

		if ( ! empty($row["anons"]))
		{
			$row["anons"] = $this->diafan->_useradmin->get($row["anons"], 'anons', $row["id"], 'shop', _LANG);
		}

		if ( ! empty($row["param"]))
		{
			foreach ($row["param"] as $k => $param)
			{
				$row["param"][$k]["name"] = $this->diafan->_useradmin->get($param["name"], 'name', $param["id"], 'shop_param');
				if ( ! empty($param["value_id"]))
				{
					$lang = in_array($param["type"], array('text', 'textarea', 'editor')) ? _LANG : '';
					$row["param"][$k]["value"] = $this->diafan->_useradmin->get($param["value"], 'value', $param["value_id"], 'shop_param_element', $lang, $param["type"]);
				}
			}
		}
		//Представляет данные в разных форматах, удобных для использования в шаблоне
		foreach ($row["all_param"] as $param)
		{
			$row["ids_param"][$param["id"]] = $param;
			$row["names_param"][strip_tags($param["name"])] = $param;
		}

		$row["tags"] =  $this->diafan->_tags->get($row["id"], 'shop', 'element', (! empty($row["site_id"]) ? $row["site_id"] : 0));
		$row["rating"] = $this->diafan->_rating->get($row["id"], 'shop', 'element', (! empty($row["site_id"]) ? $row["site_id"] : 0));
	}

















	/**
	 * Задает выделение параметров, учитываемый при покупке товара
	 *
	 * @param array $row данные о товаре
	 * @return void
	 */
	private function select_price(&$row)
	{
		$row["wish"] = $this->diafan->_wishlist->get($row["id"], false, "count");

		$row["count_in_cart"] = $this->diafan->_cart->get($row["id"], false, false, "count");
		if(! $this->diafan->configmodules('buy_empty_price', "shop", $row["site_id"]))
		{
			$row["empty_price"] = true;
		}
		else
		{
			$row["empty_price"] = false;
		}
		if ( ! empty($row["price_arr"]))
		{
			$new_params = array();
			foreach ($row["price_arr"] as $id => $price)
			{
				if($row["price_arr"][$id]["price"])
				{
					$row["empty_price"] = false;
				}
				$row["price_arr"][$id]["price_no_format"] = $row["price_arr"][$id]["price"];
				$row["price_arr"][$id]["count_in_cart"] = $this->diafan->_cart->get($row["id"], $price["price_id"], false, "count");
				$row["price_arr"][$id]["price"] = $this->diafan->_shop->price_format($row["price_arr"][$id]["price"]);

				if(! empty($row["price_arr"][$id]["old_price"]))
				{
					$row["price_arr"][$id]["old_price"] = $this->diafan->_shop->price_format($row["price_arr"][$id]["old_price"]);
				}
			}
		}
		if(! empty($row["price"]))
		{
			$row["price"] = $this->diafan->_shop->price_format($row["price"]);
		}
		if(! empty($row["old_price"]))
		{
			$row["old_price"] = $this->diafan->_shop->price_format($row["old_price"]);
		}
	}


















	/**
	 * Возвращает результаты, сформированные в моделе
	 * 
	 * @return void
	 */
	public function result()
	{
		$this->result["cart_link"] = $this->diafan->_route->module("cart");
		$this->result["wishlist_link"] = $this->diafan->_route->module("wishlist");
		$this->result["access_buy"] =  (! $this->diafan->configmodules('security_user', "shop") || $this->diafan->_users->id) ? false : true;
		if(! isset($this->result["hide_compare"]))
		{
			$this->result["hide_compare"] = $this->diafan->configmodules('hide_compare', "shop");
		}
		$this->result["buy_empty_price"] = $this->diafan->configmodules('buy_empty_price', "shop");
		if(! empty($this->result["depends_param"]))
		{
			foreach ($this->result["depends_param"] as &$param)
			{
				foreach ($param["values"] as &$value)
				{
					if(! empty($_REQUEST["p".$param["id"]]))
					{
						if(is_array($_REQUEST["p".$param["id"]]))
						{
							if(in_array($value["id"], $_REQUEST["p".$param["id"]]))
							{
								$value["selected"] =  true;
								break;
							}
						}
						else
						{
							if($_REQUEST["p".$param["id"]] == $value["id"])
							{
								$value["selected"] =  true;
								break;
							}
						}
					}
				}
			}
		}

		if($this->diafan->configmodules("one_click", "shop"))
		{
				Custom::inc('modules/cart/cart.model.php');
				$cart = new Cart_model($this->diafan);
				$this->result["one_click"] = $cart->one_click();
				$this->result["one_click"]["use"] = true;
		}




	}


















}
