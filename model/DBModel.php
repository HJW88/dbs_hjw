<?php
/**
 * Date: 01/02/15
 * Time: 20:22
 * Author: HJW88,
 * ** Some ideas was found from Book PHP 5 E-commerce Development by Michael Peacock
 */

namespace model;

/**
 * Class Model
 * Define the base beaver and communication with Database.
 * It's an abstract class, every extended class must implement it's own method
 *
 * @package model\Model
 */
abstract class DBModel
{


    // the db connection
    private $connection = null;
    // store the last result
    private $last;

    /**
     * __construct
     */
    public function __construct()
    {
    }

    /**
     * __deconstruct,
     * automatic disconnect db
     */
    public function __deconstruct()
    {
        $this->connection->close();
    }

    /**
     * Use the default credential to connect db
     *
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $database
     * @return bool
     */
    final public function newConnection($host = 'localhost',
                                        $user = 'm2059127',
                                        $password = 'VuzCzHaZ',
                                        $database = 'm2059127')
    {
        $this->connection = new mysqli($host, $user, $password, $database);
        if (mysqli_connect_errno()) {
            error_log("DB Connection Error: " . $this->connection->error);
            return false;
        } else {
            return true;
        }

    }

    /**
     * Execute the sql query and store result into $last
     *
     * @param $queryStr SQL statement
     */
    final function executeQuery($queryStr)
    {
        if (!$result = $this->connection->query($queryStr)) {
            error_log('Error executing query: ' . $this->connection->error);
        } else {
            $this->last = $result;
        }

    }

    /**
     * Get the rows from the most recently executed query,
     * excluding cached queries
     * @return array
     */
    final function getRows()
    {
        return $this->last->fetch_array(MYSQLI_ASSOC);
    }

    /**
     * Geht the num_rows
     * @return mixed
     */
    final function numRows()
    {
        return $this->last->num_rows;
    }

    /**
     * Gets the number of affected rows
     * @return int the number of affected rows
     */
    public function affectedRows()
    {
        return $this->last->affected_rows;
    }

    /**
     * Insert records into the database
     * @param String the database table
     * @param array data to insert field => value
     * @return bool
     */
    final private function insertRecords($table, $data)
    {
        // setup some variables for fields and values
        $fields = "";
        $values = "";

        // populate them
        foreach ($data as $f => $v) {

            $fields .= "`$f`,";
            $values .= (is_numeric($v) && (intval($v) == $v)) ? $v . "," : "'$v',";

        }

        // remove our trailing ,
        $fields = substr($fields, 0, -1);
        // remove our trailing ,
        $values = substr($values, 0, -1);

        $insert = "INSERT INTO $table ({$fields}) VALUES({$values})";

        $this->executeQuery($insert);
        return true;
    }

    /**
     * Delete records from the database
     * @param String the table to remove rows from
     * @param String the condition for which rows are to be removed
     * @param int the number of rows to be removed
     * @return void
     */
    final private function deleteRecords( $table, $condition, $limit )
    {
        $limit = ( $limit == '' ) ? '' : ' LIMIT ' . $limit;
        $delete = "DELETE FROM {$table} WHERE {$condition} {$limit}";
        $this->executeQuery( $delete );
    }

    /**
     * Update records in the database
     * @param String the table
     * @param array of changes field => value
     * @param String the condition
     * @return bool
     */
    final private function updateRecords( $table, $changes, $condition )
    {
        $update = "UPDATE " . $table . " SET ";
        foreach( $changes as $field => $value )
        {
            $update .= "`" . $field . "`='{$value}',";
        }

        // remove our trailing ,
        $update = substr($update, 0, -1);
        if( $condition != '' )
        {
            $update .= "WHERE " . $condition;
        }

        $this->executeQuery( $update );

        return true;

    }

    /**
     * Save model into db
     *
     * @return mixed
     */
    abstract public function save();


}