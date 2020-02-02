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

class Feedback_install_demo extends Install
{
	/**
	 * @var array демо-данные
	 */
	public $demo = array(
		"site" => array(
			array(
				"id" => 5,
				"name" => array("Обратная связь"),
				"rewrite" => "feedback",
				"sort" => 5,
				"module_name" => "feedback",
				"parent_id" => "4",
			),
			array(
				"id" => 16,
				"name" => array("Заказать обратный звонок"),
				"rewrite" => "zakazat-obratnyy-zvonok",
				"sort" => 16,
				"module_name" => "feedback",
			),
		),
		"config" => array(
			array(
				"name" => "add_message",
				"value" => "<div align=\"center\"><b>Спасибо за ваше сообщение!</b></div>",
			),
			array(
				"name" => "subject",
				"value" => "%title (%url). Обратная связь",
			),
			array(
				"name" => "message",
				"value" => "Здравствуйте!<br>Вы оставили сообщение в форме обратной связи на сайте %title (%url).<br><b>Сообщение:</b> %message <br><b>Ответ:</b> %answer",
			),
			array(
				"name" => "sendsmsadmin",
				"value" => "0",
			),
			array(
				"name" => "captcha",
				"value" => "a:4:{i:0;s:1:\"0\";i:1;s:1:\"1\";i:2;s:1:\"2\";i:3;s:1:\"3\";}",
			),
		),
		"feedback_param" => array(
			array(
				"id" => 1,
				"name" => array("Ваше имя"),
				"type" => "text",
				"sort" => 2,
				"required" => "1",
				"site_id" => 5,
			),
			array(
				"id" => 2,
				"name" => array("E-mail"),
				"type" => "email",
				"sort" => 6,
				"required" => "1",
				"site_id" => 5,
			),
			array(
				"id" => 6,
				"name" => array("Телефон"),
				"type" => "phone",
				"sort" => 7,
				"required" => "1",
				"site_id" => 5,
			),
			array(
				"id" => 9,
				"name" => array("Ваше имя"),
				"type" => "text",
				"sort" => 9,
				"required" => "1",
				"site_id" => 4,
			),
			array(
				"id" => 10,
				"name" => array("Email"),
				"type" => "email",
				"sort" => 10,
				"required" => "1",
				"site_id" => 4,
			),
			array(
				"id" => 11,
				"name" => array("Телефон"),
				"type" => "phone",
				"sort" => 11,
				"site_id" => 4,
			),
			array(
				"id" => 12,
				"name" => array("Комментарий"),
				"type" => "textarea",
				"sort" => 12,
				"required" => "1",
				"site_id" => 4,
			),
			array(
				"id" => 13,
				"name" => array("Ваше сообщение"),
				"type" => "textarea",
				"sort" => 13,
				"site_id" => 5,
			),
			array(
				"id" => 14,
				"name" => array("Ваше имя"),
				"type" => "text",
				"sort" => 14,
				"required" => "1",
				"site_id" => 16,
			),
			array(
				"id" => 15,
				"name" => array("Номер телефона"),
				"type" => "phone",
				"sort" => 15,
				"required" => "1",
				"site_id" => 16,
			),
		),
	);
}