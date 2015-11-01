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

class DbConn extends PDO
{
	/**
	 * Handle DB Connection
	 */
    public function __construct()
    {
        $this->loadDotenv();

		$engine = getenv('DB_ENGINE');
		$host = getenv('DB_HOST');
		$dbname = getenv('DB_DATABASE');
		$port= getenv('DB_PORT');
		$user = getenv('DB_USERNAME');
		$password = getenv('DB_PASSWORD');

		try {
			if ($engine == 'pgsql') {
				parent::__construct($engine . ':host=' . $host . ';port=' . $port . ';dbname=' . $dbname . ';user=' . $user . ';password=' . $password);
			} elseif ($engine == 'mysql') {
				parent::__construct($engine . ':host=' . $host . ';dbname=' . $dbname . ';charset=utf8mb4', $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
								PDO::ATTR_PERSISTENT => false]);
			}
        } catch (\PDOException $e) {
            return 'Error in connection';
        }

    }

    /**
     * Load Dotenv to grant getenv() access to environment variables in .env file
     */
    protected function loadDotenv()
    {
		if (getenv('APP_ENV') !== 'production') {
			$dotenv = new \Dotenv\Dotenv($_SERVER['DOCUMENT_ROOT']);
			$dotenv->load();
		}
    }
}
