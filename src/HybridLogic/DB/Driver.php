<?php

namespace HybridLogic\DB;

/**
 * Generic Database Driver
 *
 * An abstract class providing an interface for database
 * drivers with some utility methods provided.
 *
 * @package DB
 * @author Luke Lanchester <luke@lukelanchester.com>
 **/
abstract class Driver {


	/**
	 * @var array Config
	 **/
	protected $config = array();


	/**
	 * Constructor
	 *
	 * @param array Driver options
	 * @return void
	 **/
	public function __construct(array $config = null) {
		if($config !== null) $this->config = array_merge($this->config, $config);
	} // end func: __construct



	/**
	 * Execute an SQL statement
	 *
	 * @param string SQL
	 * @param string Query Type
	 * @param string Result Type
	 * @return mixed Result
	 **/
	abstract public function query($sql, $query_type = null, $result_type = null);



	/**
	 * Escape a Value
	 *
	 * @param string Raw value
	 * @return string Escaped value
	 **/
	abstract public function escape($val);



	/**
	 * Combine an SQL query and values to escape
	 *
	 * @param string Raw SQL
	 * @return string Prepared SQL
	 * @todo
	 **/
	public function prepare($query, $args = null) {

		if(strlen($query) === 0) return;

		if(!is_array($args)) {
			$args = func_get_args();
			array_shift($args);
		}

		$query = str_replace(array("'?'", '"?"'), '?', $query);
		$query = preg_replace('/\?/', '%s', $query);
		$args = array_map(array($this, 'escape'), $args);

		return @vsprintf($query, $args);

	} // end func: prepare



} // end class: Driver