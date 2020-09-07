<?php
/**
 * Шаблонный тег: подключает CSS-файлы. При включенном режиме разработки файлы будут объеденены и сжаты, что приведет к более быстрой загрузке файлов. Если существуют какие-то проблемы при включенном сжатии, подключите CSS-файлы стандартным HTML-тегом `<link rel="stylesheet" type="text/css"...>`.
 *
 * @param array $attributes атрибуты шаблонного тега
 * files - перечень CSS-файлов, которые нужно подключить. Файлы должны размещаться в папке *css*. Если файлов несколько, то названия должны быть разделены запятыми
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

$attributes = $this->get_attributes($attributes, 'files');

$files = array(Custom::path('adm/css/errors.css'));

$files[] = Custom::path('css/custom-theme/jquery-ui-1.8.18.custom.css');
$files[] = Custom::path('css/jquery.formstyler.css');
$files[] = Custom::path('css/prettyPhoto.css');

$att_files = explode(',', $attributes["files"]);
foreach($att_files as $file)
{
	if(trim($file))
	{
		$files[] = Custom::path('css/'.trim($file));
	}
}

$compress_files = File::compress($files, 'css');
if(is_array($compress_files))
{
	foreach($compress_files as $file)
	{
		echo '<link rel="preload" href="'.BASE_PATH.$file.'?v=20" rel="stylesheet" type="text/css">';
	}
}
else
{
	echo '<link href="'.BASE_PATH.$compress_files.'" rel="stylesheet" type="text/css">';
}

if ($this->diafan->_users->useradmin)
{
	echo '<link href="'.BASE_PATH.Custom::path('modules/useradmin/useradmin.css').'" rel="stylesheet" type="text/css">';
}