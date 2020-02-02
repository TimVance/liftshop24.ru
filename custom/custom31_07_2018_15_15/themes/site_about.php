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
<!DOCTYPE html>
<head>
	<insert name="show_head">
	<insert name="show_css" files="style.css, media.css">
</head>
<body>
	<insert name="show_include" file="header">
	<main class="aboutcompany">
		<div class="container">
			<insert name="show_breadcrumb" current="true">
			<div class="flexBetween">
				<div class="left">
					<insert name="show_search" module="shop">
					<insert name="show_viewed" module="viewed" images="1" maxview="3">
				</div>
				<div class="right" itemscope itemtype="http://schema.org/Organization">
						<insert name="show_body_article">
						<div class="wrapcontacts" id="feedback">
							<h2>Обратная связь</h2><br />
							<div class="flexAround">
								<insert name="show_form" module="feedback">
								<div class="contacts" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
									<div class="item">
										<img class="iconaboutcontact" src="<insert name="custom" path="img/location.png" absolute="true">" width="32px" alt="">
										<div class="textaboutcontact"><span itemprop="streetAddress"><insert name="show_block" id="13" module="site"></span></div>
										<div class="clear"></div>
									</div>
									<div class="item">
										<img class="iconaboutcontact" src="<insert name="custom" path="img/email.png" absolute="true">" width="32px" alt="">
										<div class="textaboutcontact"><a itemprop="email" href="mailto:liftshop24@mail.ru">liftshop24@mail.ru</a></div>
										<div class="clear"></div>
									</div>
									<div class="item">
										<img class="iconaboutcontact" src="<insert name="custom" path="img/phone.png" absolute="true">" width="32px" alt="">
										<div class="textaboutcontact"><a itemprop="telephone" href="tel:+79037907299">+7 903 790 7299</a></div>
										<div class="clear"></div>
									</div>
									<div class="item">
										<img class="iconaboutcontact" src="<insert name="custom" path="img/time.png" absolute="true">" width="32px" alt="">
										<div class="textaboutcontact">Пн-Пт с 09.00 до 19.00</div>
										<div class="clear"></div>
									</div>
									<div class="item"><br /><br /><br />
										<div class="rekvizits"><insert name="show_block" id="12" module="site"></div>
									</div>	
								</div>
							</div>
						</div>
						<insert name="show_block" module="site" id="7">
					</div>
				</div>
			</div>
		</div>
	</main>
	<insert name="show_include" file="footer">
	<insert name="show_js">
	<script type="text/javascript" asyncsrc="<insert name="custom" path="js/main.js" absolute="true" compress="js">" charset="UTF-8"></script>
	<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
</body>
</html>