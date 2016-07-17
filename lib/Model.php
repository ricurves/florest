<?php
namespace lib;

require 'config/db.php';

class Model
{
	public $db;
	public $tableName = 'pendapatan';
	
	function __construct() 
	{
		$this->db = $this->_connect();
		print_r($this->db);
	}

	private function _connect() 
	{
		require 'config/db.php';
		try
		{
			$db = new \PDO($dbConf['dsn'], $dbConf['username'], $dbConf['password']);
			return $db;
		}
		catch (PDOException $e)
		{
			print 'Error!: ' . $e->getMessage() . '<br/>';
		}
	}
}

?>