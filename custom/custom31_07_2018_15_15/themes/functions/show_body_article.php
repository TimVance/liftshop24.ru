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
	echo '<h1 class="titleblock">'.$name.'</h1>';
}
echo '<div class="sitecontent"><article>';
$this->functions('show_text');
echo '</article>';
echo '<div class="feedback-wrapper">';
$this->functions('show_module');
echo '</div>';