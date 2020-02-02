<?php

	header("Content-type: UTF-8");

	$log = '';
	$logfile = fopen('log.txt', 'a');

	function writeValute($usd, &$log) {

		$db = mysql_connect("localhost","liftshop24_otis","2qW6fSGg");
		mysql_select_db("liftshop24_otis" ,$db);
		$sql = mysql_query("SELECT `exchange_rate` FROM `prdl_shop_currency` WHERE `name` = 'USD'", $db);
		$rows = mysql_fetch_row($sql);

		if($rows[0] != $usd) {
			$sql = mysql_query("UPDATE `prdl_shop_currency` SET `exchange_rate`='".$usd."' WHERE `name`='USD'", $db);
		}
		else {
			$log .= 'VALUTE NOT CHANGED!';
			echo 'VALUTE NOT CHANGED!';
			return false;
		}

		mysql_close($db);
		return true;
	}

	function readValute($url) {
		return file_get_contents($url);
	}

	function searchValute($file, $pattern) {
		preg_match($pattern, $file, $matches);
		return $matches;
	}

	function writeLog($logfile, $log) {
		$log .= " - ".date("Y-m-d H:i:s", time());
		fputs($logfile,$log."\n");
		fclose($logfile);
	}

	$valuteID = 'R01235';
	$url = 'http://www.cbr.ru/scripts/XML_daily.asp?d=0&VAL_NM_RQ='.$valuteID;
	$pattern ="/<Valute ID=\"R01235\">.+Value>(.+)<\/Value.+R01239/s";

	$file = readValute($url);
	$usd = searchValute($file, $pattern);

	$courseUSD = round($usd[1]);

	if (writeValute($courseUSD, $log)) { $log .= "UPDATED VALUTE SUCCESS!";  echo "UPDATED VALUTE SUCCESS!";}

	writeLog($logfile, $log);