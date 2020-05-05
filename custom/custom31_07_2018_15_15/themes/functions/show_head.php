<?php

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

if($this->diafan->configmodules("redhelper_login", "consultant"))
{
	echo "\n".'<meta http-equiv="X-UA-Compatible" content="IE=8">'
	."\n".'<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8"> ';
}
//if($this->diafan->_site->canonical)
//{
//	if(substr($this->diafan->_site->canonical, 0, 4) != 'http')
//	{
//		if(substr($this->diafan->_site->canonical, 0, 1) == '/')
//		{
//			$this->diafan->_site->canonical = 'http'.(IS_HTTPS ? "s" : '').'://'.BASE_URL.$this->diafan->_site->canonical;
//		}
//		else
//		{
//			$this->diafan->_site->canonical = BASE_PATH_HREF.$this->diafan->_site->canonical;
//		}
//	}
//	echo "\n".'<link href="'.$this->diafan->_site->canonical.'" rel="canonical">';
//}

$canonical = BASE_PATH_HREF.$this->diafan->_site->rewrite.'/';
echo '<link rel="canonical" href="'.$canonical.'"/>';

echo '
<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-TileImage" content="/mstile-144x144.png">
<meta name="theme-color" content="#ffffff">
<meta property="og:title" content="LiftShop24.ru"/>
<meta property="og:description" name="description" content="Продажа запчастей для лифтов и эскалаторов"/>
<meta property="og:image" content="https://liftshop24.ru/custom/custom31_07_2018_15_15/img/logo.png"/>
<meta property="og:type" content="website">
<meta property="og:url" content= "https://liftshop24.ru" />
';

echo '
<meta name="robots" content="';
if($this->diafan->_site->noindex)
{
	echo 'noindex';
}
else
{
	echo 'all';
}
echo '">';

echo "\n".'<title>';
echo $this->functions('show_title', array());
echo '</title>
<meta charset="utf-8">
<meta content="Russian" name="language">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="';
echo $this->functions('show_description', array());
echo '">
<meta name="keywords" content="';
$this->functions('show_keywords', array());
echo '">';

if ($this->diafan->_site->edit_meta)
{
	$useradmin_links = $this->diafan->_useradmin->get_meta($this->diafan->_site->edit_meta["id"], $this->diafan->_site->edit_meta["table"]);
}
else
{
	$useradmin_links = $this->diafan->_useradmin->get_meta($this->diafan->_site->id, 'site');
}
if(! empty($useradmin_links))
{
	echo '<meta name="useradmin_title" content="'.$useradmin_links["title_meta"].'">';
	echo '<meta name="useradmin_description" content="'.$useradmin_links["descr"].'">';
	echo '<meta name="useradmin_keywords" content="'.$useradmin_links["keywords"].'">';
}
