<?php
/**
 * Установка модуля
 *
 * @package    Diafan.CMS
 * @author     diafan.ru
 * @version    5.4
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2018 OOO «Диафан» (http://www.diafan.ru/)
 */

if (! defined("DIAFAN"))
{
	$path = __FILE__; $i = 0;
	while(! file_exists($path.'/includes/404.php'))
	{
		if($i == 10) exit; $i++;
		$path = dirname($path);
	}
	include $path.'/includes/404.php';
}

class Site_install_demo extends Install
{
	/**
	 * @var array демо-данные
	 */
	public $demo = array(
		"config" => array(
			array(
				"name" => "images_variations_element",
				"value" => "a:2:{i:0;a:2:{s:4:\"name\";s:5:\"large\";s:2:\"id\";s:1:\"6\";}i:1;a:2:{s:4:\"name\";s:6:\"medium\";s:2:\"id\";s:1:\"6\";}}",
			),
			array(
				"name" => "title_tpl",
				"value" => "%name | liftshop24.ru - запчасти для лифтов и эскалаторов",
			),
			array(
				"name" => "keywords_tpl",
				"value" => "ЛифтШоп24, запчасти для эскалаторов, запчасти для лифтов, купить запчасти лифтовые, купить запчасти эскалаторные, %name",
			),
			array(
				"name" => "descr_tpl",
				"value" => "%name - ЛифтШоп24.ру, у нас можно купить лифтовые и эскалаторные запчасти с доставкой по всей территории России  и странам таможенного союза.",
			),
			array(
				"name" => "images_variations",
				"value" => "",
			),
		),
		"site" => array(
			array(
				"id" => 1,
				"name" => array("Главная страница"),
				"text" => array("<h1>Запчасти для лифтов и эскалаторов</h1> <p>LiftShop24.ru &ndash; представляет услуги по подбору и поставке запчастей для лифтового и эскалаторного оборудования.</p> <p>Работая в лифтовой отросли более 10 лет, мы приобрели&nbsp;бесценный опыт и знания, наладили связи с поставщиками и производителями, поэтому имеем возможность предложить лучшее на рынке.</p>"),
				"rewrite" => "",
				"theme" => "site_start.php",
				"title_no_show" => "1",
				"sort" => 1,
				"menu" => "1",
				"hide_htmleditor" => "text",
			),
			array(
				"id" => 3,
				"sort" => 5,
			),
			array(
				"id" => 2,
				"name" => array("Информация"),
				"text" => array("<p><insert name=\"show_links\" module=\"site\"></insert></p>"),
				"rewrite" => "info",
				"sort" => 2,
				"children" => array(
					array(
						"id" => 4,
						"name" => array("О компании"),
						"text" => array("<p><span itemprop=\"name\">LiftShop24.ru</span> &ndash; представляет услуги по подбору и поставке запчастей для лифтового и эскалаторного оборудования.</p>
<p>Работая, в лифтовой отросли более 10 лет, приобретен бесценный опыт и знания, налажены связи с поставщиками и производителями, что дает возможность предложить лучшее на рынке.</p>
<h2>Наши преимущества</h2>
<p></p>
<div class=\"whymeabout\"><insert name=\"show_block\" module=\"site\" id=\"6\"> </insert></div>
<h2>ГЕОГРАФИЯ НАШИХ ПОСТАВОК</h2>
<p><iframe width=\"100%\" height=\"480\" src=\"https://www.google.com/maps/d/embed?mid=1GSRp7SGXKkD-RNBAKKem017DnbU&hl=ru\"></iframe></p>
<p>Осуществляем поставку лифтов Macpuarsa (Spain), эскалаторов Sjec (China).</p>
<div class=\"flexAround madewrap\"><a href=\"http://www.sjec.com.cn/en/main.asp\"><img src=\"<insert name=\"custom\" path=\"img/sjec.jpg\" absolute=\"true\">\" alt=\"sjec\"></a> <a href=\"http://www.mplifts.com/\"><img src=\"<insert name=\"custom\" path=\"img/mp.jpg\" absolute=\"true\">\" alt=\"mp\"></a></div>"),
						"rewrite" => "o-kompanii",
						"theme" => "site_about.php",
						"sort" => 1,
						"menu" => array("1", "3"),
						"hide_htmleditor" => "text",
					),
					array(
						"id" => 15,
						"name" => array("Оплата и Доставка"),
						"text" => array("<h2>Как оформить заказ</h2>
<ul>
	<li>Выбираем нужное оборудование, нажимаем кнопку <b>&laquo;В корзину&raquo;</b>.</li>
	<li>Переходим в раздел &laquo;Корзина&raquo;, внимательно проверяем наименование и количество оборудования.</li>
	<li>После этого нажимаем кнопку <b>&laquo;Оформить заказ&raquo;</b>.</li>
	<li>Выбираем удобный способ оплаты и тип доставки.</li>
	<li>Подтверждаем оформление заказа.</li>
</ul>
<p>После обработки Вашего заказа, наш представитель свяжется с Вами для уточнения заказа.</p>
<p>Мы вышлем на Ваш электронный адрес счет. <b>Счет актуален 3 дня.</b></p>
<p>Работаем по 100% предоплате. Всё заказываемое оборудование должно быть оплачено в соответствии с выбранным способом оплаты.</p>
<h3>Банковский перевод.</h3>
<p>Для покупателей, которые являются физическими лицами, доступен банковский перевод.</p>
<h3>Безналичная форма оплаты.</h3>
<p>Для покупателей, которые являются юридическими лицами, доступна безналичная форма оплаты.</p>
<hr noshade color=\"#e0e0e0\" size=\"1\">
<h2>ДОСТАВКА</h2>
<div class=\"flexAround dostavka\">
	<div class=\"item\">
		<a rel=\"nofollow\" href=\"https://dostavista.ru/order\"><img src=\"<insert name=\"custom\" path=\"img/dostavista.png\" absolute=\"true\">\" alt=\"Dostavista.ru\"><br />
		Курьерская служба по Москве Dostavista.ru</a>
	</div>
	<div class=\"item\">
		<a rel=\"nofollow\" href=\"https://www.cdek.ru/calculator.html\"><img src=\"<insert name=\"custom\" path=\"img/cdek.png\" absolute=\"true\">\" alt=\"cdek.ru\"><br />
		Курьерская компания СДЭК cdek.ru</a>
	</div>
	<div class=\"item\">
		<a rel=\"nofollow\" href=\"https://www.dellin.ru/requests/\"><img src=\"<insert name=\"custom\" path=\"img/delline.png\" absolute=\"true\">\" alt=\"dellin.ru\"><br />
		Группа компаний &laquo;Деловые Линии&raquo; dellin.ru</a>
	</div>
</div>
<p>Доставка заказов осуществляется по всей территории Российской Федерации и странам Таможенного Союза: Белоруссии, Казахстана, Армении.</p>
<p>Доставка заказов осуществляется силами транспортных компаний Курьерская служба по Москве Dostavista.ru Курьерская компания СДЭК cdek.ru Группа компаний &laquo;Деловые Линии&raquo; dellin.ru на следующий день после оплаты заказа, если товар есть в наличии.</p>
<p>Стоимость доставки рассчитывается отдельно исходя из заказанного количества товара, веса, размеров согласно тарифам курьерской организации.</p>
<p>В случае оплаты услуг транспортной компании Заказчиком, Доставка до приемного терминала транспортной компании осуществляется бесплатно.</p>
<hr>
<h2>САМОВЫВОЗ</h2>
<p>Вы можете самостоятельно осуществить забор заказа с нашего склада. Убедительная просьба заранее созваниваться с нами по телефону и согласовывать время и дату Вашего приезда за заказом. Наш склад находиться по адресу: г. Москва, Можайское шоссе 32</p>"),
						"rewrite" => "oplata-i-dostavka",
						"sort" => 15,
						"menu" => array("1", "3"),
						"hide_htmleditor" => "text",
					),
				),
			),
			array(
				"id" => 17,
				"name" => array("Оборудование"),
				"text" => array("<p><insert name=\"show_links\" module=\"site\"></insert></p>"),
				"rewrite" => "oborudovanie",
				"sort" => 17,
				"hide_htmleditor" => "text",
				"children" => array(
					array(
						"id" => 18,
						"name" => array("Лифтовое оборудование Macpuarsa"),
						"text" => array("<p>Страница в разработке</p>"),
						"rewrite" => "oborudovanie/liftovoe-oborudovanie-macpuarsa",
						"sort" => 18,
					),
					array(
						"id" => 19,
						"name" => array("Эскалаторное оборудование Sjec"),
						"text" => array("<p>Страница в разработке</p>"),
						"rewrite" => "oborudovanie/eskalatornoe-oborudovanie-sjec",
						"sort" => 19,
					),
				),
			),
		),
		"site_blocks" => array(
			array(
				"id" => 1,
				"name" => array("Контакты в шапке сайта"),
				"text" => array("<div> <div class=\"phonetop\"> <div class=\"phone\"><a href=\"tel:+79037907299\">+7 903 790 7299</a></div> <a class=\"callbacklink\" href=\"#\">Заказать обратный звонок</a></div> <div class=\"emailtop\"><a href=\"mailto:liftshop24@mail.ru\" class=\"headmail\">liftshop24@mail.ru</a><br> <a href=\"map:lang_id=1;module_name=site;element_id=4;element_type=element;anchor=feedback;\" class=\"headfeedback\">Связаться с нами</a></div> </div>"),
				"title_no_show" => "1",
				"rel" => 0,
				"hide_htmleditor" => "text",
			),
			array(
				"id" => 2,
				"name" => array("Контакты в футере"),
				"text" => array("<div class=\"bottomaddress\">
	г. Москва, <br /> Можайское шоссе 32
 </div>
 <div class=\"bottomphone\">
 	<a href=\"tel:+79037907299\">+7 903 790 7299</a>
 </div>
 <div class=\"bottomemail\">
 	<a href=\"mailto:liftshop24@mail.ru\">liftshop24@mail.ru</a>
 </div>"),
				"title_no_show" => "1",
				"rel" => 0,
				"hide_htmleditor" => "text",
			),
			array(
				"id" => 3,
				"name" => array("Блок о доставке в карточке товара"),
				"text" => array("<p>Доставка бесплатная*<br>*до 3000 - 300 рублей</p>"),
				"title_no_show" => "1",
				"rel" => 0,
			),
			array(
				"id" => 4,
				"name" => array("Блок о возврате в карточке товара"),
				"text" => array("<p>14 дней возврат/обмен<br> 2 года гарантия</p>"),
				"title_no_show" => "1",
				"rel" => 0,
			),
			array(
				"id" => 5,
				"name" => array("Название сайта в шапке сайта"),
				"text" => array("Продажа запчастей для лифтов и эскалаторов"),
				"title_no_show" => "1",
				"rel" => 0,
				"hide_htmleditor" => "text",
			),
			array(
				"id" => 6,
				"name" => array("Наши преимущества"),
				"text" => array("<div class=\"flexBetween\">
 	<div class=\"item\">
 		<h4 class=\"title\">ЗАПЧАСТИ В НАЛИЧИИ</h4>
 		<img src=\"<insert name=\"custom\" path=\"img/micon1.png\" absolute=\"true\">\" alt=\"Запчасти в наличии\">
 		<span>Широкий ассортимент запчастей на складе</span>
 	</div>
 	<div class=\"item\">
 		<h4 class=\"title\">ИНДИВИДУАЛЬНЫЙ ПОДХОД</h4>
 		<img src=\"<insert name=\"custom\" path=\"img/micon2.png\" absolute=\"true\">\" alt=\"Индивидуальный подход\">
 		<span>Каждый клиент ВАЖЕН для нас</span>
 	</div>
 	<div class=\"item\">
 		<h4 class=\"title\">ЗАПЧАСТИ ПОД ЗАКАЗ</h4>
 		<img src=\"<insert name=\"custom\" path=\"img/micon3.png\" absolute=\"true\">\" alt=\"Запчасти под заказ\">
 		<span>Срок поставки под заказ от 5 до 28 дней</span>
 	</div>
 	<div class=\"item\">
 		<h4 class=\"title\">ДОСТУПНЫЕ ЦЕНЫ</h4>
 		<img src=\"<insert name=\"custom\" path=\"img/micon4.png\" absolute=\"true\">\" alt=\"Доступные цены\">
 		<span>Предлагаем лучшую цену</span>
 	</div>
 	<div class=\"item\">
 		<h4 class=\"title\">ГАРАНТИИ</h4>
 		<img src=\"<insert name=\"custom\" path=\"img/micon5.png\" absolute=\"true\">\" alt=\"Гарантии\">
 		<span>Предоставляем гарантию на все запчасти  </span>
 	</div>
 	<div class=\"item\">
 		<h4 class=\"title\">ДОСТАВКА</h4>
 		<img src=\"<insert name=\"custom\" path=\"img/micon6.png\" absolute=\"true\">\" alt=\"Доставка\">
 		<span>Осуществляем доставку в любой регион России и стран ТС</span>
 	</div>	
 </div>"),
				"title_no_show" => "1",
				"rel" => 0,
				"hide_htmleditor" => "text",
			),
			array(
				"id" => 7,
				"name" => array("Карта Google"),
				"text" => array("<iframe src=\"https://www.google.com/maps/d/u/2/embed?mid=18uIgOtyPBLREANiMBxowVSAJ68w\" width=\"100%\" height=\"480\"></iframe>"),
				"title_no_show" => "1",
				"rel" => 0,
				"hide_htmleditor" => "text",
			),
			array(
				"id" => 8,
				"name" => array("График работы"),
				"text" => array("<p>Пн-Пт с 09.00 до 19.00</p> <p>Сб-Вс выходной</p>"),
				"title_no_show" => "1",
				"rel" => 0,
			),
			array(
				"id" => 9,
				"name" => array("Социальные сети"),
				"text" => array("<div class=\"socblock flexAround\">
 	<a target=\"_blank\" href=\"https://vk.com/liftshop24\">
 		<svg aria-hidden=\"true\" data-prefix=\"fab\" data-icon=\"vk\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 576 512\" class=\"svg-inline--fa fa-vk fa-w-18 fa-2x\"><path fill=\"currentColor\" d=\"M545 117.7c3.7-12.5 0-21.7-17.8-21.7h-58.9c-15 0-21.9 7.9-25.6 16.7 0 0-30 73.1-72.4 120.5-13.7 13.7-20 18.1-27.5 18.1-3.7 0-9.4-4.4-9.4-16.9V117.7c0-15-4.2-21.7-16.6-21.7h-92.6c-9.4 0-15 7-15 13.5 0 14.2 21.2 17.5 23.4 57.5v86.8c0 19-3.4 22.5-10.9 22.5-20 0-68.6-73.4-97.4-157.4-5.8-16.3-11.5-22.9-26.6-22.9H38.8c-16.8 0-20.2 7.9-20.2 16.7 0 15.6 20 93.1 93.1 195.5C160.4 378.1 229 416 291.4 416c37.5 0 42.1-8.4 42.1-22.9 0-66.8-3.4-73.1 15.4-73.1 8.7 0 23.7 4.4 58.7 38.1 40 40 46.6 57.9 69 57.9h58.9c16.8 0 25.3-8.4 20.4-25-11.2-34.9-86.9-106.7-90.3-111.5-8.7-11.2-6.2-16.2 0-26.2.1-.1 72-101.3 79.4-135.6z\" class=\"\"></path></svg>
 	</a>
 	<a target=\"_blank\" href=\"https://www.facebook.com/RusGilmutdinov\">
 		<svg aria-hidden=\"true\" data-prefix=\"fab\" data-icon=\"facebook-f\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 264 512\" class=\"svg-inline--fa fa-facebook-f fa-w-9 fa-2x\"><path fill=\"currentColor\" d=\"M76.7 512V283H0v-91h76.7v-71.7C76.7 42.4 124.3 0 193.8 0c33.3 0 61.9 2.5 70.2 3.6V85h-48.2c-37.8 0-45.1 18-45.1 44.3V192H256l-11.7 91h-73.6v229\" class=\"\"></path></svg>
 	</a>
 </div>"),
				"title_no_show" => "1",
				"rel" => 0,
				"hide_htmleditor" => "text",
			),
			array(
				"id" => 10,
				"name" => array("Социальные сети в шапке"),
				"text" => array("<a target=\"_blank\" title=\"Написать нам на WhatsApp\" href=\"https://wa.me/79037907299\" class=\"item\"><svg aria-hidden=\"true\" data-prefix=\"fab\" data-icon=\"whatsapp\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 448 512\" class=\"svg-inline--fa fa-whatsapp fa-w-14 fa-2x\"><path fill=\"currentColor\" d=\"M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z\" class=\"\"></path></svg></a>
<a target=\"_blank\" title=\"Читайте нас на VK\" href=\"https://vk.com/liftshop24\" class=\"item\"><svg aria-hidden=\"true\" data-prefix=\"fab\" data-icon=\"vk\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 576 512\" class=\"svg-inline--fa fa-vk fa-w-18 fa-2x\"><path fill=\"currentColor\" d=\"M545 117.7c3.7-12.5 0-21.7-17.8-21.7h-58.9c-15 0-21.9 7.9-25.6 16.7 0 0-30 73.1-72.4 120.5-13.7 13.7-20 18.1-27.5 18.1-3.7 0-9.4-4.4-9.4-16.9V117.7c0-15-4.2-21.7-16.6-21.7h-92.6c-9.4 0-15 7-15 13.5 0 14.2 21.2 17.5 23.4 57.5v86.8c0 19-3.4 22.5-10.9 22.5-20 0-68.6-73.4-97.4-157.4-5.8-16.3-11.5-22.9-26.6-22.9H38.8c-16.8 0-20.2 7.9-20.2 16.7 0 15.6 20 93.1 93.1 195.5C160.4 378.1 229 416 291.4 416c37.5 0 42.1-8.4 42.1-22.9 0-66.8-3.4-73.1 15.4-73.1 8.7 0 23.7 4.4 58.7 38.1 40 40 46.6 57.9 69 57.9h58.9c16.8 0 25.3-8.4 20.4-25-11.2-34.9-86.9-106.7-90.3-111.5-8.7-11.2-6.2-16.2 0-26.2.1-.1 72-101.3 79.4-135.6z\" class=\"\"></path></svg></a>
 <a target=\"_blank\" title=\"Читайте нас на FB\" href=\"https://www.facebook.com/RusGilmutdinov\" class=\"item\"><svg aria-hidden=\"true\" data-prefix=\"fab\" data-icon=\"facebook-f\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 264 512\" class=\"svg-inline--fa fa-facebook-f fa-w-9 fa-2x\"><path fill=\"currentColor\" d=\"M76.7 512V283H0v-91h76.7v-71.7C76.7 42.4 124.3 0 193.8 0c33.3 0 61.9 2.5 70.2 3.6V85h-48.2c-37.8 0-45.1 18-45.1 44.3V192H256l-11.7 91h-73.6v229\" class=\"\"></path></svg></a>"),
				"title_no_show" => "1",
				"rel" => 0,
				"hide_htmleditor" => "text",
			),
			array(
				"id" => 11,
				"name" => array("Название блока акции"),
				"text" => array("Спецпредложение"),
				"title_no_show" => "1",
				"rel" => 0,
				"hide_htmleditor" => "text",
			),
			array(
				"id" => 12,
				"name" => array("Рекизиты"),
				"text" => array("<p>Индивидуальный предприниматель<br>Гильмутдинов Руслан Камилевич<br><br> ИНН 773173095712<br> ОГРНИП 317774600171752<br> Расчётный счёт 40802810410160000049<br> Корреспондентский счёт 30101810600000000750<br> БИК банка 46126750<br>РЯЗАНСКИЙ ФИЛИАЛ АО \"АВТОГРАДБАНК\"Г. РЯЗАНЬ</p>"),
				"title_no_show" => "1",
				"rel" => 0,
			),
		),
		"site_dynamic" => array(
			array(
				"id" => 1,
				"name" => array("Источник новости и автор текста"),
				"type" => "editor",
				"module" => "site",
			),
		),
	);
}