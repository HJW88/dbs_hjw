<?php
/**
 * Date: 09/02/15
 * Time: 22:25
 * Author: HJW88
 */

class BaseModel{

    protected $db;

    /**
     * Every model
     */
    public function __construct(){
        $this->db = new db();
    }
}