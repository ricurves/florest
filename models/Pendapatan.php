<?php
namespace models;

use lib\Model;

class Pendapatan extends Model
{
	public $tableName = 'pendapatan';

	public function listData($params)
	{

		// Custom query based on filter goes here
		$filterSql = '';
		if (isset($params['q']))
		{
			$q = '%' . $params['q'] . '%';
			$filterSql = ' WHERE ket LIKE :q';
		}

		// Count query for paging purpose ===============================
		$countSql = 'SELECT COUNT(*) FROM ' . $this->tableName . $filterSql;
		$countStmt = $this->db->prepare($countSql);
		$countStmt->bindParam(':q', $q);
		$countStmt->execute();

		$totalCount = $countStmt->fetchColumn();
		$this->pager->init($totalCount, $params);
		$this->pager->defaultSort = '-tanggal';
		// ==============================================================

		// Main query +++++++++++++++++++++++++++++++++++++++++++++++++++
		$sql = 'SELECT * FROM ' . $this->tableName . $filterSql;

		// Add paging & sorting to the main query
		$sql .= $this->pager->query($sql);

		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(':q', $q);
		$stmt->execute();
		$errorInfo = $stmt->errorInfo();

		if ($errorInfo[1])
			return $errorInfo;
		else
		{
			$items = $stmt->fetchAll();
			return $this->pager->generate($items); 
		}
		// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	}

}

?>