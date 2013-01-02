<?php

namespace HybridLogic;

/**
 * Database Library
 *
 * Database connection library providing a wrapper around
 * various connection drivers (PDO, MySQLi etc).
 *
 * @package DB
 * @author Luke Lanchester <luke@lukelanchester.com>
 **/
class DB {


	/**
	 * @var string Database Query Types
	 **/
	const SELECT = 'select';
	const INSERT = 'insert';
	const DELETE = 'delete';
	const UPDATE = 'update';


	/**
	 * @var Driver DB Driver instance
	 **/
	private $driver;


	/**
	 * Constructor
	 *
	 * @param Driver DB Driver
	 * @return void
	 **/
	public function __construct($driver) {
		$this->driver = $driver;
	} // end func: __construct



	/**
	 * Execute an SQL statement
	 *
	 * Given an SQL statement, execute it against the
	 * currently defined database driver instance. Optional
	 * query and result types can be specified to alter
	 * returned data format in the following ways:
	 *
	 * INSERT:
	 *   Returns an array containing the last inserted row
	 *   id along with the number of rows affected.
	 *
	 * UPDATE/DELETE:
	 *   Returns the number of rows affected.
	 *
	 * SELECT:
	 *   Returns an array of rows. Optional result type can
	 *   cast returned rows as objects.
	 *
	 * @param string SQL
	 * @param string Query Type
	 * @param string Result Type
	 * @return mixed Result
	 **/
	public function query($sql, $query_type = null, $result_type = null) {
		return $this->driver->query($sql, $query_type, $result_type);
	} // end func: query



	/**
	 * Escape a value
	 *
	 * @param string Raw value
	 * @return string Escaped value
	 **/
	public function escape($val) {
		return $this->driver->escape($val);
	} // end func: escape



	/**
	 * Combine an SQL query and values to escape
	 *
	 * Given an SQL statement with placeholders along with
	 * a set of arguments, escape all parameters and
	 * replace in string. E.g.
	 *
	 * $db->prepare(
	 *   'SELECT * FROM table WHERE name = ? AND age = ?',
	 *   'John Smith', 27
	 * )
	 * // SELECT * FROM table WHERE name = 'John Smith' AND age = 27
	 *
	 * @param string Raw SQL
	 * @return string Prepared SQL
	 **/
	public function prepare($query) {
		$args = func_get_args();
		array_shift($args);
		return $this->driver->prepare($query, $args);
	} // end func: prepare



} // end class: DB