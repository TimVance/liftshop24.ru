<?php
/**
 * Общие функции ядра
 *
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2018 OOO «Диафан» (http://www.diafan.ru/)
 */

if (! defined('DIAFAN'))
{
	$path = __FILE__;
	while(! file_exists($path.'/includes/404.php'))
	{
		$parent = dirname($path);
		if($parent == $path) exit;
		$path = $parent;
	}
	include $path.'/includes/404.php';
}

/**
 * Core
 *
 * Общие функции ядра
 */
abstract class Core
{
	/**
	 * @var array настройки модуля
	 */
	private $configmodules = array();

	/**
	 * @var array кэш родителей
	 */
	private $get_parents_cache = array();

	/**
	 * @var string версия сборки
	 */
	private $version_core = false;

	/**
	 * @var array уникальные идентификаторы
	 */
	private $uids = array();

	/**
	 * @var array кэш для значений доменного имени
	 */
	private $domain = array();

	/**
	 * Numeric status code, 200: OK
	 */
	const HTTP_OK = 200;

	/**
	 * Numeric status code, 503: Service Unavailable
	 */
	const HTTP_SERVICE_UNAVAILABLE = 503;

	/**
	 * Редирект
	 *
	 * @param string $url URL для редиректа
	 * @param integer $http_response_code статус-код
	 * @return void
	 */
	public function redirect($url = '', $http_response_code = 302)
	{
		if (substr($url, 0, 4) != 'http')
		{
			$url = BASE_PATH_HREF.$url;
		}
		$url = str_replace(array("\n", "\r", '&amp;'), array('', '', '&'), $url);
		header('Location: '.$url, true, $http_response_code);
		exit;
	}

	/**
	 * Редиректс помошью JavaScript
	 *
	 * @param string $url URL для редиректа
	 * @param boolean $no_history не сохранять исходную страницу в истории сеансов
	 * @return void
	 */
	public function redirect_js($url = '', $no_history = false)
	{
		if (substr($url, 0, 4) != 'http')
		{
			$url = BASE_PATH_HREF.$url;
		}

		$url = str_replace(array("\n", "\r"), '', $url);
		echo '<script language="javascript" type="text/javascript">'
			.(! $no_history ? 'window.location.href=\''.$url.'\';' : 'window.location.replace(\''.$url.'\');')
			.'</script>';
		exit;
	}

	/**
	 * Приводит значение переменной к типу, соответстветствующему маске
	 *
	 * @param mixed $array исходное значение или массив с исходным значением
	 * @param string $mask тип преобразования: *url* – преобразует строку для использования ее в ссылке, *sql* – переменную можно вставлять непосредственно в SQL-запрос, *int* – оставляет только числа, *float* – дискретное число, *string* – удаляются HTML-теги, специальные символы преобразуются
	 * @param string $name имя переменной в массиве
	 * @param mixed $default значение по-умолчанию
	 * @return mixed
	 */
	public function filter($array, $mask = 0, $name = '', $default = '')
	{
		if(! $default)
		{
			switch($mask)
			{
				case 'url':
				case 'string':
				case 'sql':
					$default = '';
					break;
	
				case 'int':
				case 'integer':
				case 'float':
					$default = 0;
					break;
	
				default:
					$default = null;
					break;
			}
		}
		if(is_array($array) && $name)
		{
			if (array_key_exists($name, $array))
			{
				$value = $array[$name];
			}
			else
			{
				return $default;
			}
		}
		else
		{
			$value = $array;
		}
		if (is_array($value))
		{
			return $value;
		}
		switch($mask)
		{
			case 'url':
				return urlencode($value);

			case 'string':
				return trim(htmlspecialchars(strip_tags($value)));

			case 'sql':
				return addslashes(str_replace("%", "%%", $value));

			case 'int':
			case 'integer':
				return (int) preg_replace("/\D/", "", $value);

			case 'float':
				return (float) preg_replace("/[^0-9\.+]/", "", str_replace(',', '.', $value));

			default:
				return trim($value);
		}
	}

