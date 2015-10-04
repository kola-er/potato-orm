<?php
/**
 * This exception package handles encounter with non-existent table.
 *
 * @package Kola\PotatoOrm\Exception\TableDoesNotExistException
 * @author  Kolawole ERINOSO <kola.erinoso@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Kola\PotatoOrm\Exception;

class TableDoesNotExistException extends \PDOException
{
	/**
	 * Handle encounter with non-existent table
	 *
	 * @return string
	 */
	public function message()
	{
		return 'Table does not exist yet!!! Create a table with the name of the corresponding class in lowercase. Feel free to pluralize the name, but irregular plurals are not supported.';
	}
}
