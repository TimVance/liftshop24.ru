<?php
/**
 * Файл конфигурации
 *
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2018 OOO «Диафан» (http://www.diafan.ru/)
 */

if (! defined('DIAFAN'))
{
	include dirname(__FILE__).'/includes/404.php';
}

//папка, в которой лежит сайт. Для корня домена оставьте пустым
define("REVATIVE_PATH", '');

//название сайта, добавляется к тегу title в конце через дефис
define("TIT1", 'LiftShop24.ru');

//параметры подключения к БД
define("DB_URL", 'mysqli://liftshop24_otis:2qW6fSGg@localhost/liftshop24_otis');

//префикс таблиц сайта в БД
define("DB_PREFIX", 'prdl_');

//кодировка БД
define("DB_CHARSET", 'utf8');

//название папки с визуальным редактором
define("USERFILES", 'userfls');

//версия DIAFAN.CMS
define("VERSION_CMS", "6.0");

//ЧПУ папки панели администрирования
define("ADMIN_FOLDER", 'closedaccess');

//мобильная версия true/false (да/нет)
define("MOBILE_VERSION", false);

//имя мобильной версии в url-адресе
define("MOBILE_PATH", 'm');

//использовать имя мобильной версии в качестве поддомена true/false (да/нет)
define("MOBILE_SUBDOMAIN", false);

//источник загрузки JS-библиотек: 1 - Google CDN, 2 - Yandex CDN, 3 - Microsoft CDN, 4 - CDNJS CDN, 5 - jQuery CDN, 6 - Hosting
define("SOURCE_JS", 1);

//demo-версия true/false (да/нет)
define("IS_DEMO", false);

//включить режим разработки, когда на сайт выводятся все возможные ошибки true/false (да/нет)
define("MOD_DEVELOPER", false);

//показывать ошибки только администратору true/false (да/нет)
define("MOD_DEVELOPER_ADMIN", true);

//включить режим технического обслуживания сайта, сайт станет недоступен для пользователей (шаблон оформления сообщения в themes/503.php) true/false (да/нет)
define("MOD_DEVELOPER_TECH", false);

//включить режим сжатия HTML-контента true/false (да/нет)
define("MOD_DEVELOPER_MINIFY", true);

//отключить кеширование true/false (да/нет)
define("MOD_DEVELOPER_CACHE", false);

//выводить запросы к БД на сайте true/false (да/нет)
define("MOD_DEVELOPER_PROFILING", false);

//адрес FTP текущего сайта
define("FTP_HOST", '');

//путь к DIAFAN.CMS, после входа ftp-пользователя, например, www/site.ru/docs/
define("FTP_DIR", '');

//имя FTP-пользователя
define("FTP_LOGIN", 'TimVance');

//пароль FTP-пользователя
define("FTP_PASSWORD", 'с18859670');

//главный ящик администратора, владельца сайта, используется по умолчанию во всех уведомлениях
define("EMAIL_CONFIG", 'liftshop24@gmail.com');

//использовать SMTP-авторизацию при отправке почтовых сообщений true/false (да/нет)
define("SMTP_MAIL", false);

//url почтового сервера (например, smtp.site.ru)
define("SMTP_HOST", 'tls://smtp.gmail.com');

//логин почты
define("SMTP_LOGIN", 'liftshop24@gmail.com');

//пароль к почте
define("SMTP_PASSWORD", 'rus1983ru');

//порт (по умолчанию 25)
define("SMTP_PORT", '465');

//экстремальное кэширование
define("CACHE_EXTREME", false);

//использовать Memcached сервер для кэширования
define("CACHE_MEMCACHED", false);

//хост сервера Memcached
define("CACHE_MEMCACHED_HOST", '');

//порт сервера Memcached
define("CACHE_MEMCACHED_PORT", '');

//часовой пояс сайта, в формате http://www.php.net/manual/en/timezones.php
define("TIMEZONE", 'Europe/Moscow');

//конец строки ЧПУ, по умолчанию "/". Можно ввести ".htm"
define("ROUTE_END", '/');

//использовать автоматическое формирование ЧПУ для модулей true/false (да/нет)
define("ROUTE_AUTO_MODULE", true);

//подключить SMS-уведомления true/false (да/нет)
define("SMS", false);

// ключ для сервиса SMS
define("SMS_KEY", '');

// id в системе SMS
define("SMS_ID", '');

// подпись для уведомлений
define("SMS_SIGNATURE", '');

//дата последнего экспорта заказов в систему 1С:Предприятие
define("LAST_1C_EXPORT", '');

// разрешить вставлять во frame
define("NO_X_FRAME", false);

// примененные темы
define("CUSTOM", 'custom31_07_2018_15_15');