	/**
	 * Возвращает значение переменной $name в конфигурации модуля $module_name для языковой версии
	 * $lang_id и страницы $site_id. Если задано значение $value, функция записывает новое значение.
	 *
	 * @param string $name имя переменной в конфигурации
	 * @param string $module_name название модуля
	 * @param integer $site_id раздел сайта
	 * @param integer $lang_id номер языковой версии
	 * @param boolean $value новое значение
	 * @return mixed
	 */
	public function configmodules($name, $module_name = '', $site_id = false, $lang_id = false, $value = false)
	{
		if($lang_id  === false)
		{
			if(defined('_LANG'))
			{
				$lang_id = _LANG;
			}
			else
			{
				$lang_id = 1;
			}
		}
		if (! $site_id)
		{
			if($site_id === false)
			{
				if (IS_ADMIN)
				{
					$site_id = $this->_route->site;
				}
				else
				{
					$site_id = $this->_site->id;
				}
			}
			if (! $site_id)
			{
				$site_id = 0;
			}
		}
		if (! $module_name)
		{
			if (IS_ADMIN)
			{
				$module_name = $this->_admin->module;
			}
			else
			{
				$module_name = $this->_site->module;
			}
		}
		if (empty($this->configmodules))
		{
			$rs = DB::query_fetch_all("SELECT * FROM {config}");
			foreach($rs as $r)
			{
				$this->configmodules[$r["module_name"]][$r["site_id"].$r["name"].$r["lang_id"]] = $r["value"];
			}
		}
		if(IS_DEMO && (! defined('IS_INSTALL') || ! IS_INSTALL) && ! $this->configmodules)
		{
			return;
		}
		if($value !== false)
		{
			if(isset($this->configmodules[$module_name][$site_id.$name.$lang_id]))
			{
				if($this->configmodules[$module_name][$site_id.$name.$lang_id] != $value)
				{
					if(! $value && (! $site_id || empty($this->configmodules[$module_name]['0'.$name.$lang_id])))
					{
						DB::query("DELETE FROM {config} WHERE module_name='%h' AND site_id=%d AND name='%h' AND lang_id=%d", $module_name, $site_id, $name, $lang_id);
					}
					else
					{
						DB::query("UPDATE {config} SET value='%s' WHERE module_name='%h' AND site_id=%d AND name='%h' AND lang_id=%d", $value, $module_name, $site_id, $name, $lang_id);
					}
				}
			}
			else
			{
				DB::query("INSERT INTO {config} (value, module_name, site_id, name, lang_id) VALUES ('%s', '%h', %d, '%h', %d)", $value, $module_name, $site_id, $name, $lang_id);
			}
			$this->configmodules[$module_name][$site_id.$name.$lang_id] = $value;
			return;
		}
		if(! $this->configmodules)
		{
			return;
		}
		$value = false;
		if (isset($this->configmodules[$module_name][$site_id.$name.$lang_id]))
		{
			$value = $this->configmodules[$module_name][$site_id.$name.$lang_id];
		}
		elseif ($lang_id && isset($this->configmodules[$module_name]['0'.$name.$lang_id]))
		{
			$value = $this->configmodules[$module_name]['0'.$name.$lang_id];
		}
		elseif (isset($this->configmodules[$module_name][$site_id.$name.'0']))
		{
			$value = $this->configmodules[$module_name][$site_id.$name.'0'];
		}
		elseif (isset($this->configmodules[$module_name]['0'.$name.'0']))
		{
			$value = $this->configmodules[$module_name]['0'.$name.'0'];
		}
		return $value;
	}

	/**
	 * Сокращает текст
	 *
	 * @param string $text исходный текст
	 * @param integer $length количество символов для сокращения
	 * @return string
	 */
	public function short_text($text, $length = 80)
	{
		$text = strip_tags($text);
		if(strlen($text) > 100000)
		{
			$text = substr($text, 0, 100000);
		}
		if (utf::strlen($text) > $length + 20)
		{
			$cut_point = utf::strlen($text) - utf::strlen(utf::stristr(utf::substr($text, $length), " "));
			$text = utf::substr($text, 0, $cut_point).'...';
		}
		return $text;
	}

