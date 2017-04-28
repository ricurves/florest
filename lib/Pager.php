<?php
namespace lib;

class Pager
{
	public $totalCount;
	public $first;
	public $prev;
	public $page;
	public $next;
	public $last;
	public $pageCount;
	public $pageSize;
	public $offset;
	public $defaultSort;
	public $sort;

	function __construct()
	{
		require 'config/config.php';
		$this->pageSize = $appConf['pageSize'];
	}

	public function init($totalCount, $params)
	{
		$this->totalCount = $totalCount;
		$this->sort = null;
		$this->defaultSort = null;

		// Parsing page parameter, if not set then assume it page one
		if (isset($params['page']))
			$this->page = (int) $params['page'];
		else
			$this->page = 1;

		// Parsing sort parameter
		if (isset($params['sort']))
		{
			$explodedSort = explode(' ', $params['sort']);
			$this->sort = preg_replace('/[^\w-]/', '', $explodedSort[0]);
		}

		$this->first = 1;

		if ($totalCount == 0)
			$this->last = 1;
		else
			$this->last = ceil($totalCount / $this->pageSize);
		
		$this->pageCount = $this->last;

		// Prevent user accessing page outside of the range
		if ($this->page < 1)
			$this->page = 1;
		elseif ($this->page > $this->last)
			$this->page = $this->last;

		// Calculate previous page number
		if ($this->page == 1)
		{
			$this->first = null;
			$this->prev = null;
		}
		else
			$this->prev = $this->page - 1;

		// Calculate next page number
		if ($this->page == $this->last)
		{
			$this->next = null;
			$this->last = null;
		}
		else
			$this->next = $this->page + 1;

		// Calculate the offset
		$this->offset = (($this->page - 1) * $this->pageSize);
	}

	public function query()
	{
		$sort = null;

		// Check wether defaultSort property is set
		if ($this->sort)
			$sort = $this->sort;
		elseif ($this->defaultSort)
			$sort = $this->defaultSort;

		// Generate ORDER BY query
		$orderQuery = '';
		if ($sort)
		{
			$firstChar = substr($sort, 0, 1);

			// Check wether sorting is ascending or descending
			if ($firstChar == '-')
				$orderQuery = ' ORDER BY ' . substr($sort, 1) . ' DESC';
			else
				$orderQuery = ' ORDER BY ' . $sort;
		}
		

		return $orderQuery . " LIMIT {$this->offset}, {$this->pageSize}";
	}

	public function generate($input)
	{
		$i = 0;
		$rowCount = count($input);

		if ($rowCount)
		{
			while ($i < $rowCount)
			{
				$input[$i]['_serial'] = $this->offset + $i + 1;
				$i++;
			}
		}
		
		$output = [
			'items' => $input,
			'pager' => [
						'totalCount' => $this->totalCount,
						'rowCount' => $rowCount,
						'pageCount' => $this->pageCount,
						'first' => $this->first,
						'prev' => $this->prev,
						'page' => $this->page,
						'next' => $this->next,
						'last' => $this->last,
						'pageSize' => $this->pageSize,
						'offset' => $this->offset,
			],
		];

		return $output;
	}

}