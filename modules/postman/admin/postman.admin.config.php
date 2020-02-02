<?php
/**
 * Настройки модуля
 * 
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2018 OOO «Диафан» (http://www.diafan.ru/)
 */

if (! defined('DIAFAN'))
{
	$path = __FILE__;
	while(! file_exists($path.'/includes/404.php'))
	{
		$parent = dirname($path);
		if($parent == $path) exit;
		$path = $parent;
	}
	include $path.'/includes/404.php';
}

/**
 * Menu_admin_config
 */
class Postman_admin_config extends Frame_admin
{
	/**
	 * @var array поля в базе данных для редактирования
	 */
	public $variables = array (
		'config' => array (
			'auto_send' => array(
				'type' => 'checkbox',
				'name' => 'Автоматическая отправка уведомлений',
				'help' => 'Если отмечено, отправка уведомлений пройдет в автоматическом режиме. Иначе требуется инициализация отправки уведомлений в административной панели сйта.',
			),
			'mail_defer' => array(
				'type' => 'checkbox',
				'name' => 'Включить отложенную отправку для почты',
				'help' => 'Отправка почтовых уведомлений будет проходить независимо от основных процессов.',
				'depend' => 'auto_send',
			),
			'sms_defer' => array(
				'type' => 'checkbox',
				'name' => 'Включить отложенную отправку для sms',
				'help' => 'Отправка sms уведомлений будет проходить независимо от основных процессов.',
				'depend' => 'auto_send',
			),
			'del_after_send' => array(
				'type' => 'checkbox',
				'name' => 'Удалять отправленные уведомления',
				'help' => 'Автоматическое удаление уведомлений после отправки.',
			),
			
		),
	);

	/**
	 * @var array настройки модуля
	 */
	public $config = array (
		'config', // файл настроек модуля
	);
}