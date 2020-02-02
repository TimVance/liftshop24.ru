<?php
/**
 * Установка модуля
 *
 * @package    Diafan.CMS
 * @author     diafan.ru
 * @version    5.4
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2018 OOO «Диафан» (http://www.diafan.ru/)
 */

if (! defined("DIAFAN"))
{
	$path = __FILE__; $i = 0;
	while(! file_exists($path.'/includes/404.php'))
	{
		if($i == 10) exit; $i++;
		$path = dirname($path);
	}
	include $path.'/includes/404.php';
}

class Search_install_demo extends Install
{
	/**
	 * @var array демо-данные
	 */
	public $demo = array(
		"site" => array(
			array(
				"id" => 7,
				"name" => array("Поиск"),
				"rewrite" => "search",
				"theme" => "site-search.php",
				"sort" => 7,
				"module_name" => "search",
			),
		),
		"config" => array(
			array(
				"name" => "nastr",
				"value" => "30",
			),
			array(
				"name" => "count_history",
				"value" => "30",
			),
			array(
				"name" => "search_like",
				"value" => "1",
			),
			array(
				"name" => "max_length",
				"value" => "1",
			),
			array(
				"name" => "module_shop_index",
				"value" => "",
			),
		),
	);
}