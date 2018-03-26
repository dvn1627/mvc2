<?php
namespace test1;
use PDO as PDO;
class bdtools
{
	private static $_instance = null;
	private function __construct() {
	}
	protected function __clone() {
	}

	static public function connect() {
		if (is_null(self::$_instance)) {
			$file = file_get_contents('../config_db.json');
			$config = json_decode($file);
			$dsn = 'mysql:host='.$config->host . ';dbname=' . $config->database . ';charset=utf8;';
			$options = array(
				PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
				PDO::MYSQL_ATTR_INIT_COMMAND=>'set names "utf8"',
				);
			try {
				$pdo = new PDO($dsn, $config->login, $config->pass, $options);
				self::$_instance = $pdo;
				return self::$_instance;
			} catch (PDOException $e) {
				echo "<small>Error connecting to DB</small>";
				return false;
			}
		} else {
			return self::$_instance;
		}
	}

}