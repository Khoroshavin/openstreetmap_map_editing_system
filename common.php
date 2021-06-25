<?php // общий файл: подключаем конфиг, инициализируем сессию, подключаемся к базе

include 'config.php';

session_start();

// собака, чтобы подавить вывод об ошибке с учетными данными БД в браузер
// @ pro vypnuti zobrazeni chyby s udaje db do prohlizece
$db = @mysqli_connect(DB_HOST, DB_LOGIN, DB_PASS, DB_NAME) or die('Mysql connection error');

if (DEBUG) {
	error_reporting(E_ALL);
	ini_set('display_errors', true);
} else {
	error_reporting(false);
	ini_set('display_errors', false);
}

// функция-хелпер mysql запросов, возвращает result.
// в случае ошибки выводит информацию об этом и завершает работу скрипта
// funkce-pomocnik mysql dotazu, vrati result.
// pri chybe zobrazuje info a ukonci script
function query($sql)
{
	global $db;
	// переменная на соединение с БД
	// promenna pro spoj s databaze
	$result = mysqli_query($db, $sql);
	if (!$result) // ошибка запроса - chyba dotazu
	{
		http_response_code(500);
		// если dev - выводим запрос и текст ошибки
		// jestli dev - zobrazi dotaz a chybu
		echo DEBUG ? "QUERY: $sql\nERROR: " . mysqli_error($db) : 'Internal Server Error';
		exit;
	}
	return $result;
}