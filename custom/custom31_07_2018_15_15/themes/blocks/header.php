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
    <div class="wrapper-fixed-header">
        <div class="container flexBetween">
            <div class="logo_fixed"><insert name="show_href" img="favicon-32x32.png" alt="title"></div>
            <div class="phone_fixed"><insert name="show_block" id="14" module="site"></div>
            <insert name="show_block" module="cart" template="fixed">
        </div>
    </div>
	<header>
		<div class="topheader">
			<div class="container flexBetween">
				<div class="namesite">
					<insert name="show_block" module="site" id="5">
                </div>
                <div class="tooglemenu">
                    <div class="lines">
                        <div class="centerline"></div>
                    </div>
                </div>
                <div class="mobile-fixed-phone"><insert name="show_block" id="14" module="site"></div>
				<div class="item flexStart rightheadertop">
					<div class="topsoclinks flexStart">
	                   	<insert name="show_block" module="site" id="10">
	                </div>
					<insert name="show_block" module="cart">
				</div>
			</div>
		</div>
		<div class="bottomheader">
			<div class="container flexBetween">
				<div class="logo"><insert name="show_href" img="img/logo.png" alt="title"></div>
				<insert name="show_search" module="search">
				<insert name="show_block" module="site" id="1">
			</div>
		</div>
	</header>
	<nav>
		<div class="container">
			<insert name="show_block" module="menu" id="1" template="topmenu">
		</div>
	</nav>