	/**
	 * Подготавливает текст для отображения в XML-файле
	 *
	 * @param string $text исходный текст
	 * @return string
	 */
	public function prepare_xml($text)
	{
		$repl = array('&nbsp;', '"','&','>','<',"'");
		$replm = array(' ', '&quot;', '&amp;', '&gt;', '&lt;', '&apos;');
		
		$text = str_replace($repl, $replm, strip_tags($text));
		return $text;
	}

	/**
	 * Конвертирует количество бит в байты, килобайты, мегабайты
	 *
	 * @param integer $size размер в байтах
	 * @return string
	 */
	public function convert($size)
	{
		if (!$size)
		{
			return '';
		}
		$measure = array('b', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb', 'Eb', 'Zb', 'Yb');
		return round($size / pow(1024, ($exp = floor(log($size, 1024)))), 2).' '.$measure[$exp];
	}

	/**
	 * Кодирует пароль
	 *
	 * @param string $text исходный пароль
	 * @return string
	 */
	public function encrypt($text)
	{
		return md5($text);
	}

	/**
	 * Выдает массив номеров детей
	 *
	 * @param integer $id номер исходного элемента
	 * @param string $table таблица
	 * @param boolean $trash не учитывать элементы, удаленные в корзину
	 * @return array
	 */
	public function get_children($id, $table, $trash = true)
	{
		$chidren = DB::query_fetch_value("SELECT element_id FROM {".$table."_parents} WHERE parent_id=%d".(! in_array($table, array("trash", "admin")) ? " AND trash='0'": ''), $id, "element_id");
		return $chidren;
	}

	/**
	 * Выдает массив номеров родителей
	 *
	 * @param integer|array $id номер исходного элемента
	 * @param string $table таблица
	 * @return array
	 */
	public function get_parents($id, $table)
	{
		if(is_array($id))
		{
			$id = preg_replace('/[^0-9\,]+/', '', implode(',', $id));
			$where = ' IN (%s)';
		}
		else
		{
			$where = '=%d';
		}
		$parents = DB::query_fetch_value("SELECT parent_id FROM {".$table."_parents} WHERE element_id".$where
			.(! in_array($table, array("trash", "admin")) ? " AND trash='0'": ''), $id, "parent_id");
		return $parents;
	}

	/**
	 * Переводит кириллицу в транслит для строки text
	 *
	 * @param string $text исходный текст
	 * @return string
	 */
	public function translit($text)
	{
		$ru = array('а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ы', 'э', 'ю', 'я', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ы', 'Э', 'Ю', 'Я', ' ');

		$tr = array('a', 'b', 'v', 'g', 'd', 'e', 'yo', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'kh', 'ts', 'ch', 'sh', 'sch', 'y', 'e', 'yu', 'ya', 'A', 'B', 'V', 'G', 'D', 'E', 'YO', 'ZH', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'KH', 'TS', 'CH', 'SH', 'SCH', 'Y', 'E', 'YU', 'YA', '-');

		$ru_first = array('Ё', 'Ж', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ю', 'Я');
		
		$tr_first = array('Yo', 'Zh', 'Kh', 'Ts', 'Ch', 'Sh', 'Sch', 'Yu', 'Ya');
		
		if(! in_array(substr($text, 2, 2), array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ы', 'Э', 'Ю', 'Я')))
		{
			$text = str_replace($ru_first, $tr_first, substr($text, 0, 2)).substr($text, 2);
		}

		return preg_replace('/[^A-Za-z0-9-_\.\/]+/', '', str_replace($ru, $tr, $text));
	}

	/**
	 * Переводит дату из в формата гггг-мм-дд в формат дд.мм.гггг
	 *
	 * @param string $date дата в формате гггг-мм-дд
	 * @return string
	 */
	public function formate_from_date($date)
	{
		if(! preg_match('/^(\d{4})\-(\d{2})\-(\d{2})$/', trim($date), $matches))
		{
			return '00.00.0000';
		}
		list($dummy, $year, $month, $day) = $matches;
		if($day > 31)
		{
			$day = 31;
		}
		if($month > 12)
		{
			$month = 12;
		}
		$date = $day.'.'.$month.'.'.$year;
		return $date;
	}

	/**
	 * Переводит дату из в формата гггг-мм-дд чч:мм в формат дд.мм.гггг чч:мм
	 *
	 * @param string $date дата в формате гггг-мм-дд чч:мм
	 * @return string
	 */
	public function formate_from_datetime($date)
	{
		if(! preg_match('/^(\d{4})\-(\d{2})\-(\d{2})\s+(\d{2})\:(\d{2})$/', trim($date), $matches))
		{
			return '00.00.0000 00:00';
		}
		list($dummy, $year, $month, $day, $hour, $minutes) = $matches;
		if($day > 31)
		{
			$day = 31;
		}
		if($month > 12)
		{
			$month = 12;
		}
		if($hour > 23)
		{
			$hour = 23;
		}
		if($minutes > 59)
		{
			$minutes = 59;
		}
		$date = $day.'.'.$month.'.'.$year.' '.$hour.':'.$minutes;
		return $date;
	}

	/**
	 * Переводит дату из в формата дд.мм.гггг в формат гггг-мм-дд
	 *
	 * @param string $date дата в формате дд.мм.гггг
	 * @return string
	 */
	public function formate_in_date($date)
	{
		if(! preg_match('/^(\d{1,2})\.(\d{1,2})\.(\d{4})$/', trim($date), $matches))
		{
			return '0000-00-00';
		}
		list($dummy, $day, $month, $year) = $matches;
		if($day > 31)
		{
			$day = 31;
		}
		if($month > 12)
		{
			$month = 12;
		}
		$date = $year.'-'.$month.'-'.$day;
		return $date;
	}

	/**
	 * Переводит дату из в формата дд.мм.гггг чч:мм в формат гггг-мм-дд чч:мм
	 *
	 * @param string $date дата в формате дд.мм.гггг чч:мм
	 * @return string
	 */
	public function formate_in_datetime($date)
	{
		if(! preg_match('/^(\d{1,2})\.(\d{1,2})\.(\d{4})\s+(\d{1,2})\:(\d{1,2})$/', trim($date), $matches))
		{
			return '0000-00-00 00:00';
		}
		list($dummy, $day, $month, $year, $hour, $minutes) = $matches;
		if($day > 31)
		{
			$day = 31;
		}
		if($month > 12)
		{
			$month = 12;
		}
		if($hour > 23)
		{
			$hour = 23;
		}
		if($minutes > 59)
		{
			$minutes = 59;
		}
		$date = $year.'-'.$month.'-'.$day.' '.$hour.':'.$minutes;
		return $date;
	}

	/**
	 * Возвращает дату, переданную в формате dd.mm.yyyy hh:ii в виде даты в формате UNIX
	 *
	 * @param string $date дата в формате dd.mm.yyyy hh:ii
	 * @return integer
	 */
	public function unixdate($date)
	{
		if(! $date)
		{
			return 0;
		}
		$return = 0;
		if(preg_match('/^(\d{1,2})\.(\d{1,2})\.(\d{4})\s+(\d{1,2})\:(\d{1,2})$/', trim($date), $matches))
		{
			list($dummy, $day, $month, $year, $hour, $minutes) = $matches;
			if($day > 31)
			{
				$day = 31;
			}
			if($month > 12)
			{
				$month = 12;
			}
			if($hour > 23)
			{
				$hour = 23;
			}
			if($minutes > 59)
			{
				$minutes = 59;
			}
			$return = mktime($hour, $minutes, 0, $month, $day, $year);
		}
		elseif(preg_match('/^(\d{1,2})\.(\d{1,2})\.(\d{4})$/', trim($date), $matches))
		{
			list($dummy, $day, $month, $year) = $matches;
			if($day > 31)
			{
				$day = 31;
			}
			if($month > 12)
			{
				$month = 12;
			}
			$return = mktime(0, 0, 0, $month, $day, $year);
		}
		return $return;
	}

	/*
	 * Борьба с магическими кавычками
	 *
	 * @return void
	 */
	protected function magic_quote_off()
	{
		if (get_magic_quotes_gpc())
		{
			$_GET = $this->stripslashes_array($_GET);
			$_POST = $this->stripslashes_array($_POST);
		}
	}

	/*
	 * Вырезает магические кавычки из массива
	 *
	 * @param array $array исходный массив
	 * @return array
	 */
	protected function stripslashes_array($array)
	{
		if (is_array($array))
		{
			foreach ($array as $key => $value)
			{
				$array[$key] = $this->stripslashes_array($value);
			}
			return $array;
		}
		else
		{
			return stripslashes($array);
		}
	}
	
	/*
	 * Разбивает строку с помощью разделителя и возвращает массив
	 *
	 * @param string $string входная строка
	 * @param string $item_delimiter разделитель строк
	 * @param string $key_delimiter разделитель записи
	 * @return array
	 */
	public function str_to_array($string, $item_delimiter = ';', $key_delimiter = false)
	{
		$result = array();
		if(! is_string($string) || empty($string))
		return $result;
		
		$array = explode($item_delimiter, $string);
		if(! $key_delimiter)
		return $array;
	
		foreach($array as $val)
		{
			list($key, $value) = explode($key_delimiter, $val);
			$result[$key] = $value;
		}
		return $result;
	}
	
	/*
	 * Объединяет элементы массива в строку
	 *
	 * @param array $array входной массив объединяемых строк
	 * @param string $item_delimiter разделитель строк
	 * @param string $key_delimiter разделитель записи
	 * @return string
	 */
	public function array_to_str($array, $item_delimiter = ';', $key_delimiter = false)
	{
		if(! is_array($array) || empty($array))
		return '';
		
		if(! $key_delimiter)
		return implode($item_delimiter, $array);
		
		foreach($array as $key => $value)
		{
			$array[$key] = $key.$key_delimiter.$value;
		}
		return implode($item_delimiter, $array);
	}

	/**
	 * Возвращает версию сборки
	 *
	 * @return string
	 */
	public function version_core()
	{
		if(! $this->version_core)
		{
			if(! $this->version_core = DB::query_result("SELECT version FROM {update_return} WHERE current='1' LIMIT 1"))
			{
				$this->version_core = VERSION_CMS;
			}
		}
		return $this->version_core;
	}
	
	/**
	 * Генерирует уникальный идентификатор
	 *
	 * @param boolean $flag версия идентификатора без сокращения
	 * @return string
	 */
	public function uid($flag = false)
	{
		$mtime = microtime();
		$mtime = explode(" ", $mtime);
		$mtime = $mtime[1] + $mtime[0];
		$mpid = getmypid();
		$hash = md5(uniqid($mtime, 1));
		$value = strtoupper($flag ? $hash.$mpid : substr($hash.$mpid, 1, 8));
		$value = array_key_exists($value, $this->uids) ? $this->uid() : $value;
		$this->uids[$value] = true;
		return $value;
	}

	/**
	 * Возвращает доменное имя
	 *
	 * @param boolean $without_mobile без указания мобильной версии
	 * @return string
	 */
	public function domain($without_mobile = false)
	{
		// поддержка старой версии config.php
		if(! defined('MOBILE_PATH')) define('MOBILE_PATH', 'm');
		if(! defined('MOBILE_SUBDOMAIN')) define('MOBILE_SUBDOMAIN', false);

		if (! isset($this->domain[$without_mobile]))
		{
			require_once(ABSOLUTE_PATH.'plugins/idna.php');
			$IDN = new idna_convert(array('idn_version' => '2008'));
			$domain = $IDN->decode(getenv("HTTP_HOST"));
			$domain = $domain ? $domain : getenv("HTTP_HOST");

			$this->domain[false] = $domain;
			if(MOBILE_VERSION)
			{
				$rew = explode('.', $domain, 2);
				if($rew[0] == MOBILE_PATH)
				{
					if(MOBILE_SUBDOMAIN)
					{
						$domain = (! empty($rew[1]) ? $rew[1] : $domain);
					}
				}
			}
			$this->domain[true] = $domain;
		}
		return $this->domain[$without_mobile];
	}

	/**
	 * Возвращает HTTP статус ответа сервера
	 *
	 * @param string $url URL-адрес
	 * @return string
	 */
	public function get_http_status($url)
	{
		if($ch = curl_init())
		{
			$user_agent = 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0)';
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_VERBOSE, false);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			//curl_setopt($ch, CURLOPT_SSLVERSION, 3);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			$page = curl_exec($ch);

			$err = curl_error($ch);
			if (!empty($err))
			return $err;

			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
		}
		else $httpcode = false;
		return $httpcode;
	}

	/**
	 * Инициализация быстрого запроса
	 *
	 * @param string $url URL-адрес
	 * @param array $params параметры запроса
	 * @param array $method метод передачи параметров": "GET", "POST", "POST_JSON" - метод POST передачи JSON-представления данных
	 * @param boolean $answer вернуть ответ сервера
	 * @param boolean $debug вернуть заголовки запроса и ответа
	 * @return mixed(boolean|string|array)
	 */
	public function fast_request($url, $params = false, $method = "GET", $answer = false, $debug = false)
	{
		if(empty($url))
		{
			return false;
		}
		$answer = $debug ?: $answer;
		if($params)
		{
			switch($method)
			{
				case "POST":
					$post_params = $this->params_encode($params);
					if(! empty($post_params)) $post_string = implode('&', $post_params);
					else $post_string = false;
					break;

				case "POST_JSON":
					Custom::inc('plugins/json.php');
					$post_string = json_encode($params, JSON_UNESCAPED_UNICODE);
					break;

				case "GET":
				default:
					$post_string = http_build_query($params);
					break;
			}
		}
		else $post_string = false;
		$method = ($post_string ? $method : "GET");

		// инициализация cURL
		if($ch = curl_init($url))
		{
			$user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
			$referer    = 'http'.(IS_HTTPS ? "s" : '').'://'.getenv("HTTP_HOST").getenv('REQUEST_URI');
			$options = array(
				CURLOPT_USERAGENT      => $user_agent,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_VERBOSE        => false,
				//CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_MAXREDIRS      => 10,
				//CURLOPT_ENCODING       => "",
				CURLOPT_REFERER        => $referer,
				CURLOPT_AUTOREFERER    => true,
				CURLOPT_CONNECTTIMEOUT => ! $answer ? 1 : 120,
				CURLOPT_TIMEOUT        => ! $answer ? 1 : 120,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HEADER         => (bool) $debug,
				CURLINFO_HEADER_OUT    => (bool) $debug,
			);
			curl_setopt_array($ch, $options);

			if($post_string)
			{
				switch($method)
				{
					case "POST":
					case "POST_JSON":
						// использовать метод POST
						curl_setopt($ch, CURLOPT_POST, true);
						// передаем поля формы
						curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
						break;

					case "GET":
					default:
						// использовать метод GET
						curl_setopt($ch, CURLOPT_URL, $url.'?'.$post_string);
						break;
				}
			}

			if(! $answer)
			{
				curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Expect:'));
			}
			//if($debug)
			//{
			//	curl_setopt($ch, CURLOPT_COOKIEFILE, ABSOLUTE_PATH.'tmp/cookie.log');
			//	curl_setopt($ch, CURLOPT_COOKIEJAR, ABSOLUTE_PATH.'tmp/cookie.log');
			//}

			$content = curl_exec($ch);
			if($debug)
			{
				$err     = curl_errno($ch);
				$errmsg  = curl_error($ch);
				$header  = curl_getinfo($ch);
			}
			elseif($answer)
			{
				$header = array();
			}
			else $header = false;

			curl_close($ch);

			if($debug)
			{
				$header['errno']   = $err;
				$header['errmsg']  = $errmsg;
			}
			if($answer) $header['content'] = $content;
		}
		else return false;

		if($debug)
		{
			$result = $header;
		}
		elseif($answer)
		{
			$result = $header['content'];
		}
		else $result = true;

		return $result;
	}

	/**
	 * Возвращает представление данных для быстрого запроса
	 *
	 * @param array $array массив параметров POST-запроса
	 * @param string $prefix префикс для ключа массива
	 * @return array
	 */
	private function params_encode($array, $prefix = '')
	{
		$result = array();
		if(is_array($array) && ! empty($array))
		{
			foreach($array as $key => $val)
			{
				if (is_array($val))
				{
					$result = array_merge($result, $this->params_encode($val, (! empty($prefix) ? $prefix.'['.$key.']' : $key)));
				}
				else $result[] = (! empty($prefix) ? $prefix.'['.$key.']' : $key).'='.urlencode($val);
			}
		}
		return $result;
	}

	/**
     * Appends the parameters of the object/array $params to the main URL
     *
     * @param string $url
     * @param array|object $params
     * @return string
     */
    public function params_append($url, $params)
    {
		return $url.(! empty($params) ? (strpos($url, '?') === false ? '?' : '&').http_build_query($params) : '');
    }
	
	 /**
	 * Returns the values from a single column of the input array, identified by the $columnKey.
	 * Optionally, you may provide an $indexKey to index the values in the returned array by the values from the $indexKey column in the input array.
	 *
	 * @param array $input A multi-dimensional array (record set) from which to pull a column of values.
	 * @param mixed $columnKey The column of values to return. This value may be the integer key of the column you wish to retrieve, or it may be the string key name for an associative array.
	 * @param mixed $indexKey (Optional.) The column to use as the index/keys for the returned array. This value may be the integer key of the column, or it may be the string key name.
	 * @return array
	 */
	public function array_column($input = null, $columnKey = null, $indexKey = null)
	{
		// Using func_get_args() in order to check for proper number of
		// parameters and trigger errors exactly as the built-in array_column()
		// does in PHP 5.5.
		$argc = func_num_args();
		$params = func_get_args();
		if ($argc < 2) {
			trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
			return null;
		}
		if (!is_array($params[0])) {
			trigger_error(
				'array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given',
				E_USER_WARNING
			);
			return null;
		}
		if (!is_int($params[1])
			&& !is_float($params[1])
			&& !is_string($params[1])
			&& $params[1] !== null
			&& !(is_object($params[1]) && method_exists($params[1], '__toString'))
		) {
			trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
			return false;
		}
		if (isset($params[2])
			&& !is_int($params[2])
			&& !is_float($params[2])
			&& !is_string($params[2])
			&& !(is_object($params[2]) && method_exists($params[2], '__toString'))
		) {
			trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
			return false;
		}
		$paramsInput = $params[0];
		$paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;
		$paramsIndexKey = null;
		if (isset($params[2])) {
			if (is_float($params[2]) || is_int($params[2])) {
				$paramsIndexKey = (int) $params[2];
			} else {
				$paramsIndexKey = (string) $params[2];
			}
		}
		$resultArray = array();
		foreach ($paramsInput as $row) {
			$key = $value = null;
			$keySet = $valueSet = false;
			if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
				$keySet = true;
				$key = (string) $row[$paramsIndexKey];
			}
			if ($paramsColumnKey === null) {
				$valueSet = true;
				$value = $row;
			} elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
				$valueSet = true;
				$value = $row[$paramsColumnKey];
			}
			if ($valueSet) {
				if ($keySet) {
					$resultArray[$key] = $value;
				} else {
					$resultArray[] = $value;
				}
			}
		}
		return $resultArray;
	}
}
