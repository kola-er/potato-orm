<?php
/**
 * This helper package makes a database connection for package Kola\PotatoOrm\Model.
 *
 * @package Kola\PotatoOrm\Helper\DbConn
 * @author  Kolawole ERINOSO <kola.erinoso@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Kola\PotatoOrm\Helper;

use \PDO;

final class DbConn extends PDO implements DbConnInterface
{
	/**
     * Make a database connection
     *
     * @return PDO|string
     */
    public static function connect()
    {
        self::loadDotenv();

        try {
            $dbConn = new PDO(getenv('DB_ENGINE') . ':host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_DATABASE') . ';charset=utf8mb4', getenv('DB_USERNAME'), getenv('DB_PASSWORD'), [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_PERSISTENT => false]);
        } catch (\PDOException $e) {
            return 'Error in connection';
        }

        return $dbConn;
    }

    /**
     * Load Dotenv to grant getenv() access to environment variables in .env file
     */
    private static function loadDotenv()
    {
        $dotenv = new \Dotenv\Dotenv($_SERVER['DOCUMENT_ROOT']);
        $dotenv->load();
    }
}
