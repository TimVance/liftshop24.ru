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
	<insert name="show_css" files="style.css, slick.css, slick-theme.css, media.css">
</head>
<body>
	<insert name="show_include" file="header">
	<main>
		<section class="container flexBetween startcontent">
			<div class="left">
				<insert name="show_search" module="shop">
				<div class="viewedblock"><insert name="show_viewed" module="viewed" images="1" maxview="1"></div>
			</div>
			<div class="right">
				<div class="sliderwrap"><insert name="show_block" module="bs" cat_id="1" count="all"></div>
				<h2 class="titleblock">О компании</h2>
				<div class="about">
					<insert name="show_body">
				</div>
				<h2 class="titleblock">Лидеры продаж</h2>
				<insert name="show_block" module="shop" sort="sale" count="4" images="1">
				<a href="/catalog/" class="linktocatalog">Полный каталог<i></i></a>
				<h2 class="titleblock">Наши преимущества</h2>
				<div class="whyme">
					<insert name="show_block" module="site" id="6">
				</div>
			</div>
		</section>
		<section class="container">
			<h2 class="titleblock">Партнеры</h2>
			<div class="brands">
				<insert name="show_category" module="shop" images="1">
			</div>
		</section>
	</main>
	<insert name="show_include" file="footer">
	<insert name="show_js">
	<script type="text/javascript" asyncsrc="<insert name="custom" path="js/main.js" absolute="true" compress="js">" charset="UTF-8"></script>
	<script type="text/javascript">
    $(document).on('ready', function() {
	    $(".brands").slick({
	        dots: true,
	        slidesToShow: 5,
	        slidesToScroll: 5,
	        autoplay: true,
	        arrows: true,
	        speed: 2000,
	        responsive: [
		    {
		      breakpoint: 1024,
		      settings: {
		        slidesToShow: 3,
		        slidesToScroll: 3,
		      }
		    },
		    {
		      breakpoint: 600,
		      settings: {
		        slidesToShow: 2,
		        slidesToScroll: 2,
		        dots: false
		      }
		    },
		    {
		      breakpoint: 480,
		      settings: {
		        slidesToShow: 1,
		        slidesToScroll: 1,
		        dots: false
		      }
		    }
		    ]
	    });
	    $(".mainslider").slick({
	        dots: true,
	        arrow: true,
	        autoplay: true,
	        arrows: true
	    });
	});
	</script>
	<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
</body>
</html>