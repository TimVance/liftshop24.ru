<?php
/**
 * Шаблонный тег: выводит текст страницы. 
 *
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2017 OOO «Диафан» (http://www.diafan.ru/)
 */

if (! defined('DIAFAN'))
{
	$path = __FILE__; $i = 0;
	while(! file_exists($path.'/includes/404.php'))
	{
		if($i == 10) exit; $i++;
		$path = dirname($path);
	}
	include $path.'/includes/404.php';
}

if (! $this->diafan->_route->show && ! $this->diafan->_route->brand && ! $this->diafan->_route->cat && ! $this->diafan->_route->step && empty($_GET["action"]))
{
	$text = $this->diafan->_route->replace_id_to_link($this->diafan->_site->text);
	$text = $this->diafan->_useradmin->get($text, 'text', $this->diafan->_site->id, 'site', _LANG);

	if($this->diafan->configmodules("keywords", "site"))
	{
		$this->diafan->_keywords->get($text);
	}
	if ($text) $text = '<div class="desc_text">'.$text.'</div>';
	echo $this->get_function_in_theme($text);
}