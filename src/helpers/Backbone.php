<?php
/**
 * This helper package holds all the essential methods
 * upon which package Kola\PotatoOrm\Model rely upon
 * for full functionality.
 *
 * @package Kola\PotatoOrm\Helper\Backbone
 * @author  Kolawole ERINOSO <kola.erinoso@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Kola\PotatoOrm\Helper;

use Kola\PotatoOrm\Exception\TableDoesNotExistException;

class Backbone implements BackboneInterface
{
    /**
     * Add or remove 's' from the end of a word
     *
     * @param string $word
     * @return string $word
     */
    public static function addOrRemoveS($word)
    {
        $arrayOfCharInTable = str_split($word);

        if ($arrayOfCharInTable[count($arrayOfCharInTable) - 1] === 's') {
            array_pop($arrayOfCharInTable);
            $word = implode($arrayOfCharInTable);
        } else {
            $word .= 's';
        }

        return $word;
    }

    /**
     * Generate unnamed placeholders depending on the number of table fields concerned
     *
     * @param array $record Set of affected table fields
     * @return array $placeholder Sql statement placeholders for field values
     */
    public static function generateUnnamedPlaceholders(array $records)
    {
        $placeholder = [];

        foreach ($records as $record) {
            array_push($placeholder, '?');
        }

        return $placeholder;
    }

    /**
     * Break down a delimited statement into set of string separated by comma
     *
     * @param string $statement Statement to be broken down
     * @param string $delimiter Character being searched for to bring about the break down
     * @return string Comma-separated set of string
     */
    public static function tokenize($string, $delimiter)
    {
        $result = '';
        $token = strtok($string, $delimiter);
        $result .= $token;

        while ($token) {
            $token = strtok($delimiter);
            $result .= ',' . $token;
        }

        return chop($result, ',');
    }

    /**
     * Create an array of elements in the format 'array_key=array_value' of the argument array supplied
     *
     * @param array $record Associative type of array
     * @return array $temp New array of elements in the format 'array_key=array_value' of the argument array supplied
     */
    public static function joinKeysAndValuesOfArray(array $record)
    {
        $temp = [];
        for ($i = 1; $i < count($record); $i++) {
            $value = array_values($record)[$i];

            if (is_null($value)) {
                $value = 'NULL';
            } else {
                $value = "'" . $value . "'";
            }

            array_push($temp, array_keys($record)[$i] . '=' . $value);
        }

        return $temp;
    }

    /**
     * Check for the existence of a table in the database being used
     *
     * @param string $table Name of table to be searched in the database
     * @param DbConn $dbConn Database connection object
     * @return bool
     */
    public static function checkForTable($table, DbConn $dbConn)
    {
        try {
            $result = $dbConn->query('SELECT 1 FROM ' . $table . ' LIMIT 1');
        } catch (\PDOException $e) {
            return false;
        } finally {
            $dbConn = null;
        }

        return $result !== false;
    }

    /**
     * Map a class to a database table
     *
     * @param string $className Name of a class to be mapped to a table in the database
     * @return string $table Database table successfully mapped to the class being used
     */
    public static function mapClassToTable($className)
    {
        $demarcation = strrpos($className, '\\', -1);

        if ($demarcation !== false) {
            $table = strtolower(substr($className, $demarcation + 1));
        } else {
            $table = strtolower($className);
        }

		$dbConn = new DbConn;

        if ($table == 'user' || (! self::checkForTable($table, $dbConn))) {
            $table = self::addOrRemoveS($table);

            if (! self::checkForTable($table, $dbConn)) {
                throw new TableDoesNotExistException;
            }
        }

        return $table;
    }

    /**
     * Get the table name that maps to a given class model
     *
     * @param string $className Name of a class to be mapped to a table in the database
     * @return string $table Database table successfully mapped to the class being used
     */
    public static function getTable($className)
    {
        try {
            $table = self::mapClassToTable($className);
        } catch (TableDoesNotExistException $e) {
            return $e->message();
        }

        return $table;
    }
}
