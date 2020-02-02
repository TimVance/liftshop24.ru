<?php
/**
 * Шаблон результатов поиска по сайту
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

echo '<div class="searchpagetop">';

if(! $result["ajax"])
{
	echo $this->htmleditor('<insert name="show_search" module="search">');
}
if (! empty($result["value"]))
{
	if(! $result["ajax"])
	{
		//echo '<p>'.$this->diafan->_('Всего найдено по запросу').' "<b>'.$result["value"].'</b>": '.$result["count"].'</p>';
	}
	else
	{
		if(empty($result["rows"]))
		{
			echo '<p class="no-res">'.$this->diafan->_('Извините, ничего не найдено.').'</p>';
		}
	}
	echo '</div>';
	foreach ($result["rows"] as $module_name => $res)
	{
		if ($module_name != 'shop') continue;
		if (! empty($res["class"]))
		{
			echo $this->get($res["func"], $res["class"], $res);
		}

	}
	echo (!empty($result["paginator"]) ? $result["paginator"] : '');
}
else
{
	if(! $result["ajax"])
	{
		echo '<p>'.$this->diafan->_('Слово для поиска не задано.').'</p>';
	}
}
