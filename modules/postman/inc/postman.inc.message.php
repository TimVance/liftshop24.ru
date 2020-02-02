<?php
/**
 * Подключение модуля «Уведомления» для работы с сообщениями
 *
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2018 OOO «Диафан» (http://www.diafan.ru/)
 */

if ( ! defined('DIAFAN'))
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
 * Postman_inc_message
 */
class Postman_inc_message extends Diafan
{
	/**
	 * Добавляет письмо в список почтовых отправлений
	 *
	 * @param string|array $recipient получатель/получатели
	 * @param string $subject тема письма
	 * @param string $body содержание письма
	 * @param string $from адрес отправителя
	 * @return string
	 */
	public function add_mail($recipient, $subject, $body, $from = '')
	{
		if(! $id = $this->diafan->_postman->db_add($recipient, $subject, $body, $from, 'mail', true))
		{
			return false;
		}

		if($this->diafan->configmodules('auto_send', 'postman'))
		{
			if(! $this->diafan->configmodules('mail_defer', 'postman'))
			{
				$this->send($id);
			}
			else
			{
				$this->diafan->_postman->defer_init();
			}
		}

		return $id;
	}

	/**
	 * Добавляет sms в список почтовых отправлений
	 *
	 * @param string $text текст SMS
	 * @param string $to номер получателя
	 * @return mixed string
	 */
	public function add_sms($text, $to)
	{
		$recipient = $to;
		$subject = '';
		$body = $text;
		$from = '';

		if(! $id = $this->diafan->_postman->db_add($recipient, $subject, $body, $from, 'sms', true))
		{
			return false;
		}

		if($this->diafan->configmodules('auto_send', 'postman'))
		{
			if(! $this->diafan->configmodules('sms_defer', 'postman'))
			{
				$this->send($id);
			}
			else
			{
				$this->diafan->_postman->defer_init();
			}
		}

		return $id;
	}

	/**
	 * Отправляет уведомление
	 *
	 * @param mixed(array|string) $id идентификатор уведомления
	 * @return boolean
	 */
	public function send($id)
	{
		if(! $row = $this->diafan->_db_ex->get('{postman}', $id))
		{
			return false;
		}

		$status = false;
		$row["error"] = $row["trace"] = '';
		$this->diafan->_db_ex->update('{postman}', $row["id"], array("timesent='%d'", "status='%h'", "error='%s'", "trace='%s'"), array(time(), (! $status ? '2' : '1'), $row["error"], $row["trace"]));

		switch ($row["type"])
		{
			case 'mail':
				try {
					if(empty($row["recipient"]))
					{
						throw new Exception('Ошибка: для отправки уведомления необходимо указать адрес получателя.');
					}
					$status = $this->send_mail($row["recipient"], $row["subject"], $row["body"], $row["from"], $row["error"], $row["trace"]);
				} catch (Exception $e) {
					$row["error"] = $e->getMessage();
					$row["trace"] = '';
					$status = false;
				}
				break;

			case 'sms':
				try {
					if(empty($row["recipient"]))
					{
						throw new Exception('Ошибка: для отправки уведомления необходимо указать адрес получателя.');
					}
					if(! defined('SMS') || ! SMS || ! defined('SMS_KEY') || ! SMS_KEY || ! defined('SMS_ID') || ! SMS_ID || ! defined('SMS_SIGNATURE') || ! SMS_SIGNATURE)
					{
						throw new Exception('Ошибка: для отправки уведомления необходимо настроить SMS-уведомления.');
					}
					$status = $this->send_sms($row["body"], $row["recipient"], $row["error"], $row["trace"]);
				} catch (Exception $e) {
					$row["error"] = $e->getMessage();
					$row["trace"] = '';
					$status = false;
				}
				break;

			default:
				return false;
				break;
		}

		if(! $this->diafan->configmodules('del_after_send', 'postman') || ! $status)
		{
			$this->diafan->_db_ex->update('{postman}', $row["id"], array("timesent='%d'", "status='%h'", "error='%s'", "trace='%s'"), array(time(), (! $status ? '2' : '1'), $row["error"], $row["trace"]));
		}
		else
		{
			$this->diafan->_db_ex->delete('{postman}', $id);
		}

		return true;
	}

	/**
	 * Отправляет письмо
	 *
	 * @param string|array $recipient получатель/получатели
	 * @param string $subject тема письма
	 * @param string $body содержание письма
	 * @param string $from адрес отправителя
	 * @param string $error_output вывод ошибки
	 * @param string $trace_output вывод трассировки
	 * @return boolean
	 */
	private function send_mail($recipient, $subject, $body, $from = '', &$error_output = '', &$trace_output = '')
	{
		Custom::inc('includes/mail.php');
		return send_mail($recipient, $subject, $body, $from, $error_output, $trace_output);
	}

	/**
	 * Отправляет sms
	 *
	 * @param string $text текст SMS
	 * @param string $to номер получателя
	 * @param string $error_output вывод ошибки
	 * @param string $trace_output вывод трассировки
	 * @return void
	 */
	private function send_sms($text, $to, &$error_output = '', &$trace_output = '')
	{
		Custom::inc('includes/sms.php');
		return Sms::send($text, $to, $error_output, $trace_output);
	}
}

/**
 * Postman_message_exception
 *
 * Исключение для почтовых отправлений
 */
class Postman_message_exception extends Exception{}
