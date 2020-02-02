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
	<footer itemscope itemtype="http://schema.org/Organization">
		<div class="container">
			<div class="flexBetween">
				<div class="item">
					<div class="title">Полезная информация</div>
					<insert name="show_block" module="menu" id="3" template="menu">
				</div>
				<div class="item">
					<div class="title">График работы</div>
					<insert name="show_block" module="site" id="8">
				</div>
				<div class="item">
					<div class="title">Социальные сети</div>
					<insert name="show_block" module="site" id="9">
				</div>
				<div class="item">
					<div class="title">Контактные данные</div>
					<insert name="show_block" module="site" id="2">
				</div>
			</div>
			<div class="copyright">
				&copy; <span itemprop="name"><insert name="title"></span> <insert name="show_year" year="2007"><br />
				<a href="https://dlay.ru" class="powered">Разработка интернет-магазинов &ndash; Dlay</a>
			</div>
		</div>
	</footer>
	<div class="modalbg"></div>
	<div class="callbackform">
		<div class="closedModal">x</div>
		<div class="title">Задать вопрос</div>
		<insert name="show_form" module="feedback" site_id="16" template="question">
	</div>
	<div class="successtocart">
		<div class="closedModal">x</div>
		<div class="title">Товар успешно добавлен в корзину!</div>
		<div class="suctocart"><img src="<insert name="custom" path="img/suctocart.png" absolute="true">" alt="Успешно"></div>
		<div class="flexAround">
			<div class="itemcontinue">Продолжить покупки</div>
			<a href="/catalog/cart/" class="itemtocart">Оформить заказ</a>
		</div>
	</div>
	<div class="bottom-cookie-block">
	    <p>Продолжая использовать сайт, вы соглашаетесь на сбор файлов cookie</p>
	    <a href="javascript:void(0);" class="ok">x</a>
	    <a href="/soglasie-na-obrabotku-personalnykh-dannykh/">Подробнее</a>
	</div>
	<!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter45228252 = new Ya.Metrika({ id:45228252, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/45228252" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->