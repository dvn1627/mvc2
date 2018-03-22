<?php

namespace test1;

class Model
{
	protected $fields = [];
	protected $values = [];
	protected $table;

	protected function query($sql)
	{
		$pdo = bdtools::connect();
        $ps = $pdo->prepare($sql);
		try {
			$ps->execute();
		} catch (PDOException $e) {
			return $e->message;
        }
        return 0;
	}

	protected function now()
	{
		$date = new \DateTime();
		return $date->format('Y-m-d H:i:s');
	}

	public function getArray(array $data)
	{
		$table = $data['table'];
		$values = isset($data['values']) ? implode(',', $data['values']) : '*';
		$where = '';
		if (isset($data['where'])) {
			$where = ' where ';
			$first = true;
			foreach ($data['where'] as $k => $w) {
				$where .= $first ? '' : ' AND ';
				if (is_string($w)) {
					$where .= $w;
				} elseif (is_array($w) && count($w) == 2) {
					$where .= $w[0] . '=' . '"' . $w[1] . '"';
				} elseif (is_array($w) && count($w) == 3) {
					$where .= $w[0] . $w[1] . '"' . $w[2] . '"';
				} else {
					return false;
				}
				$first = false;
			}
		}
		$sql = 'select ' . $values . ' from ' . $table . $where;
		$pdo = bdtools::connect();
		$ps = $pdo->prepare($sql);
		try {
			$ps->execute();
		} catch (PDOException $e) {
			return $e->message;
		}
        return $ps->fetchAll();
	}

	/* example data:
	$data [
		'table'		=> 'users',
		'fields'	=> ['email', 'password', 'created_at'],
		'values'	=> [
			['admin@gmail.com', 'fvlenkgvn', '2018-03-18 15:00:00'],
		],
	];
	*/
	protected function insert(array $data)
	{
		$table = $data['table'];
		$fields = implode(', ', $data['fields']);
		$values = '';
		$firstRow = true;
		foreach ($data['values'] as $value) {
			$values .= $firstRow ? '' : ', ';
			$values .= '(';
			$first = true;
			foreach ($value as $v) {
				$values .= $first ? '' : ', ';
				$values .= '"' . addslashes($v) . '"';
				$first = false;
			}
			$values .= ')';
			$firstRow = false;
		}
		$sql = 'insert into ' . $table . '(' . $fields . ') values ' . $values;
		$pdo = bdtools::connect();
		$ps = $pdo->prepare($sql);
		try {
			$ps->execute();
		} catch (PDOException $e) {
			return $e->message;
		}
        return 0;
	}

	public function set($field, $value)
	{
		if (in_array($field, $this->fields) && $field != "id") {
			$this->values[$field] = $value;
			return 0;
		}
		return 1;
	}

	public function get($field)
	{
		if (in_array($field, $this->fields)) {
			return isset($this->values[$field]) ? $this->values[$field] : null;
		}
		return false;
	}

	public function save()
	{
		if (in_array('created_at', $this->fields) && !isset($this->fields['created_at'])) {
			$this->values['created_at'] = $this->now();
		}
		if (in_array('updated_at', $this->fields)) {
			$this->values['updated_at'] = $this->now();
		}
		if (isset($this->values['id'])) {
			$place = '';
			$first = true;
			foreach ($this->values as $k => $v) {
				$place .= $first ? '' : ', ';
				$place .= $k . '=:' .$k;
				$first = false;
			}
			$sql = 'update ' . $this->table . ' set ' . $place . ' where id=:id';
			$pdo = bdtools::connect();
			$ps = $pdo->prepare($sql);
			try {
				$ps->execute($this->values);
			} catch (PDOException $e) {
				return $e->message;
			}
			return 0;
		} else {
			$keys = array_keys($this->values);
			$fields = implode(', ', $keys);
			$places = implode(', ', array_map(function($key){
				return ':' . $key;
			}, $keys));
			$values = array_values($this->values);
			$sql = 'insert into ' . $this->table . '(' . $fields . ') values (' . $places . ')';
			$pdo = bdtools::connect();
			$ps = $pdo->prepare($sql);
			try {
				$ps->execute($this->values);
			} catch (PDOException $e) {
				return $e->message;
			}
			$this->values['id'] = $pdo->lastInsertId();
			return 0;
		}
	}

	public static function find($model, $id)
	{
		$new = new $model;
		$table = $new->table;
		$sql = "select * from {$table} where id=:id";
		$pdo = bdtools::connect();
		$ps = $pdo->prepare($sql);
		try {
			$ps->execute(['id' => $id]);
		} catch (PDOException $e) {
			return $e->message;
		}
		$data = $ps->fetchAll();
		if (count($data) == 0) {
			return false;
		}
		foreach ($data[0] as $k => $v) {
			$new->values[$k] = $v;
		}
		return $new;
	}

	public function delete()
	{
		if (!isset($this->values['id'])) {
			return 1;
		}
		$sql = "delete from {$this->table} where id=" . $this->values['id'];
		$pdo = bdtools::connect();
		$ps = $pdo->prepare($sql);
		try {
			$ps->execute();
		} catch (PDOException $e) {
			return $e->message;
		}
		return 0;
	}
}