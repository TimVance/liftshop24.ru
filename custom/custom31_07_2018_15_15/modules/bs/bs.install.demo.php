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

class Bs_install_demo extends Install
{
	/**
	 * @var array демо-данные
	 */
	public $demo = array(
		"bs_category" => array(
			array(
				"id" => 1,
				"name" => "Слайдер на главной странице",
			),
		),
		"bs" => array(
			array(
				"name" => array("Слайд 1"),
				"type" => 1,
				"file" => "slide1_12.jpg",
				"cat_id" => 1,
				"sort" => 14,
				"copy" => array("bs/slide1_12.jpg"),
			),
			array(
				"name" => array("Слайд 2"),
				"type" => 1,
				"file" => "slide2_13.jpg",
				"cat_id" => 1,
				"sort" => 13,
				"copy" => array("bs/slide2_13.jpg"),
			),
			array(
				"name" => array("Слайд 3"),
				"type" => 1,
				"file" => "slide3_14.jpg",
				"cat_id" => 1,
				"sort" => 12,
				"copy" => array("bs/slide3_14.jpg"),
			),
		),
	);
}