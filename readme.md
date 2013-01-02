DB Connection Library
=====================

A driver-agnostic database library for PHP providing
convenient methods for escaping, preparing and executing
statements.

[![Build Status](https://travis-ci.org/Dachande663/PHP-DB.png)](https://travis-ci.org/Dachande663/PHP-DB)


0.0 Table of Contents
---------------------

* Introduction
* Examples
* Running Tests
* Troubleshooting
* Changelog


1.0 Introduction
----------------

This library provides a simple way to connect to and query
databases, regardless of the underlying connection driver
used i.e. PDO or MySQLi.

HL\DB handles normalizing preparing data and parsing
results. It currently includes just a PDO driver but
additional libraries will be added.


2.0 Examples
------------

Examples can be found in ./example.php.


3.0 Running Tests
-----------------

phpunit tests

Note that the test suite is currently incomplete.


4.0 Troubleshooting
-------------------

@todo


5.0 Changelog
-------------

* **[2012-12-08]** Initial Version
* **[2013-01-02]** First Release
