<?php
namespace models;

use lib\Model;

class Pendapatan extends Model
{
	public $tableName = 'pendapatan';

	public function listData($params)
	{
		// Count query for paging purpose ===============================
		$countSql = 'SELECT COUNT(*) FROM ' . $this->tableName;
		$countStmt = $this->db->prepare($countSql);
		$countStmt->execute();

		$totalCount = $countStmt->fetchColumn();
		$this->pager->init($totalCount, $params);
		$this->pager->defaultSort = '-tanggal';
		// ==============================================================

		// Main query
		$sql = 'SELECT * FROM ' . $this->tableName;

		// Add paging & sorting to the main query
		$sql .= $this->pager->query($sql);

		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$errorInfo = $stmt->errorInfo();

		if ($errorInfo[1])
			return $errorInfo;
		else
		{
			$items = $stmt->fetchAll();
			return $this->pager->generate($items); 
		}
	}

}

?>