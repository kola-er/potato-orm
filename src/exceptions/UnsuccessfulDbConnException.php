<?php
/**
 * This exception package handles unsuccessful database connection.
 *
 * @package Kola\PotatoOrm\Exception\UnsuccessfulDbConnException
 * @author  Kolawole ERINOSO <kola.erinoso@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Kola\PotatoOrm\Exception;

class UnsuccessfulDbConnException extends \PDOException
{
	/**
	 * Handle unsuccessful database connection
	 *
	 * @return string
	 */
    public function message()
    {
		return 'The database connection was not successful';
    }
}
