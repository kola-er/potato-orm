<?php
/**
 * This exception package handles encounter with non-existent record.
 *
 * @package Kola\PotatoOrm\Exception\RecordNotFoundException
 * @author  Kolawole ERINOSO <kola.erinoso@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Kola\PotatoOrm\Exception;

class RecordNotFoundException extends \PDOException
{
	/**
	 * Handle encounter with non-existent record
	 *
	 * @return string
	 */
	public function message()
	{
		return 'This record does not exist.';
	}
}