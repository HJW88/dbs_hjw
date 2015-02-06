<?php
/**
 * Date: 06/02/15
 * Time: 19:51
 * Author: HJW88
 */
class db {

    /*** Declare instance ***/
    private static $instance = NULL;

    /*** The last sql result ***/
    public $last;

    /**
     * the constructor is set to private so
     * so nobody can create a new instance using new
     */
    private function __construct()
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
     * Execute the sql query and store result into $last
     *
     * @param $queryStr SQL statement
     */
    final public function executeQuery($queryStr)
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
    final protected function insertRecords($table, $data)
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
    final protected function deleteRecords($table, $condition, $limit)
    {
        $limit = ($limit == '') ? '' : ' LIMIT ' . $limit;
        $delete = "DELETE FROM {$table} WHERE {$condition} {$limit}";
        $this->executeQuery($delete);
    }

    /**
     * Update records in the database
     * @param String the table
     * @param array of changes field => value
     * @param String the condition
     * @return bool
     */
    final protected function updateRecords($table, $changes, $condition)
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

        return true;
    }

    /**
     * @param $table
     * @param $condition
     * @return bool
     */
    final protected function selectRecords($table, $condition){
        $select = "SELECT * FROM " . $table ;
        if ($condition != '') {
            $select .= "WHERE " . $condition;
        }

        $this->executeQuery($select);

        return true;

    }

    /**
     * @return string
     */
    public function __toString(){
        return 'Model: '. get_class($this) . json_encode($this);
    }


}



