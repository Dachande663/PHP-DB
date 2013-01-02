<?php

include './autoload.php';

class PDOTest extends PHPUnit_Framework_TestCase {


	/**
	 * @var string DB name
	 **/
	private $database_name = 'myapp_test';


	/**
	 * @var string DB username
	 **/
	private $database_username = 'root';


	/**
	 * @var string DB password
	 **/
	private $database_password = 'root';


	/**
	 * Test Invalid Connection
	 *
	 * @return void
	 * @expectedException \HybridLogic\DB\Exception\ConnectionException
	 **/
	public function testErrorConnecting() {

		$db = new \HybridLogic\DB\Driver\PDO(array(
			'datasource' => 'mysql:host=localhost;dbname=invalid_db_name',
			'username'   => 'wrong_username',
			'password'   => 'wrong_password',
		));

		$db->connect();

	} // end func: testErrorConnecting



	/**
	 * Test Connection
	 *
	 * @return void
	 **/
	public function testConnect() {

		$db = new \HybridLogic\DB\Driver\PDO(array(
			'datasource' => "mysql:host=localhost;dbname={$this->database_name}",
			'username'   => $this->database_username,
			'password'   => $this->database_password,
		));

		$result = $db->connect();

		$this->assertTrue($result);

		return $db;

	} // end func: testConnect



	/**
	 * Test escaping strings
	 *
	 * @param string String to escape
	 * @param string Expected escaped string
	 * @param DB
	 * @return void
	 * @depends testConnect
	 * @dataProvider providerEscape
	 **/
	public function testEscape($string, $expected, $db) {
		$this->assertEquals($expected, $db->escape($string));
	} // end func: testEscape



	/**
	 * Test preparing strings
	 *
	 * @param string String to prepare
	 * @param array Prepare vars
	 * @param string Expected SQL
	 * @param DB
	 * @return void
	 * @depends testConnect
	 * @dataProvider providerPrepare
	 **/
	public function testPrepare($string, $vars, $expected, $db) {
		$this->assertEquals($expected, $db->prepare($string, $vars));
	} // end func: testEscape



	/**
	 * Escape strings provider
	 *
	 * @return array Strings
	 **/
	public function providerEscape() {
		return array(
			array("hello", "'hello'"),
			array("hello world", "'hello world'"),
			array("It's me!", "'It\'s me!'"),
			array(123.45, "'123.45'"),
		);
	} // end func: providerEscape



	/**
	 * Prepare strings provider
	 *
	 * @return array Strings
	 **/
	public function providerPrepare() {
		return array(
			array(
				'SELECT * FROM table_name',
				array(),
				"SELECT * FROM table_name",
			),
			array(
				'SELECT * FROM table_name WHERE field_name = ?',
				array('Field Value'),
				"SELECT * FROM table_name WHERE field_name = 'Field Value'",
			),
			array(
				'SELECT * FROM table_name WHERE field_one = ? AND field_two = ?',
				array('one', 'two'),
				"SELECT * FROM table_name WHERE field_one = 'one' AND field_two = 'two'",
			),
		);
	} // end func: providerPrepare



} // end class: PDOTest