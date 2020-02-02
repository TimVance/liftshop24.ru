<?php
/**
 * Шаблон блока «Сортировать» с ссылками на направление сортировки
 * 
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2017 OOO «Диафан» (http://www.diafan.ru/)
 */

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
       
$link_sort   = $result["link_sort"];
$sort_config = $result['sort_config'];
if ($result["link_sort"][1] != '') $link_nosort = explode("/", $result["link_sort"][1]);
else $link_nosort = explode("/", $result["link_sort"][2]);


echo '<div class="block-sort">';
echo "
Сортировка <select onchange=\"if(this.options[this.selectedIndex].value!=''){window.location=this.options[this.selectedIndex].value}else{this.options[selectedIndex=0];}\">
	<option ".($link_sort[1] && $link_sort[2] && $link_sort[3] && $link_sort[4] ? "value=''" : "value='".BASE_PATH_HREF.$link_nosort[0]."/".$link_nosort[1]."/"."'").">-</option>
 	<option ".($link_sort[1] == '' ? 'selected' : '')." value='".BASE_PATH_HREF.$link_sort[1]."'>Цена по возрастанию</option>
 	<option ".($link_sort[2] == '' ? 'selected' : '')." value='".BASE_PATH_HREF.$link_sort[2]."'>Цена по убыванию</option>
 	<option ".($link_sort[3] == '' ? 'selected' : '')." value='".BASE_PATH_HREF.$link_sort[3]."'>По алфавиту (А-Я)</option>
 	<option ".($link_sort[4] == '' ? 'selected' : '')." value='".BASE_PATH_HREF.$link_sort[4]."'>По алфавиту (Я-А)</option>
</select>
";
echo '</div>';