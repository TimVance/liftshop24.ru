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
?>
					<div class="banner">
						<insert name="show_block" module="shop" count="12" images="1" sort="rand" template="catbanner" action_only="true">
					</div>