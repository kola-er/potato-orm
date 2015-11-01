<?php
/**
 * This is an interface for package Kola\PotatoOrm\Model.
 *
 * @package Kola\PotatoOrm\ModelInterface
 * @author  Kolawole ERINOSO <kola.erinoso@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Kola\PotatoOrm;

interface ModelInterface
{
	/**
	 * Delete a record from the database table
	 *
	 * @param int $record Index of record to be deleted
	 * @return bool|string
	 */
	public static function destroy($record);

	/**
	 * Get all the records in a database table
	 *
	 * @return string|object
	 */
	public static function getAll();

	/**
	 * Get a record in a database table
	 *
	 * @param int $record Index of record to get
	 * @return string|object
	 */
	public static function find($record);

	/**
	 * Insert or Update a record in a database table
	 *
	 * @return bool|string
	 */
	public function save();
}
