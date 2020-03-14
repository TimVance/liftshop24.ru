<?php

if (!defined('DIAFAN')) {
    $path = __FILE__;
    $i    = 0;
    while (!file_exists($path . '/includes/404.php')) {
        if ($i == 10) exit;
        $i++;
        $path = dirname($path);
    }
    include $path . '/includes/404.php';
}

if (!empty($result["error"])) {
    echo '<p>' . $result["error"] . '</p>';
    return;
}

if (empty($result["ajax"])) {
    echo '<div class="js_shop_list shop_list_rows">';
}

//вывод списка товаров
if (!empty($result["rows"])) {

    echo '<div class="flexBetween">';
    if (!$result["search"]) echo '<div><h1>Запчасти ' . $result["name"] . '</h1></div>';
    else {
        echo '<div><h1>Результаты поиска</h1></div>';
    }
    //вывод сортировки товаров
    if (!empty($result["link_sort"])) {
        echo $this->get('sort_block', 'shop', $result);
    }
    echo '</div>';
    echo '<div class="shop-pane flexStart">';
    echo $this->get('rows', 'shop', $result);
    echo '</div>';
}

//постраничная навигация
if (!empty($result["paginator"])) {
    echo $result["paginator"];
}


echo '<div class="showother" data="1">Показать еще</div>';
echo '<div class="dataload" style="display:none"></div>';

if (!$result["search"]) {
    if (empty($result["text"]))
        echo '<div class="desc_text">
        
        <h2>Заказать запчасти ' . $result["name"] . '</h2>
        
        <p>В интернет-магазине Liftshop24.ru можно <strong>купить запчасти для лифтов и эскалаторов ' . $result["name"] . '</strong> c доставкой по всей России и странам СНГ. Доставку осуществляем в течении 28 дней.</p>
        <p>Компания ' . $result["name"] . ' производит надежные комплектующие для подъемного оборудования. Высокое качество метариалов обеспечит долгую службу запасных частей ' . $result["name"] . '.</p>
        <p>Лифтшоп24.ру на рынке больше 10-ти лет. За время работы мы приобрели ряд преимуществ, которые выгодно отличают нас от конкурентов:</p>
        <ul>
            <li>Широкий ассортимент товаров</li>
            <li>Индивидуальный подход к каждому клиенту</li>
            <li>Срок поставки от 5 до 28 дней</li>
            <li>Мы предлагаем самые доступные цены</li>
            <li>Гаранимя на всю продукцию</li>
            <li>Доставка в любой регион России и в страны ТС</li>
        </ul>
        <p>Подробную информацию о сроках поставки, наличии запчастей ' . $result["name"] . ' и ценах можно получить по телефону <strong><a href="tel:+79037907299">+7 903 790 7299</a></strong>, <a class="callbacklink bottom">заказав обратный звонок</a> или по почте <a href="mailto:liftshop24@mail.ru">liftshop24@mail.ru</a>.</p>
        </div>';
    else echo '<div class="desc_text">' . $result["text"] . '</div>';
}


//вывод подкатегории
if (!empty($result["children"])) {
    echo '<div class="child-links">Теги: ';
    foreach ($result["children"] as $i => $child) {
        //название и ссылка подкатегории
        echo '<a class="child-link" href="' . BASE_PATH_HREF . $child["link"] . '">' . mb_strtolower($child["name"]) . '</a>';
        if (!empty($result["children"][$i + 1]["name"])) echo ', ';

    }
    echo '</div>';
}


if (!empty($result["rows"]) && empty($result["hide_compare"])) {
    echo $this->get('compared_goods_list', 'shop', array("site_id" => $this->diafan->_site->id, "shop_link" => $result['shop_link']));
}

//вывод ссылок на предыдущую и последующую категории
if (!empty($result["previous"]) || !empty($result["next"])) {
    echo '<div class="previous_next_links">';
    if (!empty($result["previous"])) {
        echo '<div class="previous_link"><a href="' . BASE_PATH_HREF . $result["previous"]["link"] . '">&larr; ' . $result["previous"]["text"] . '</a></div>';
    }
    if (!empty($result["next"])) {
        echo '<div class="next_link"><a href="' . BASE_PATH_HREF . $result["next"]["link"] . '">' . $result["next"]["text"] . ' &rarr;</a></div>';
    }
    echo '</div>';
}

//вывод комментариев ко всей категории товаров (комментарии к конкретному товару в функции id())
if (!empty($result["comments"])) {
    echo $result["comments"];
}

if (empty($result["ajax"])) {
    echo '</div>';
}