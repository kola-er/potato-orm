<?php
/**
 * This exception package handles encounter with empty database table.
 *
 * @package Kola\PotatoOrm\Exception\EmptyTableException
 * @author  Kolawole ERINOSO <kola.erinoso@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Kola\PotatoOrm\Exception;

class EmptyTableException extends \PDOException
{
	/**
	 * Handle encounter with empty database table
	 *
	 * @return string
	 */
    public function message()
    {
        return 'The table is empty.';
    }
}
