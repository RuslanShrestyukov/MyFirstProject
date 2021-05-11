<?php if (!defined('NEWGUARD'))			

exit('Нет доступа');


class DB
{
// use STATIC rendering
	static private $db;	// db handler
 
	static public function init() {
		try {
			self::$db = new PDO(
				"mysql:host=localhost;dbname=;charset=utf8",
				'', '',
				array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8')
			);
			self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//self::$db->exec("SET NAMES utf8"); -- не нужно если сработает PDO::MYSQL_ATTR_INIT_COMMAND?
		}
		catch (PDOException $e)
		{
			die('<h3 style="color: blue">Ошибка соединения с БД. Повторите попытку через полминуты</h3>');
		}
	}
 
	static public function query($sql) {
		return self::$db->query($sql);
	}
 
	static public function exec($sql) {
		return self::$db->exec($sql);
	}
 
	// one column result
	static public function column($sql) {
		return self::$db->query($sql)->fetchColumn();
	}
 
	// intval one column result
	static public function columnInt($sql) {
		return intval(self::$db->query($sql)->fetchColumn());
	}
 
	static public function prepare($sql) {
		return self::$db->prepare($sql);
	}
 
	static public function lastInsertId() {
		return self::$db->lastInsertId();
	}
 
	// prepares and execute one SQL
	static public function execute($sql, $ar) {
		return self::$db->prepare($sql)->execute($ar);
	}
 
	// returns error info on db handler (not stmt handler)
	static public function error() {
		$ar = self::$db->errorInfo();
		return $ar[2] . ' (' . $ar[1] . '/' . $ar[0] . ')';
	}
 
	// returns one row fetched in FETCH_ASSOC mode
	static public function fetchAssoc($sql) {
		return self::$db->query($sql)->fetch(PDO::FETCH_ASSOC);
	}
 
	// returns one row fetched in FETCH_NUM mode
	static public function fetchNum($sql) {
		return self::$db->query($sql)->fetch(PDO::FETCH_NUM);
	}
 
}

?>