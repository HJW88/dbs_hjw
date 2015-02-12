<?php
/**
 * Date: 06/02/15
 * Time: 19:51
 * Author: HJW88
 */

/**
 * Class db
 * This class represent the database connection, singleton
 * And it does all db operation
 * This can save reduplicate sql query writing
 */
class DBModel {

    /*** Declare db instance ***/
    private static $instance = NULL;

    /*** The last sql result ***/
    public $result;

    /**
     * the constructor is set to private so
     * so nobody can create a new instance using new
     */
    public function __construct()
    {
        // do nothing
    }

    /**
     * make connection
     *
     * @return mysqli|null
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new mysqli(__DB_HOST, __DB_USER, __DB_PASS, __DB_DATABASE);
        }
        return self::$instance;
    }

    /**
     *
     * @return int|string
     */
    public function getLastInsertID(){
        return mysqli_insert_id(self::getInstance());
    }
    /***
     * @param $querystr, the sql query
     * @return mysqli_stmt, a mysql semt object
     */
    public static function getStamentObject($querystr){
        return self::getInstance()->prepare($querystr);
    }


    /**
     * @param $queryStr
     */
    final public function executeQuery($queryStr)
    {
        $result = static::getInstance()->query($queryStr);

        if ($result) {
            $this->result = $result;
//            error_log('OK executing query: ' . $queryStr);
        } else {
            error_log('Error executing query: ' . $queryStr);
        }
    }

    /**
     * Get the rows from the most recently executed query,
     * excluding cached queries
     * @return array
     */
    final function getRows()
    {
        $data = array();

        while ($row = $this->result->fetch_assoc()){
            $data[] = $row;
        }

        if (sizeof($data)!=0){
            return $data;
        } else {
            return null;
        }
    }

    /**
     * Fetch one row as assoc array
     * @return mixed
     */
    final function getRow(){
        return $this->result->fetch_assoc();
    }

    /**
     * Geht the num_rows
     * @return mixed
     */
    final function numRows()
    {
        return $this->result->num_rows;
    }

    /**
     * Gets the number of affected rows
     * @return int the number of affected rows
     */
    public function affectedRows()
    {
        return $this->result->affected_rows;
    }

    /**
     * Insert records into the database
     * @param String the database table
     * @param array data to insert field => value
     * @return bool
     */
    final public function insertRecords($table, $data)
    {
        // setup some variables for fields and values
        $fields = "";
        $values = "";

        // populate them
        foreach ($data as $f => $v) {

            $fields .= "`$f`,";
            $values .= (is_numeric($v) && (intval($v) == $v)) ? $v . "," : trim(strip_tags("'$v',"));

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
     * @return void
     */
    final public function deleteRecords($table, $condition)
    {
        $delete = "DELETE FROM {$table} WHERE {$condition}";
        $this->executeQuery($delete);
    }

    /**
     * Update records in the database
     * @param String the table
     * @param array of changes field => value
     * @param String the condition
     * @return bool
     */
    final public function updateRecords($table, $changes, $condition)
    {
        $update = "UPDATE " . $table . " SET ";
        foreach ($changes as $field => $value) {
            $update .= "`" . $field . "`='{$value}',";
        }

        // remove our trailing ,
        $update = substr($update, 0, -1);
        if ($condition != '') {
            $update .= "WHERE " . $condition;
        }

        $this->executeQuery($update);
    }

    /**
     * @param $table
     * @param $condition
     * @return bool
     */
    final public function selectRecords($table, $condition=null){
        $select = "SELECT * FROM " . $table ;
        if ($condition) {
            $select .= " WHERE " . $condition;
        }
        $this->executeQuery($select);
        return true;
    }


}




