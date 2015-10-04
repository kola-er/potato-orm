<?php
/**
 * This helper package makes a database connection for package Kola\PotatoOrm\Model.
 *
 * @package Kola\PotatoOrm\Helper\DbConn
 * @author  Kolawole ERINOSO <kola.erinoso@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Kola\PotatoOrm\Helper;

use Kola\PotatoOrm\Exception\UnsuccessfulDbConnException as ConnEx;
use \PDO;

final class DbConn extends PDO implements DbConnInterface
{
    /**
     * Override the parent class PDO constructor to prevent instantiation-argument requirement
     */
    public function __construct()
    {
    }

    /**
     * Make a database connection
     *
     * @return PDO|string
     */
    public static function connect()
    {
        self::loadDotenv();

        try {
            $dbConn = new PDO(getenv('DB_ENGINE') . ':host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
            $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (ConnEx $e) {
            return $e->message();
        }

        return $dbConn;
    }

    /**
     * Load Dotenv to grant getenv() access to environment variables in .env file
     */
    private static function loadDotenv()
    {
        $dotenv = new \Dotenv\Dotenv(__DIR__ . '/../..');
        $dotenv->load();
    }
}
