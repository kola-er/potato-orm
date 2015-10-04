<?php
/**
 * This is an interface for package helpers package Kola\PotatoOrm\Helper\DbConn
 *
 * @package Kola\PotatoOrm\Helper\DbConnInterface
 * @author  Kolawole ERINOSO <kola.erinoso@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Kola\PotatoOrm\Helper;

interface DbConnInterface
{
	/**
	 * Make a database connection
	 *
	 * @return PDO|string
	 */
	public static function connect();
}
