<?php
namespace models;

use lib\Model;

class Pendapatan extends Model
{
	public $tableName = 'pendapatan';

	public function listData($params)
	{
		$countSql = 'SELECT COUNT(*) FROM ' . $this->tableName;
		//$stmt = $this->db->prepare($sql);
		//$stmt->execute();
		$countStmt = $this->db->query($countSql);
		return $countStmt->fetchColumn();
	}
}

?>