<?php

include './autoload.php';


// Connect
	$pdo = new HybridLogic\DB\Driver\PDO(array(
		'datasource' => 'mysql:host=localhost;dbname=myapp_test',
		'username'   => 'root',
		'password'   => 'root',
	));
	$db = new HybridLogic\DB($pdo);


// Setup
	$db->query('DROP TABLE IF EXISTS `users`');

	$db->query("
		CREATE TABLE `users` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`user_name` VARCHAR(50) DEFAULT NULL,
			`date_of_birth` DATE DEFAULT NULL,
			`gender` ENUM('male', 'female', 'unknown') DEFAULT 'unknown',
			PRIMARY KEY(`id`)
		);
	");


// Insert
	$sql = $db->prepare('
		INSERT INTO `users` (`user_name`, `date_of_birth`, `gender`) VALUES
		(?, ?, ?),
		(?, ?, ?),
		(?, ?, ?),
		(?, ?, ?),
		(?, ?, ?),
		(?, ?, ?)
		',
		'Tim Berners-Lee', '1955-06-08', 'male',
		'Steve Jobs', '1955-02-24', 'male',
		'Marissa Mayer', '1975-05-30', 'female',
		'Bill Gates', '0000-00-00', 'male',
		'Rasmus Lerdorf', '1968-10-22', 'male',
		'Guido van Rossum', '1956-01-31', 'male'
	);
	$result = $db->query($sql, HybridLogic\DB::INSERT);
	echo "<p>Rows inserted: {$result['rows_affected']}</p>";


// Update
	$sql = $db->prepare('
		UPDATE `users`
		SET `date_of_birth` = ?
		WHERE `user_name` = ?
	', '1955-10-28', 'Bill Gates');

	$result = $db->query($sql, HybridLogic\DB::UPDATE);
	echo "<p>Rows updated: {$result}</p>";


// Delete
	$sql = $db->prepare('
		DELETE FROM `users`
		WHERE `date_of_birth` BETWEEN ? AND ?
	', '1955-06-01', '1955-12-31');

	$result = $db->query($sql, HybridLogic\DB::DELETE);
	echo "<p>Rows deleted: {$result}</p>";


// Select
	$sql = $db->prepare('
		SELECT *
		FROM `users`
		WHERE date_of_birth >= ? AND gender = ?
	', '1955-12-31', 'male');

	class AppUser {
		public function printInfo() {
			return "{$this->user_name} (Born {$this->date_of_birth})";
		}
	}

	$users = $db->query($sql, HybridLogic\DB::SELECT, 'AppUser');

	echo '<h4>Users</h4><ul>';
	foreach($users as $user) {
		echo "<li>{$user->printInfo()}</li>";
	}
	echo '</li>';
