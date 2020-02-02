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

class Map_install_demo extends Install
{
	/**
	 * @var array демо-данные
	 */
	public $demo = array(
		"site" => array(
			array(
				"id" => 20,
				"name" => array("Карта сайта"),
				"rewrite" => "map",
				"sort" => 20,
				"module_name" => "map",
			),
		),
		"config" => array(
			array(
				"name" => "full_index",
				"value" => "1",
			),
			array(
				"name" => "all_current_index_module_type",
				"value" => "",
			),
			array(
				"name" => "all_current_index_module_element",
				"value" => "",
			),
			array(
				"name" => "all_current_index_site",
				"value" => "",
			),
		),
	);
}