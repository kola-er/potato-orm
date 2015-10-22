<?php
/**
 * This is an interface for package Kola\PotatoOrm\Helper\Backbone.
 *
 * @package Kola\PotatoOrm\Helper\BackboneInterface
 * @author  Kolawole ERINOSO <kola.erinoso@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Kola\PotatoOrm\Helper;

interface BackboneInterface
{
	/**
	 * Generate unnamed placeholders depending on the number of table fields concerned
	 *
	 * @param array $record Set of affected table fields
	 * @return array $placeholder Sql statement placeholders for field values
	 */
	public static function generateUnnamedPlaceholders(array $record);

	/**
	 * Break down a delimited statement into set of string separated by comma
	 *
	 * @param string $statement Statement to be broken down
	 * @param string $delimiter Character being searched for to bring about the break down
	 * @return string Comma-separated set of string
	 */
	public static function tokenize($string, $delimiter);

	/**
	 * Create an array of elements in the format 'array_key=array_value' of the argument array supplied
	 *
	 * @param array $record Associative type of array
	 * @return array $temp New array of elements in the format 'array_key=array_value' of the argument array supplied
	 */
	public static function joinKeysAndValuesOfArray(array $record);

	/**
	 * Check for the existent of a table in the database being used
	 *
	 * @param string $table Name of table to be searched in the database
	 * @param DbConn $dbConn Database connection object
	 * @return bool
	 */
	public static function checkForTable($table, DbConn $dbConn);

	/**
	 * Map a class to a database table
	 *
	 * @param string $className Name of a class to be mapped to a table in the database
	 * @return string $table Database table successfully mapped to the class being used
	 */
	public static function mapClassToTable($className);

	/**
	 * Get the table name that maps to a given class model
	 *
	 * @param string $className Name of a class to be mapped to a table in the database
	 * @return string $table Database table successfully mapped to the class being used
	 */
	public static function getTable($className);
}
