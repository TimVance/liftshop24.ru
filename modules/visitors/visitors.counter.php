<?php
/**
 * Сохранение значений для модуля «Посещаемость»
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
 * Visitors_counter
 */
class Visitors_counter extends Diafan
{
	/**
	 * Инициирует сохранение значений
	 *
	 * @return void
	 */
	public function init()
	{
		if(in_array('visitors', $this->diafan->installed_modules))
		{
			$this->diafan->_visitors->counter_set($_POST);
		}
	}
}

$class = new Visitors_counter($this->diafan);
$class->init();
exit;
