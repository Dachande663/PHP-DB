<?php

namespace HybridLogic\DB\Driver;

/**
 * PDO Database Driver
 *
 * A driver wrapping around the PDO connection library.
 *
 * @package DB
 * @author Luke Lanchester <luke@lukelanchester.com>
 **/
class PDO extends \HybridLogic\DB\Driver {


	/**
	 * @var array Config
	 **/
	protected $config = array(
		'datasource' => null,
		'username'   => null,
		'password'   => null,
	);


	/**
	 * @var PDO Database connection
	 **/
	private $db;


	/**
	 * Connect to database
	 *
	 * @return void
	 **/
	public function connect() {

		if($this->db !== null) return $this->db;

		try {

			$this->db = new \PDO(
				$this->config['datasource'],
				$this->config['username'],
				$this->config['password']
			);

			$this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

			return true;

		} catch(\PDOException $e) {
			throw new \HybridLogic\DB\Exception\ConnectionException($e);
		}

	} // end func: connect



	/**
	 * Execute an SQL statement
	 *
	 * @param string SQL
	 * @param string Query Type
	 * @param string Result Type
	 * @return mixed Result
	 **/
	public function query($sql, $query_type = null, $result_type = null) {

		if($this->db === null) $this->connect();

		try {

			// SELECT
			if($query_type === \HybridLogic\DB::SELECT) {

				$stmt = $this->db->query($sql);

				if($result_type === null) {
					$results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
				} else {
					$results = $stmt->fetchAll(\PDO::FETCH_CLASS, $result_type);
				}

				return $results;

			}

			// INSERT, UPDATE & DELETE
			$rows_affected = $this->db->exec($sql);

			if($query_type === \HybridLogic\DB::INSERT) {
				$result = array(
					'insert_id'     => $this->db->lastInsertId(),
					'rows_affected' => $rows_affected,
				);
			} else {
				$result = $rows_affected;
			}

			return $result;

		} catch(\PDOException $e) {
			throw new \HybridLogic\DB\Exception\QueryException($e);
		}

	} // end func: query



	/**
	 * Escape a Value
	 *
	 * @param string Raw value
	 * @return string Escaped value
	 **/
	public function escape($val) {
		if($this->db === null) $this->connect();
		return $this->db->quote($val);
	} // end func: escape



} // end class: Driver_PDO