<?php
namespace lib;

class Model
{
	public $db;
	public $tableName;
	public $pager;
	
	function __construct() 
	{
		$this->db = $this->_connect();
		$this->pager = new Pager;
	}

	public function _connect() 
	{
		require 'config/config.php';
		$db = new \PDO($dbConf['dsn'] . ';charset=' . $dbConf['charset'], $dbConf['username'], $dbConf['password']);
		return $db;
	}

	public function findAll($params = null)
	{
		$sql = 'SELECT * FROM ' . $this->tableName;

		if ($params)
			$sql .= ' ' . $params;

		return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function findOne($id)
	{
		$sql = 'SELECT * FROM ' . $this->tableName . ' WHERE id = ?';
		$stmt = $this->db->prepare($sql);
		$stmt->execute([$id]);
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	public function delete($id)
	{
		$sql = 'DELETE FROM ' . $this->tableName . ' WHERE id = ?';
		$stmt = $this->db->prepare($sql);
		$stmt->execute([$id]);
		
		if ($stmt->rowCount() >= 1)
			return true;
		else
			return false;
	}
}

?>