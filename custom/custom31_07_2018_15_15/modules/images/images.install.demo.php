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

class Images_install_demo extends Install
{
	/**
	 * @var array демо-данные
	 */
	public $demo = array(
		"images_variations" => array(
			array(
				"id" => 1,
				"name" => "Маленькое изображение (превью)",
				"folder" => "small",
				"param" => "a:1:{i:0;a:4:{s:4:\"name\";s:6:\"resize\";s:5:\"width\";i:180;s:6:\"height\";i:180;s:3:\"max\";i:0;}}",
				"quality" => 90,
			),
			array(
				"id" => 2,
				"name" => "Среднее изображение",
				"folder" => "medium",
				"param" => "a:2:{i:0;a:4:{s:4:\"name\";s:6:\"resize\";s:5:\"width\";s:3:\"200\";s:6:\"height\";s:3:\"200\";s:3:\"max\";i:0;}i:1;a:6:{s:4:\"name\";s:9:\"watermark\";s:8:\"vertical\";s:6:\"middle\";s:11:\"vertical_px\";s:1:\"0\";s:10:\"horizontal\";s:6:\"center\";s:13:\"horizontal_px\";s:1:\"0\";s:4:\"file\";s:7:\"2_1.png\";}}",
				"quality" => 90,
			),
			array(
				"id" => 3,
				"name" => "Большое изображение (полная версия)",
				"folder" => "large",
				"param" => "a:2:{i:0;a:4:{s:4:\"name\";s:6:\"resize\";s:5:\"width\";s:3:\"800\";s:6:\"height\";s:3:\"800\";s:3:\"max\";i:1;}i:1;a:6:{s:4:\"name\";s:9:\"watermark\";s:8:\"vertical\";s:6:\"middle\";s:11:\"vertical_px\";s:1:\"0\";s:10:\"horizontal\";s:6:\"center\";s:13:\"horizontal_px\";s:1:\"0\";s:4:\"file\";s:7:\"3_2.png\";}}",
				"quality" => 90,
			),
			array(
				"id" => 4,
				"name" => "Превью товара",
				"folder" => "preview",
				"param" => "a:1:{i:0;a:4:{s:4:\"name\";s:6:\"resize\";s:5:\"width\";s:3:\"113\";s:6:\"height\";s:3:\"113\";s:3:\"max\";i:0;}}",
				"quality" => 90,
			),
			array(
				"id" => 5,
				"name" => "Аватар для отзывов",
				"folder" => "avatar",
				"param" => "a:2:{i:0;a:4:{s:4:\"name\";s:6:\"resize\";s:5:\"width\";s:2:\"50\";s:6:\"height\";s:2:\"50\";s:3:\"max\";i:1;}i:1;a:7:{s:4:\"name\";s:4:\"crop\";s:5:\"width\";s:2:\"50\";s:6:\"height\";s:2:\"50\";s:8:\"vertical\";s:3:\"top\";s:11:\"vertical_px\";s:0:\"\";s:10:\"horizontal\";s:4:\"left\";s:13:\"horizontal_px\";s:0:\"\";}}",
				"quality" => 90,
			),
			array(
				"id" => 6,
				"name" => "Для категорий",
				"folder" => "categoryes",
				"param" => "a:1:{i:0;a:4:{s:4:\"name\";s:6:\"resize\";s:5:\"width\";s:3:\"160\";s:6:\"height\";s:3:\"160\";s:3:\"max\";i:0;}}",
				"quality" => 100,
			),
			array(
				"id" => 7,
				"name" => "Для страницы товара",
				"folder" => "id",
				"param" => "a:2:{i:0;a:4:{s:4:\"name\";s:6:\"resize\";s:5:\"width\";s:3:\"435\";s:6:\"height\";s:3:\"435\";s:3:\"max\";i:0;}i:1;a:6:{s:4:\"name\";s:9:\"watermark\";s:8:\"vertical\";s:6:\"middle\";s:11:\"vertical_px\";s:1:\"0\";s:10:\"horizontal\";s:6:\"center\";s:13:\"horizontal_px\";s:1:\"0\";s:4:\"file\";s:7:\"7_1.png\";}}",
				"quality" => 80,
			),
		),
	);
}