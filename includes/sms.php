<?php
/**
 * @package    DIAFAN.CMS
 *
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
 * SMS
 * Набор функций для отправки SMS
 */
class SMS
{
	/**
	 * Отправляет SMS
	 * @param string $text текст SMS
	 * @param string $to номер получателя
	 * @param string $error_output вывод ошибки
	 * @param string $trace_output вывод трассировки
	 * @return void
	 */
	public static function send($text, $to, &$error_output = '', &$trace_output = '')
	{
		if(! SMS)
		{
			return;
		}
		$to = preg_replace('/[^0-9]+/', '', $to);
		Custom::inc('includes/validate.php');
		if($error = Validate::phone($to))
		{
			return $error;	
		}
		$text = urlencode(str_replace("\n", "%0D", substr($text, 0, 800)));
		// TO_DO: byteHand
		// $fp = @fsockopen('bytehand.com', 3800, $errno, $errstr);
		// if($fp)
		// {
			$opts = array(
				'http'=>array(
					'ignore_errors'=> TRUE,
				)
			);
			$context = stream_context_create($opts);
			// TO_DO: byteHand
			//$result = file_get_contents("http://bytehand.com:3800/send?id=".urlencode(SMS_ID)."&key=".urlencode(SMS_KEY)."&to=".$to."&from=".urlencode(SMS_SIGNATURE)."&text=".$text, FALSE, $context);
			// TO_DO: SMSC
			$result = file_get_contents("https://smsc.ru/sys/send.php?login=".urlencode(SMS_ID)."&psw=".urlencode(SMS_KEY)."&phones=".$to."&sender=".urlencode(SMS_SIGNATURE)."&mes=".$text."&charset=utf-8&fmt=3", FALSE, $context);

			$trace_output = implode(PHP_EOL, $http_response_header)."\n\n".$result;

			$http_code = false;
			if(! empty($http_response_header[0]))
			{
				preg_match('/\d{3}/', $http_response_header[0], $matches);
				if(! empty($matches[0]))
				{
					$http_code = $matches[0];
				}
			}
		// TO_DO: byteHand
		// }
		// else
		// {
		// 	if($errno == 0)
		// 	{
		// 		$error_output = 'ERROR: socket initialization';
		// 	}
		// 	else
		// 	{
		// 		$error_output = 'ERROR '.$errno.': '.$errstr;
		// 	}
		// 	$trace_output = 'Socket is not initialized';
		// 	return false;
		// }

		$result = json_decode($result);

		// проверка на ошибки
		// TO_DO: byteHand
		// if (! is_object($result) || ! isset($result->status) || ! isset($result->description))
		// TO_DO: SMSC
		if (! is_object($result))
		{
			$error_output = 'ERROR: Bad response';
			return false;
		}

		// TO_DO: byteHand
		// if($result->status != 0 || $http_code != 200)
		// TO_DO: SMSC
		if(isset($result->error) || $http_code != 200)
		{
			// TO_DO: byteHand
			// $error_output = 'ERROR '.$result->status.': '.$result->description;
			// TO_DO: SMSC
			$error_output = 'ERROR '.$result->error.(isset($result->error_code) ? ': '.$result->error_code : '');
			return false;
		}
		else $error_output = '';

		return true;
	}
}
