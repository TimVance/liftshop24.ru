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

class Menu_install_demo extends Install
{
	/**
	 * @var array демо-данные
	 */
	public $demo = array(
		"menu_category" => array(
			array(
				"id" => 1,
				"name" => array("Меню верхнее"),
				"show_all_level" => "1",
			),
			array(
				"id" => 3,
				"name" => array("Меню нижнее"),
			),
		),
	);
}