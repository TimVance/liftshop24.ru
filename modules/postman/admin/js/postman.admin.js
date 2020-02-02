/**
 * Редактирование уведомлений, JS-сценарий
 *
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2018 OOO «Диафан» (http://www.diafan.ru/)
 */

$(document).on('change', "#type select[name='type']", function(){
	if($(this).val() == 'sms')
	{
		$("#subject, #from").hide();
		$("#body_mail").hide();
		$("#body_sms").show();
	}
	else
	{
		$("#subject, #from").show();
		$("#body_sms").hide();
		$("#body_mail").show();
	}
});

$("#type select[name='type']").change();
