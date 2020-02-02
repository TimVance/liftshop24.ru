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

ob_start();
$this->functions('show_h1');
$name = ob_get_contents();
ob_end_clean();
if ($name)
{
	echo '<h1>'.$name.'</h1>';
}

$this->functions('show_text');
$this->functions('show_module');