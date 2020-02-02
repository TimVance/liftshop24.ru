<?php

/**
*
*Установка модуля Просмотренные товары
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

class Viewed_install extends Install
{
    /**
     * @var string название
     */
    public $title = "Просмотренные товары";

    /**
     * @var array таблицы в базе данных
     */
    public $tables = array(
		array(
			"name" => "viewed",
			"fields" => array(
				array(
					"name" => "id",
					"type" => "INT(11) UNSIGNED NOT NULL AUTO_INCREMENT",
				),
				array(
					"name" => "user_id",
					"type" => "INT(11) UNSIGNED NOT NULL DEFAULT '0'",
				),
				array(
					"name" => "created",
					"type" => "INT(10) UNSIGNED NOT NULL DEFAULT '0'",
				),
				array(
					"name" => "text",
					"type" => "text NOT NULL DEFAULT ''",
				),
				array(
					"name" => "sort",
					"type" => "INT(11) UNSIGNED NOT NULL DEFAULT '0'",
				),
				array(
					"name" => "act",
					"type" => "ENUM('0', '1') NOT NULL DEFAULT '0'",
				),
				array(
					"name" => "trash",
					"type" => "ENUM('0', '1') NOT NULL DEFAULT '0'",
				),
			),
			"keys" => array(
				"PRIMARY KEY (id)",
			),
		),
	);

    /**
     * @var array записи в таблице {modules}
     */
    public $modules = array(
        array(
            "name" => "viewed",
            "admin" => false,
            "site" => true,
            "site_page" => true,
        ),
    );

}