<?php
/**
 * This is an ORM package that manages the persistence of database CRUD operations.
 *
 * @package Kola\PotatoOrm\Model
 * @author  Kolawole ERINOSO <kola.erinoso@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Kola\PotatoOrm;

use \PDOException;
use Kola\PotatoOrm\Helper\DbConn;
use Kola\PotatoOrm\Helper\Backbone;
use Kola\PotatoOrm\Exception\EmptyTableException;
use Kola\PotatoOrm\Exception\RecordNotFoundException;
use Kola\PotatoOrm\Exception\TableDoesNotExistException;

abstract class Model
{
    /**
     * @var array Array for holding properties set with magic method __set()
     */
    protected $record = [];

    /**
     * Set property dynamically
     *
     * @param string $field Property set dynamically
     * @param string $value Value of property set dynamically
     */
    public function __set($field, $value)
    {
        $this->record[$field] = $value;
    }

    /**
     * Provide a read access to protected $record array
     *
     * @return array $record Array of variables set dynamically with method __set()
     */
    public function getRecord()
    {
        return $this->record;
    }

    /**
     * Delete a record from the database table
     *
     * @param int $record Index of record to be deleted
     * @return bool|string
     */
    public static function destroy($record)
    {
		$table = Backbone::getTable(get_called_class());

        try {
            $dbConn = DbConn::connect();
            $query = $dbConn->prepare('DELETE FROM ' . $table . ' WHERE id= ' . $record);
            $query->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        } finally {
            $dbConn = null;
        }

        $check = $query->rowCount();

        if ($check) {
            return $check;
        } else {
            throw new RecordNotFoundException;
        }
    }

    /**
     * Get all the records in a database table
     *
     * @return string|object
     */
    public static function getAll()
    {
		$table = Backbone::getTable(get_called_class());

        try {
            $dbConn = DbConn::connect();
            $query = $dbConn->prepare('SELECT * FROM ' . $table);
            $query->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        } finally {
            $dbConn = null;
        }

        if ($query->rowCount()) {
            return $query->fetchAll(DbConn::FETCH_ASSOC);
        } else {
            throw new EmptyTableException;
        }
    }

    /**
     * Get a record in a database table
     *
     * @param int $record Index of record to get
     * @return string|object
     */
    public static function find($record)
    {
        $table = Backbone::getTable(get_called_class());

        try {
            $dbConn = DbConn::connect();
            $query = $dbConn->prepare('SELECT * FROM ' . $table . ' WHERE id= ' . $record);
            $query->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        } finally {
            $dbConn = null;
        }

        if ($query->rowCount()) {
            $found = new static;
            $found->dbData = $query->fetch(DbConn::FETCH_ASSOC);

            return $found;
        } else {
            throw new RecordNotFoundException;
        }
    }

    /**
     * Get a record in the database
     *
     * @param string $field Field name to search under
     * @param string $value Field value to search for
     * @return string|object
     */
    public static function where($field, $value)
    {
		$table = Backbone::getTable(get_called_class());

        try {
            $dbConn = DbConn::connect();
            $sql = 'SELECT * FROM ' . $table . ' WHERE ' . $field . '=' . '"' . $value . '"';
            $query = $dbConn->prepare($sql);
            $query->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        } finally {
            $dbConn = null;
        }

        if ($query->rowCount()) {
            $found = new static;
            $found->dbData = $query->fetch(DbConn::FETCH_ASSOC);

            return $found;
        } else {
            throw new RecordNotFoundException;
        }
    }

    /**
     * Insert or Update a record in a database table
     *
     * @return bool|string
     */
    public function save()
    {
		$table = Backbone::getTable(get_called_class());

        try {
            $dbConn = DbConn::connect();

            if (isset($this->record['dbData']) && is_array($this->record['dbData'])) {
                $sql = 'UPDATE ' . $table . ' SET ' . Backbone::tokenize(implode(',', Backbone::joinKeysAndValuesOfArray($this->record)), ',') . ' WHERE id=' . $this->record['dbData']['id'];
                $query = $dbConn->prepare($sql);
                $query->execute();
            } else {
                $sql = 'INSERT INTO ' . $table . ' (' . Backbone::tokenize(implode(',', array_keys($this->record)), ',') . ')' . ' VALUES ' . '(' . Backbone::tokenize(implode(',', Backbone::generateUnnamedPlaceholders($this->record)), ',') . ')';
                $query = $dbConn->prepare($sql);
                $query->execute(array_values($this->record));
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        } finally {
            $dbConn = null;
        }

        return $query->rowCount();
    }


}
